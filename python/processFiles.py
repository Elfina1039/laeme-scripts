import psycopg2 as p
import psycopg2.extras as e
import fileIndex
conn=p.connect("dbname='postgres' user='postgres' host='localhost' password='postgrass'")
c=conn.cursor()


class Line:
    def __init__(self, txt):
        txt.rstrip()
        parts=txt.split(" ")
        self.tags=[]
        for p in parts:
            self.tags.append(Tag(p,None))
        self.word=self.tags[0]
        if(len(parts)==1):
            self.roots=[self.tags[0].form]
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
                    #print(t1.form +" is part of "+ t2.form)
            t1.level=len(t1.higher)
        lower=list(map(lambda x: x.rawForm.rstrip(),filter(lambda x: x.level==1,self.tags)))
        #print("LOWER:"+str(lower))
        root=self.word.rawForm
        for lw in lower:
            root=root.replace(lw,"")
        #print("ROOT: "+root)
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
    
        


class Tag:
    def __init__(self, txt, type):
       
        txt.rstrip()
        print("NEW TAG: " + txt)
        parts=txt.split("/")
        self.lexel=parts[0].replace("$","")
        self.grammel=parts[1].split("_")[0]
        self.rawForm=parts[1].split("_")[1]
        self.form=self.rawForm.replace("+","")
        
        self.form.rstrip("\n")
        self.rawForm.rstrip("\n")
        
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

files=fileIndex.texts[start:end]

for f in files:  
    currentFile=f.id
    with open("laemeFiles/text_"+str(f["id"])+".txt") as txt:
        for line in txt:
            if(line[0]=="$"):
                line.rstrip()
                sample=Line("$man/nG_MANN+ES $/Gn_+ES\n")
                #sample.saveToDb()
            else:
                print("SKIPPING: ________"+line)

#sample.display()