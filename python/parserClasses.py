#!/usr/bin/python
# -*-coding:utf-8 -*-

import rawSets
import rawLits
import rawPhons

import re
import itertools as itr
import psycopg2 as p
import psycopg2.extras as e

conn=p.connect("dbname='postgres' user='postgres' host='localhost' password='postgrass'")
c=conn.cursor(cursor_factory=e.DictCursor)



def makeDict(lits):
        rsl={}
        for l in lits:
            rsl[l["lit"]]=l
        return rsl

litDict=makeDict(rawLits.rawLits)


def replaceChars(form):
    form=form.replace("ae","æ")
    form=form.replace("z","ȝ")
    form=form.replace("y~","ꝥ")
    form=form.replace("y","þ")
    form=form.replace("w","ƿ")
    form=form.replace("d","ð") 
    form=form.replace("g","ᵹ") 
    form=form.replace("Ax","á") 
    form=form.replace("Ex","é") 
    form=form.replace("Ix","í") 
    form=form.replace("Ox","ó") 
    form=form.replace("Ux","ú") 
    form=form.replace("Yx","ý") 
    form=form.replace("æx","ǣ") 
    form=form.replace("Jx","J")
    
    form=form.replace("*","") 
    form=form.replace("\\","") 
    form=form.replace("[","")
    form=form.replace("]","")
    form=form.replace("~","")
    form=form.replace("^","")
    
    #if(form[0]=="-"):
        #form=form[1:]
    
    return form.lower()

class Analysis:
    #main object holding most of the data
    def __init__(self,params):
        self.litterae=self.getLitterae()
        self.litDict=self.makeDict(self.litterae)
        self.substSets=self.getSubstSets()
        self.formFreqLimit=params[3]
        self.selections=[]
        self.versions=[]
        self.level=0
        
        self.log("Analysis object initialized",True)
        
    def getLitterae(self):
        rsl=[]
        for i in rawLits.rawLits:
            rsl.append(Littera(i["lit"],i["cat"],i["ln"]))
        
        return rsl
    
    def makeDict(self,lits):
        rsl={}
        for l in lits:
            rsl[l.lit]=l
        return rsl
    
    def getSubstSets(self):
        rsl=[]
        for i in rawSets.rawSets:
            rsl.append(SubstSet(i))
        return rsl        
    
    def initialize(self):
        self.lexel=Lexel(params)
        self.formCount=len(self.lexel.forms)
        self.lexel.getOptions()
        self.lexel.calcPattScore()
        self.topScore=self.lexel.scores.getBest()
        self.log(self.topScore, False)
    
    def testPatterns(self,patterns):
        #self.makeSelections(patterns)
        self.level=self.level+1
        for patt in patterns:
            self.lexel.getOptions()
            selection=Selection(patt,self.lexel.options)
            version=Version(selection)
            self.versions.append(version)
        self.countValid()
        self.getBest()
        
    def makeSelection(self,pattern):
        self.selections.append(Selection(pattern,self.lexel.options))
        
    def makeSelections(self, patterns):
        for patt in patterns:
            a.makeSelection(patt)
    
    def countValid(self):
        valid=list(filter(lambda x: x.isValid, self.versions))
        self.validCount=len(valid) 
        a.log("FOUND __ " + str(self.validCount) + " __ VALID VERSION(S)",True)
        #if(len(valid)==0):
           # self.versions=[]
           # self.selections=[]
           # self.testPatterns(self.lexel.patterns)
    
    def getBest(self):
        self.versions = sorted(self.versions, key=lambda k: len(k.faultySplits))
        self.minErrors=len(self.versions[0].faultySplits)
        self.log(self.versions[0].display(),True)
        
    def getSuccessRate(self):
        rsl=(self.formCount-self.minErrors)/(self.formCount/100)
        return rsl
        
    def log(self, string, screen):
        for x in range(0,self.level):
            string="\t"+str(string)
        print(str(string), file=logFile)
        if(screen==True):
            print(str(string))
    
    def insertRecord(self):
        records=open("logs/tested.txt","a")
        records.write(self.lexel.record() + "/ "+self.formFreqLimit+" ("+self.versions[0].pattern+") : " +str(self.validCount)+ " : "+str(self.minErrors) + " / " + str(self.formCount) +" = " + str(self.getSuccessRate()) + " % \n")

   
