# coding=utf8

from itertools import combinations

forms=["ver","fyr","fer","uer","uerr","fur","veerr","vr"]
forms2=["elch","eche","elche","ech","alche","ache"]
fCount=len(forms)

litterae=[{"lit":"v", "cat":"A", "ln":1},{"lit":"e","cat":"V","ln":1},{"lit":"r","cat":"C","ln":1},{"lit":"f","cat":"C","ln":1}, {"lit":"y","cat":"A","ln":1},{"lit":"u","cat":"A","ln":1},{"lit":"rr","cat":"C","ln":2},{"lit":"ee","cat":"V","ln":2},{"lit":"ch","cat":"C","ln":2},{"lit":"c","cat":"C","ln":1}, {"lit":"l","cat":"C","ln":1}, {"lit":"a","cat":"V","ln":1}]

ssets=[set(["v","u","f"]),set(["u","e","i","ee","y"]),set(["r","rr"]),set(["c","ch","h"]),set(["l","-"]),set(["e","a","i","-"])]



 



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




litDict=makeDict(litterae)    
options={}
patterns=[]

for f in forms2:
    options[f]={}
    options[f]["list"]=getOptions(f)
    options[f]["patterns"]=dict.fromkeys(map(lambda x: x["pattern"],options[f]["list"]),0)
    patterns=patterns+list(options[f]["patterns"])

patterns=set(patterns)
scores=calcPattScore(options, patterns)

for patt in scores:
    print("TESTING : "+patt)
    selection=makeSelection(patt,options)
    version=[]
    for i in range(0,len(patt)):
        version.append(makeSet(patt,i,selection))
    print(version)
    print("RESULT_____________")
    print(validateVersion(version))

#patterns=set(list(map(makeSlots, options)))
#print(patterns)