# coding=utf8

from itertools import combinations

forms=["ver","fyr","fer","uer","uerr","fur","veerr","vr"]
forms2=["elch","eche","elche","ech","alche","ache"]
fCount=len(forms)

litterae=[{"lit":"v", "cat":"A", "ln":1},{"lit":"e","cat":"V","ln":1},{"lit":"r","cat":"C","ln":1},{"lit":"f","cat":"C","ln":1}, {"lit":"y","cat":"A","ln":1},{"lit":"u","cat":"A","ln":1},{"lit":"rr","cat":"C","ln":2},{"lit":"ee","cat":"V","ln":2},{"lit":"ch","cat":"C","ln":2},{"lit":"c","cat":"C","ln":1}, {"lit":"l","cat":"C","ln":1}, {"lit":"a","cat":"V","ln":1}]

ssets=[set(["v","u","f"]),set(["u","e","i","ee","y"]),set(["r","rr"]),set(["c","ch","h"]),set(["l","-"]),set(["e","a","i"])]

def makeDict(lits):
    rsl={}
    for l in lits:
        rsl[l["lit"]]={"lit":l["lit"], "cat":l["cat"], "ln":l["ln"]}
    return rsl

def vcVariants(option):
    rsl=[]
    # should be done for all As in the string
    cons=option["pattern"].replace("A","C")
    rsl.append({"split":option["split"], "pattern":cons})
    vow=option["pattern"].replace("A","V")
    rsl.append({"split":option["split"], "pattern":vow})
    return rsl

def getOptions(form):
    #filter function selecting digraphs present in the form
    def getDigraphs(x):
        if(x["ln"]>1 and form.find(x["lit"])!=-1):
            return {"lit":x["lit"], "ln":x["ln"], "index":form.find(x["lit"])}
        else:
            return {}
    # list for all possible split options
    options=[]
    basicSplit=list(form)
   # options.append({"split":basicSplit, "pattern":makeSlots(basicSplit)})
    digraphs=list(filter(None,map(getDigraphs,litterae)))
    print(digraphs)
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
    nOption={"split":nSplit, "pattern":makeSlots(nSplit)};
    
    if(nOption["pattern"].find("A")!=-1):
        options=options+vcVariants(nOption)
    else:
        options.append(nOption)
    return options
 
def makeSlots(split):
    rsl=[]
    for s in split:
        rsl.append(litDict[s]["cat"])
    return ''.join(rsl)

def comparePatterns(a,b):
    if(len(a)!=len(b)):
        return False;
    i=0
    while(a[i:i+1] and b[i:i+1]):
        if((a[i]!=b[i])):
            return False;
        i+=1
    return True;

def calcPattScore(options,patterns):
    rsl={}
    for p in patterns:
        rsl[p]=0
        for o in options:
            if(p in options[o]["patterns"].keys()):
               # print(p)
                options[o]["patterns"][p]+=1
                rsl[p]+=1
    print(rsl)
    return rsl

def pickOption(o,p):
    rsl={}
    for v in o["list"]:
        if(v["pattern"]==p):
            rsl={"original":True, "split":v["split"] ,"versions":[]}
    if(rsl=={}):
        rsl=rsl={"original":False, "split":[],"versions":o["list"]}
    return rsl

def makeSelection(pattern, options):
    selected=[]
    for o in options:
        selected.append(pickOption(options[o],pattern))
    selected = sorted(selected, key=lambda k: -k['original'])
    print("---")
    print(selected)
    return selected

def isValid(sset):
    print("TESTING: "+ ",".join(sset))
    for s in ssets:
        if(sset<=s):
            print("SEt EXISTS")
            print(sset)
            return True
    print("NONEXISTENT SET")
    return False

def resolvePos(option,index,sset):
    rsl="-"
    for v in option["versions"]:
        if(v["split"][index:index+1]):
            if(isValid(set(sset+[v["split"][index]]))):
                rsl=v["split"][index]
    return rsl



def makeSet(pattern, index, selection):
    def insertEmpty(version):
        print("inserting")
        print(version)
        version.insert(index,"-")
        print(version)
        return version
    
    pos={"index":index, "type":pattern[index], "set":[]}
    for s in selection:
        if(s["original"]==True):
            pos["set"].append(s["split"][index])
        else:
            inserted=[]
            print("resolving pos")
            graph=resolvePos(s,index,pos["set"])
            pos["set"].append(graph)
            s["split"].append(graph)
            if(graph=="-"):
                for vr in s["versions"]:
                    print("VERSION")
                    print(vr)
                    vr["split"]=vr["split"][0:index]+["-"]+vr["split"][index:]
                    print(vr)
               
    return pos
    


litDict=makeDict(litterae)    
options={}
patterns=[]

for f in forms2:
    options[f]={}
    options[f]["list"]=getOptions(f)
    options[f]["patterns"]=dict.fromkeys(map(lambda x: x["pattern"],options[f]["list"]),0)
    patterns=patterns+list(options[f]["patterns"])
print(options)

patterns=set(patterns)
scores=calcPattScore(options, patterns)

selection=makeSelection("VCCV",options)

version=[]
for i in range(0,len("VCCV")):
    version.append(makeSet("VCCV",i,selection))

print(version)

#patterns=set(list(map(makeSlots, options)))
#print(patterns)