class Lexel:
    # input data - lexel, forms and  analysis options
    def __init__(self, params):
        self.lexel=params[0]
        self.grammel=params[1]
        self.morpheme=params[2]
        self.formDict={}
        self.forms=self.getForms()
        self.filterForms(params[3])
        self.options={}
        self.patterns=[]
        self.addedPatterns=[]
        self.delCount=0
        
        a.log("Lexel initialized",True)
    
    def record(self):
        rsl=self.lexel + "/" + self.grammel + "/" + self.morpheme
        return rsl
    
    def getForms(self):
        #q="SELECT DISTINCT regexp_replace(form,'[\+-]','','g') AS form FROM laeme.morphemes WHERE lexel='"+lexel+"' AND type='"+morpheme+"' AND form NOT SIMILAR TO '%&%'"
       # c.execute(q)
        c.callproc("getfreqset",(self.lexel, self.grammel, self.morpheme))
        rows=c.fetchall()
        rsl=[]
        for r in rows:
            f=replaceChars(r[0])
            self.formDict[f]=r[1]
        a.log(self.formDict,True)
        return rsl
    
    def filterForms(self, limit):
        rsl=[]
        for f in self.formDict:
            if(self.formDict[f]>int(limit)):
                rsl.append(f)
        self.forms=rsl
                
    
    def getOptions(self):
        def isPattValid(patt):
            if(len(re.findall("((C{4,})|(V{2,}))",patt))>0 or len(patt)<self.minLength):
                a.log("Pattern " + patt + " is invalid", False)
                return False
            a.log("Pattern " + patt + " is valid", False)
            return True
    
        self.patterns=list(self.patterns)
        for f in self.forms:
            self.getOption(f)
        self.patterns=set(self.patterns)
        self.getMinLength()
        a.log("MIN pattern length=" + str(self.minLength),False)
        self.patterns=list(filter(isPattValid, self.patterns))
    
    def getMinLength(self):
        rsl=20
        longest=max(list(map(lambda x : len(x),self.forms)))
        for o in self.options:
            if(len(o)==longest):
                shortestSplit=min(list(map(lambda x : len(x.pattern),self.options[o].list)))
                if(shortestSplit<rsl):
                    rsl=shortestSplit
        self.minLength=rsl
                    
        
    
    def getOption(self,form):
    #filter function selecting digraphs present in the form
        def getDigraphs(x):
            if(x.ln>1 and form.find(x.lit)!=-1):
                return {"lit":x.lit, "ln":x.ln, "index":form.find(x.lit)}
            else:
                return {}
        
        def getDigrSplits(form, digraphs):
            nSplit=[]
            i=0
            while(form[i:i+1]):
                d=list(filter(lambda x: x["index"]==i, digraphs))
                if(d):
                    nSplit.append(form[i:i+d[0]["ln"]])
                    i+=d[0]["ln"]
                else:
                    nSplit.append(form[i:i+1])
                    i+=1
            return nSplit
        
        # list for all possible split options
        options=[]
        splits=[list(form)]
       # options.append({"split":basicSplit, "pattern":makeSlots(basicSplit)})
        digraphs=list(filter(None,map(getDigraphs,a.litterae)))
        combos=[]
            #a.log(digraphs,False)
        
        if(len(digraphs)>0):
            for n in range(1,len(digraphs)+1):
                nComb=list(itr.combinations(digraphs,n))
                for nc in nComb:
                    combos.append(list(nc))
                a.log(combos, False)
        #print(combos)
      
        # while loop generationg splits with digraphs - to be turned in to a function and called for every combination of digraphs
        i=0
        
        for cmb in combos:
            splits.append(getDigrSplits(form,cmb))
            
    
            
        for nSplit in splits:
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
        
    def proposePattern(self, optSet, pattern, sSet, index):
        #print("Adding pattern based on " + pattern)
        for v in optSet.versions:
            if(v.split[index+1:]):
                prevSet=sSet.projectSet([v.split[index+1]])
                if(prevSet.isValid(a.substSets)):
                    added=pattern[:index+1]+"C"+pattern[index+1:]
                    self.addedPatterns.append(added)
                    
                

class Littera:
    # constant data - litterae with classes and lengths
    def __init__(self, lit, cat, ln):
        self.lit=lit
        self.cat=cat
        self.ln=ln

