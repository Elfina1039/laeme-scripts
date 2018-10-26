class Analysis:
    #main object holding most of the data
    def __init__(self,lexel):
        self.lexel=Lexel(lexel)
        self.litterae=self.getLitterae()
        self.litDict=self.makeDict(self.litterae)
        self.substSets=self.getSubstSets()
        self.selections=[]
        self.versions=[]
        
        print("Analysis object initialized")
        
    def getLitterae(self):
        inp=[{"lit":"v", "cat":"A", "ln":1},{"lit":"e","cat":"V","ln":1},{"lit":"r","cat":"C","ln":1},{"lit":"f","cat":"C","ln":1}, {"lit":"y","cat":"A","ln":1},{"lit":"u","cat":"A","ln":1},{"lit":"rr","cat":"C","ln":2},{"lit":"ee","cat":"V","ln":2},{"lit":"ch","cat":"C","ln":2},{"lit":"c","cat":"C","ln":1}, {"lit":"l","cat":"C","ln":1}, {"lit":"a","cat":"V","ln":1},{"lit":"-","cat":"A","ln":1}]
        rsl=[]
        for i in inp:
            rsl.append(Littera(i["lit"],i["cat"],i["ln"]))
        
        return rsl
    
    def getSubstSets(self):
        inp=[set(["v","u","f"]),set(["u","e","i","y"]),set(["r","rr"]),set(["c","ch","h"]),set(["l","-"]),set(["e","a","i","-"])]
        rsl=[]
        for i in inp:
            rsl.append(SubstSet(list(i)))
        return rsl
    
    def makeDict(self,lits):
        rsl={}
        for l in lits:
            rsl[l.lit]=l
        return rsl
    
    def initialize(self):
        self.lexel.getOptions()
        self.lexel.calcPattScore()
        self.topScore=self.lexel.scores.getBest()
        print(self.topScore)
    
    def testPatterns(self,patterns):
        self.makeSelections(patterns)
        for s in self.selections:
            self.versions.append(Version(s))
        self.countValid()
        
    def makeSelection(self,pattern):
        self.selections.append(Selection(pattern,self.lexel.options))
        
    def makeSelections(self, patterns):
        for patt in patterns:
            a.makeSelection(patt)
    
    def countValid(self):
        valid=list(filter(lambda x: x.isValid, self.versions))
        print("FOUND __ " + str(len(valid)) + " __ VALID VERSION(S)")
        if(len(valid)==0):
            self.versions=[]
            self.selections=[]
           # self.testPatterns(self.lexel.patterns)
            


   
class Lexel:
    # input data - lexel, forms and  analysis options
    def __init__(self, lexel):
        self.lexel=lexel
        self.forms=self.getForms(lexel)
        self.options={}
        self.patterns=[]
        self.addedPatterns=[]
        print("Lexel initialized")
    
    def getForms(self,lexel):
        return ["elch","eche","ech","ache","ece"]
    
    def getOptions(self):
        self.patterns=list(self.patterns)
        for f in self.forms:
            self.getOption(f)
        self.patterns=set(self.patterns)
    
    def getOption(self,form):
    #filter function selecting digraphs present in the form
        def getDigraphs(x):
            if(x.ln>1 and form.find(x.lit)!=-1):
                return {"lit":x.lit, "ln":x.ln, "index":form.find(x.lit)}
            else:
                return {}
        # list for all possible split options
        options=[]
        basicSplit=list(form)
       # options.append({"split":basicSplit, "pattern":makeSlots(basicSplit)})
        digraphs=list(filter(None,map(getDigraphs,a.litterae)))
      
        # wile loop generationg splits with digraphs - to be turned in to a function and called for every combination of digraphs
        i=0
        nSplit=[]
        while(form[i:i+1]):
            d=list(filter(lambda x: x["index"]==i, digraphs))
            if(d):
                nSplit.append(form[i:i+d[0]["ln"]])
                i+=d[0]["ln"]
            else:
                nSplit.append(form[i:i+1])
                i+=1
        nOption=Option(nSplit, None);

        if(nOption.pattern.find("A")!=-1):
            options=options+nOption.vcVariants()
        else:
            options.append(nOption)
        self.options[form]=OptionSet(form,options, False, [], [])
        self.patterns=self.patterns+list(map(lambda x: x.pattern,options))
        
    def calcPattScore(self):
        rsl={}
        for p in self.patterns:
            rsl[p]=0
            for o in self.options:
                if(p in self.options[o].patterns.keys()):
                   # print(p)
                    self.options[o].patterns[p]+=1
                    rsl[p]+=1
        self.scores=Scores(rsl)
        
    def proposePattern(self, optSet, pattern, index):
        print("Adding pattern based on " + pattern)

class Littera:
    # constant data - litterae with classes and lengths
    def __init__(self, lit, cat, ln):
        self.lit=lit
        self.cat=cat
        self.ln=ln

