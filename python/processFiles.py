import psycopg2 as p
import psycopg2.extras as e
import fileIndex
import re
conn=p.connect("dbname='postgres' user='postgres' host='localhost' password='postgrass'")
c=conn.cursor()
nid=(0,)

class Line:
    def __init__(self, inp):
       # print(type(inp))
        print("INPUT: " + inp.rstrip("\n"))
        
      #  mtch=re.findall('\\$',inp)
        txt=inp
      #  print(mtch)
      #  print("NEW LINE__: " + txt);
        parts=re.split("\s+",txt)
        self.tags=[]
        for p in parts:
            if(p[0]=="$"):
                self.tags.append(Tag(p,None))
        self.word=self.tags[0]
        if(len(parts)==1):
            self.roots=[self.tags[0].form]
            self.tags.append(Tag("$"+self.tags[0].lexel+"/"+self.tags[0].grammel+"_"+self.tags[0].form, "root"))
        else:
            self.getStructure()
            self.display()
        self.tags.pop(0)
    
    def getStructure(self):
        for t1 in self.tags:
            t1.higher=[]
            for t2 in self.tags:
                if(t1.rawForm<=t2.rawForm and t1!=t2):
                    t1.higher.append(t2)
                    print(t1.form +" is part of "+ t2.form)
            t1.level=len(t1.higher)
        lower=list(map(lambda x: x.rawForm.rstrip(),filter(lambda x: x.level==1,self.tags)))
        #print("LOWER:"+str(lower))
        root=self.word.rawForm
        for lw in lower:
            print("replacing: "+lw)
            root=root.replace(lw,"")
            print("ROOT: "+root)
        self.roots=root.split("+")
        for r in self.roots:
            self.tags.append(Tag("$"+self.word.lexel+"/"+self.word.grammel+"_"+r, "root"))
            
            
    def display(self):
        lvl=0
        while(len(list(filter(lambda x: (x.level==lvl),self.tags)))):
            #print(list(map(lambda x: x.rawForm,filter(lambda x: x.level==lvl,self.tags))))
            lvl+=1
            
    def saveToDb(self):
        a=self.word.getInsert(False)
        a.append(int(currentFile))
        c.callproc("inserttag",(a))
        nid=c.fetchone()
        for t in self.tags:
            a=t.getInsert(True)
            a.append(nid[0])
            c.callproc("insertmorph",(a))
        conn.commit()
        print("word saved: " + str(nid))
        return nid
    
        


class Tag:
    def __init__(self, txt, type):
       
        txt.rstrip()
        #print("NEW TAG: " + txt)
        parts=txt.split("/")
        self.lexel=parts[0].replace("$","")
        self.grammel=parts[1].split("_")[0]
        self.rawForm=parts[1].split("_")[1].split("\\")[0]
        self.form=self.rawForm.replace("+","")
        
        if(self.rawForm.startswith("*")):
            print("capital")
            self.rawForm=self.rawForm.replace("*","")
        
        #self.form.rstrip()
        #self.rawForm.rstrip()
        
        #print(">>> FORM: "+self.form)
        
        self.morphCount=len(self.rawForm.split("+"))
        self.level=0
        if(type is not None):
            self.type=type
        else:
            self.type=self.getType()
        self.display()
    
    def display(self):
        print(self.lexel + " - " + self.grammel + " - " + self.rawForm + "("+self.type+")")
    
    def getType(self):
        rsl="root"
        if(self.lexel=="" or self.lexel==None):
            rsl="ending"
            return rsl
        if(self.lexel[0]=="-"):
            rsl="suffix"
        if(self.lexel.endswith("-")):
            rsl="prefix"
        return rsl
    
    def getInsert(self, getType):
        rsl=[self.lexel, self.grammel, self.rawForm]
        if(getType==True):
            rsl.append(self.type[0].upper())
        return rsl
    
start=int(input("start: "))
end=int(input("end: "))

#sample=Line("$come/vps13_*COM+EZ $/vps13[N]_+EZ")

files=fileIndex.texts[start:end]

for f in files:  
    currentFile=f["id"]
    with open("laemeFiles/text_"+str(f["id"])+".txt") as tf:
        for line in tf:
            if(line[0]=="$"):
                line.rstrip()
                line=re.sub('\n$','',line)
                sample=Line(line)
                nid=sample.saveToDb()
            else:
                #print("SKIPPING: ________"+line + "("+str(nid)+")")
                if(int(nid[0])!=0):
                    c.callproc("insertcomment",(line, int(nid[0])))

#sample.display()