class Option:
    # basic object holding a splitting option and pattern
    def __init__(self,split,pattern):
        self.valid=True
        self.split=split
        if(pattern):
            self.pattern=pattern
        else:
            self.pattern=self.makeSlots()
        
    
    def __del__(self):
        a.lexel.delCount+=1
        
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
        
    def displayVersions(self):
        rsl=[]
        for v in self.versions:
            rsl.append("/".join(v.split) + "("+v.pattern+")")
        return "\n".join(rsl)

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
    
    def resolvePos(self,index,sset,sType):
        # filling up positions in splits which do not fit the pattern being processed
        rsl=[]
        blockedSets=[]
        for v in self.versions:
            a.log("> version: " + "/".join(v.split), False)
            if(v.split[index:index+1] and str(v.split[index:index+1]).strip()!="_"):
                a.log("TRYING: " +v.split[index], False)
                sSet=sset.projectSet([v.split[index]])
                #print(sSet.members)
                if(sSet.isValid(a.substSets) or (sSet.type==sType or sSet.type=="A")):
                    rsl.append(v.split[index])
                    #print(self.form+" : "+rsl)
                elif(sSet.type==sType or sSet.type=="A"):
                    a.log("adding blocked set: "+sType+" = "+sSet.type+" >> "+ ", ".join(sSet.members), False)
                    blockedSets.append(sSet)
            if(len(set(rsl))>1):
                a.log(">>> MULTIPLE RESOLVE OPTIONS: "+str(set(rsl)),False)
        if(rsl==[]):
            rsl.append("_")
                
        return {"rsl":list(set(rsl)), "blockedSets":blockedSets}
    
    def removeIrrelevant(self,span):
        #print("--- >> removing irrelevant:  " + str(len(self.versions)))
        for v in self.versions:
            a.log("version split: " + str(v.split), False)
            args=self.makeResolveRgx(span,v.split[0:span])
            a.log(args, False)
            if(re.search(args["rgx"],args["string"])==None):
                
                a.log("_____REMOVING________"+str(v.split), False)
                v.valid=False
                #print(type(v))
                #v.__del__()
            self.versions=list(filter(lambda x: x.valid==True,self.versions))
        
    
    def makeResolveRgx(self, span, version):
        def posRgx(inp):
            if(type(inp)=="string"):
                return inp
            else:
                return "("+"|".join(list(map(lambda x: "("+x+")", inp)))+")"
        versionStr="/".join(version)
        splitRgx="/".join(list(map(posRgx,self.split)))+"$"
        return {"string":versionStr, "rgx":splitRgx}
    
    
class Selection:
    # filtered options based on a selected pattern
    def __init__(self,pattern,options):
        a.log("Making the selection for pattern: "+pattern,True)
        self.pattern=pattern
        self.selected=[]
        for o in options:
            self.selected.append(options[o].evaluate(self.pattern))
            self.selected = sorted(self.selected, key=lambda k: -k.original)
        a.log("Selection for pattern: " + pattern + " completed",True)
      
        

class Version:
    # result of analysis for a specific Selection based on certain parametres
    def __init__(self, selection):
        a.log("Making a version for pattern: "+selection.pattern,True)
        a.level=a.level+1
        self.pattern=selection.pattern
        self.alignments=[]
        self.invalidSets=[]
        self.faultySplits=[]
        a.level=a.level+1
        for i in range(0, len(selection.pattern)):
            self.alignments.append(Alignment(selection, i))
        a.level=a.level-1
            
        self.resolveSplits(selection)
        self.splits=list(map(lambda x: x.split, selection.selected))
        self.isValid=True
        self.validate(selection)
        a.log(self.display(),False)
        a.level=a.level-1
            
   
    def validate(self,selection):
        for s in selection.selected:
            a.log("SPLIT: "+ str(s.split), False)
            for v in s.versions:
                a.log(v.split, False)
            #print(type(s.split))
            #print(s.split)
            actual="".join(s.split).replace("_","").strip()
            original=str(s.form).strip()
            if(actual!=original):
                #print("".join(s.split).replace("_","").strip() + " ! " +str(s.form).strip())
                self.faultySplits.append({"actual":actual, "original":original})
                self.isValid=False
        
        for al in self.alignments:
            if(al.set.isValid(a.substSets)==False):
                self.isValid=False
                self.invalidSets.append(al.set)
        if(self.isValid==True):
            print("version for pattern " + self.pattern + " is VALID")
        else:
            a.log("version for pattern " + self.pattern + " is INVALID",True)
            a.log(list(map(lambda x: x.members, self.invalidSets)),True)
            a.log(len(self.faultySplits),True)
        #self.display()
    
    def resolveSplits(self,selection):
        for s in selection.selected:
            remaining=set(list(map(lambda x: "/".join(x.split),s.versions)))
            if(s.original==False and len(remaining)==1):
                s.split=s.versions[0].split
                a.log("only one version left: " + str(s.split), False)
            else:
                s.split=list(map(lambda x: ".".join(x) ,s.split))+["----!" ]
                vs=list(map(lambda x : "/".join(x.split),s.versions))
                a.log("FAIL: " + ", ".join(vs), False)
                
    
    def display(self):
        rsl=[]
        rsl.append("OVERVIEW: version for pattern " + self.pattern)
        rsl.append(", ".join(list(map(lambda x: str(x.members), self.invalidSets))))
        rsl.append("faulty splits: "+str(len(self.faultySplits)))
        for f in self.faultySplits:
            rsl.append(f["actual"] + " <-! " + f["original"])
        for s in self.splits:
            rsl.append(" | ".join(s))
        print("> BLOCKED SETS:")
        for a in filter(lambda x: len(x.blockedSets)>0,self.alignments):
            #print(a.blockedSets)
            rsl.append(str(a.index)+" : "+",".join(set(map(lambda x: str(x.members), set(a.blockedSets)))))
        return "\n".join(rsl)
        