class Option:
    # basic object holding a splitting option and pattern
    def __init__(self,split,pattern):
        self.split=split
        if(pattern):
            self.pattern=pattern
        else:
            self.pattern=self.makeSlots()
            
        
    def makeSlots(self):
        rsl=[]
        for s in self.split:
            rsl.append(a.litDict[s].cat)
        return ''.join(rsl)

    def vcVariants(self):
        # genearating multiple patterns for patterns wirh ambiguous litterae (C/V)
        rsl=[]
        # should be done for all As in the string
        cons=self.pattern.replace("A","C")
        rsl.append(Option(self.split, cons))
        vow=self.pattern.replace("A","V")
        rsl.append(Option(self.split, vow))
        return rsl

class OptionSet:
    def __init__(self, form,lst, original, split, versions):
        self.form=form
        self.list=lst
        self.patterns=dict.fromkeys(map(lambda x: x.pattern,lst),0)
        self.original=original
        self.split=split
        self.versions=versions

    def evaluate(self,pattern):
        found=False
        for v in self.list:
            if(v.pattern==pattern):
                found=True
                original=True
                split=v.split
                versions=[]
        if(found==False):
            original=False
            split=[]
            versions=self.list
        rsl=OptionSet(self.form,self.list, original, split, versions)
        return rsl
    
    def resolvePos(self,index,sset):
        # filling up positions in splits which do not fit the pattern being processed
        rsl="-"
        for v in self.versions:
            if(v.split[index:index+1]):
                sSet=sset.projectSet([v.split[index]])
                if(sSet.isValid(a.substSets)):
                    rsl=v.split[index]
        return rsl
    
class Selection:
    # filtered options based on a selected pattern
    def __init__(self,pattern,options):
        print("Making the selection for pattern: "+pattern)
        self.pattern=pattern
        self.selected=[]
        for o in options:
            self.selected.append(options[o].evaluate(self.pattern))
            self.selected = sorted(self.selected, key=lambda k: -k.original)
        print("Selection for pattern: " + pattern + " completed")
      
        

class Version:
    # result of analysis for a specific Selection based on certain parametres
    def __init__(self, selection):
        print("Making a version for pattern: "+selection.pattern)
        self.pattern=selection.pattern
        self.alignments=[]
        self.invalidSets=[]
        for i in range(0, len(selection.pattern)):
            self.alignments.append(Alignment(selection, i))
        self.splits=list(map(lambda x: x.split, selection.selected))
        self.isValid=True
        self.validate(selection)
            
   
    def validate(self,selection):
        for s in selection.selected:
            if("".join(s.split).replace("-","").strip()!=str(s.form).strip()):
                print("".join(s.split).replace("-","").strip() + " ! " +str(s.form).strip())
                self.isValid=False
        
        for al in self.alignments:
            if(al.set.isValid(a.substSets)==False):
                self.isValid=False
                self.invalidSets.append(al.set)
        if(self.isValid==True):
            print("version for pattern " + self.pattern + " is VALID")
        else:
            print("version for pattern " + self.pattern + " is INVALID")
            print(list(map(lambda x: x.members, self.invalidSets)))
        self.display()
    
    def display(self):
        for s in self.splits:
            print(" | ".join(s))
        


class Alignment:
    # member object of Version, set of litterae found at a specific position
    def __init__(self, selection, index):
        self.index=index
        self.type=selection.pattern[index]
        self.set=SubstSet([])
        for s in selection.selected:
            if(s.original==True):
                self.set.addMembers([s.split[index]])
            else:
                inserted=[]
                graph=s.resolvePos(index,self.set)
                self.set.addMembers([graph])
                s.split.append(graph)
                if(graph=="-"):
                    a.lexel.proposePattern(s, selection.pattern,index)
                    alternatives=[]
                    for vr in s.versions:
                        alternatives.append(Option(vr.split[0:index]+["-"]+vr.split[index:],None))
                    s.versions=s.versions+alternatives


class SubstSet:
    # set of corresponding litterae at a specific position
    def __init__(self,members):
        self.members=set(members)
        
    def isValid(self, ssets):
        # comparing the set with existing sets
        for s in ssets:
            if(self.members<=s.members):
                return True
        return False
    
    def addMembers(self,nMembers):
        self.members=set(list(self.members)+nMembers)

    def projectSet(self,nMembers):
        return SubstSet(list(self.members)+nMembers)

class Scores:
    def __init__(self, scores):
        self.dict=scores
        
    def getBest(self):
        maxScore=max(list(self.dict.values()))
        rsl={"value":maxScore, "patterns":[]}
        for s in self.dict:
            if(self.dict[s]==maxScore):
                rsl["patterns"].append(s)
        return rsl




# RUNNIG METHODS    
a=Analysis("each")
a.initialize()
a.testPatterns(a.lexel.patterns)

    



    
