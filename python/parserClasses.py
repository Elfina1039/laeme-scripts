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
        inp=[{"lit":"v", "cat":"A", "ln":1},{"lit":"e","cat":"V","ln":1},{"lit":"r","cat":"C","ln":1},{"lit":"f","cat":"C","ln":1}, {"lit":"y","cat":"A","ln":1},{"lit":"u","cat":"A","ln":1},{"lit":"rr","cat":"C","ln":2},{"lit":"ee","cat":"V","ln":2},{"lit":"ch","cat":"C","ln":2},{"lit":"c","cat":"C","ln":1}, {"lit":"l","cat":"C","ln":1}, {"lit":"a","cat":"V","ln":1}]
        rsl=[]
        for i in inp:
            rsl.append(Littera(i["lit"],i["cat"],i["ln"]))
        
        return rsl
    
    def getSubstSets(self):
        inp=[set(["v","u","f"]),set(["u","e","i","ee","y"]),set(["r","rr"]),set(["c","ch","h"]),set(["l","-"]),set(["e","a","i","-"])]
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
        
    def makeSelection(self,pattern):
        self.selections.append(Selection(pattern,self.lexel.options))
        
    def makeSelections(self, patterns):
        for patt in patterns:
            a.makeSelection(patt)


   
class Lexel:
    # input data - lexel, forms and  analysis options
    def __init__(self, lexel):
        self.lexel=lexel
        self.forms=self.getForms(lexel)
        self.options={}
        self.patterns=[]
        print("Lexel initialized")
    
    def getForms(self,lexel):
        return ["elch","eche","elche","ech","alche","ache"]
    
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
        nOption=Option(nSplit);

        if(nOption.pattern.find("A")!=-1):
            options=options+vcVariants(nOption)
        else:
            options.append(nOption)
        self.options[form]=OptionSet(options)
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

class Littera:
    # constant data - litterae with classes and lengths
    def __init__(self, lit, cat, ln):
        self.lit=lit
        self.cat=cat
        self.ln=ln

class Option:
    # basic object holding a splitting option and pattern
    def __init__(self,split):
        self.split=split
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
    def __init__(self,lst):
        self.list=lst
        self.patterns=dict.fromkeys(map(lambda x: x.pattern,lst),0)

    def evaluate(self,pattern):
        found=False
        for v in self.list:
            if(v.pattern==pattern):
                self.original=True
                self.split=v.split
                self.versions=[]
        if(found==False):
            self.original=False
            self.split=[]
            self.versions=self.list
        return self
    
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
        self.pattern=pattern
        self.selected=[]
        for o in options:
            self.selected.append(options[o].evaluate(self.pattern))
            self.selected = sorted(self.selected, key=lambda k: -k.original)
        print("Selection for pattern: " + pattern + " completed")
      
        

class Version:
    # result of analysis for a specific Selection based on certain parametres
    def __init__(self, selection):
        self.pattern=selection.pattern
        self.alignments=[]
        for i in range(0, len(selection.pattern)):
            self.alignments.append(Alignment(selection, i))
        self.validate()
            
   
    def validate(self):
        for al in self.alignments:
            if(al.set.isValid(a.substSets)==False):
                self.isValid=False
                print("version for pattern " + self.pattern + " is INVALID")
                break
        self.isValid=True
        print("version for pattern " + self.pattern + " is VALID")


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
                    for vr in s.versions:
                        vr.split=vr.split[0:index]+["-"]+vr.split[index:]


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

a.makeSelections(a.topScore)

for s in a.selections:
    Version(s)
    



    
