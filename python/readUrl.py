import urllib.request
import urllib.parse
import fileIndex

from html.parser import HTMLParser



class MyHTMLParser(HTMLParser):
    def handle_starttag(self, tag, attrs):
        parser.currentPos=str(tag)

    def handle_data(self, data):
        if(parser.currentPos=="span"):
            parser.result.append(data)

parser = MyHTMLParser()
parser.currentPos=""
parser.result=[]

start=int(input("start: "))
end=int(input("end: "))

files=fileIndex.texts[start:end]

for f in files:
    print(f["file"])
    url="http://archive.ling.ed.ac.uk/ihd/laeme2_scripts/display_tagdataZ.php?fn="+f["file"]

    #url=url.encode("utf-8")
    headers={}
    headers["User-Agent"] = "Mozilla/5.0"

    req=urllib.request.Request(url,headers=headers)
    resp=urllib.request.urlopen(req)
    txt=resp.read()
    parser.feed(str(txt))

    with open("laemeFiles/text_"+str(f["id"])+".txt","a") as txt:
        for l in parser.result:
            txt.write(l+"\n")