class Alignment:
    # member object of Version, set of litterae found at a specific position
    def __init__(self, selection, index):
        a.log("___"+selection.pattern+" : "+str(index)+"___",False)
        self.index=index
        self.type=selection.pattern[index]
        self.set=SubstSet([])
        self.blockedSets=[]
        a.level=a.level+1
        for s in selection.selected:
            a.log("ANALYSING: "+s.form, False)
            if(s.original==True):
                self.set.addMembers([s.split[index]])
                a.log("adding littera based on matching pattern",False)
            else:
                inserted=[]
                a.level=a.level+1
                a.log("resolving ("+str(len(s.versions))+")", False)
                resolved=s.resolvePos(index,self.set, self.type)
                # SOLVE MULTIPLE RESOLVE OPTIONS PROBLEM
                if(len(set(resolved["rsl"]))>1):
                    for g in resolved["rsl"]:
                        pass
                # !! adding working options to result set
                graph=resolved["rsl"]
                self.set.addMembers(graph)
                s.split.append(graph)
                a.log("RESULT:  "+str(graph), False)
                a.level=a.level-1
                if(str(graph[0])=="_"):
                    a.lexel.proposePattern(s, selection.pattern,self.set,index)
                    self.blockedSets=self.blockedSets+resolved["blockedSets"]
                    alternatives=[]
                    for vr in s.versions:
                        a.log("adding dashed alternative: " +str(vr.split[0:index]+["_"]+vr.split[index:]),False)
                        alternatives.append(Option(vr.split[0:index]+["_"]+vr.split[index:],None))
                    s.versions=s.versions+alternatives
                    a.log(s.displayVersions(),False)
                if((len(selection.pattern)-1)==index):
                    span=index+2
                    s.removeIrrelevant(span)
                else:
                    span=index+1
                
        a.level=a.level-1


class SubstSet:
    # set of corresponding litterae at a specific position
    def __init__(self,members):
        self.members=set(members)
        self.type=self.getType()
        
    def isValid(self, ssets):
        # comparing the set with existing sets
        for s in ssets:
            project=s.projectSet(["_"])
            if(self.members<=project.members and project.type!="I"):
                return True
        return False
    
    def addMembers(self,nMembers):
        self.members=set(list(self.members)+nMembers)

    def projectSet(self,nMembers):
        return SubstSet(list(self.members)+nMembers)
    
    def getType(self):
        cv={"C":True, "V":True}
        for m in self.members:
            if(litDict[m]["cat"]=="C"):
                cv["V"]=False
            if(litDict[m]["cat"]=="V"):
                cv["C"]=False
        if(cv["C"]==False and cv["V"]==False):
            #print("invalid set")
            #print(self.members)
            return "I"
        elif(cv["C"]==True and cv["V"]==True):
            return "A"
        elif(cv["C"]==True and cv["V"]==False):
            return "C"
        elif(cv["C"]==False and cv["V"]==True):
            return "V"
            

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

lexelData=input("LEXEL/GRAMMEL/TYPE: ")
testQueue=lexelData.split(",")


for ld in testQueue:
    params=ld.split("/")

    logFile=open("logs/log_"+params[0]+".txt","w", encoding="utf-8")

    # RUNNIG METHODS 
    a=Analysis(params)


    a.initialize()
    a.testPatterns(a.lexel.patterns)
    a.log(set(a.lexel.addedPatterns),False)
    a.insertRecord()

    logFile.close()


    



    
