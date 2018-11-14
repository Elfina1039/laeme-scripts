import urllib.request
import urllib.parse
import fileIndex

from html.parser import HTMLParser



class MyHTMLParser(HTMLParser):
    def handle_starttag(self, tag, attrs):
        parser.currentPos=str(tag)

    def handle_data(self, data):
        if(parser.currentPos=="strong"):
            print("D::"+data.split("\\")[0])
            #parser.result.append(data)

parser = MyHTMLParser()
parser.currentPos=""
parser.result=[]


url="http://www.oed.com/view/Entry/70512?rskey=jiM9up&result=1&isAdvanced=false#eid"

#url=url.encode("utf-8")
headers={}
headers["User-Agent"] = "Mozilla/5.0"

req=urllib.request.Request(url,headers=headers)
resp=urllib.request.urlopen(req)
txt=resp.read()
parser.feed(str(txt))


parser.currentPos=""
parser.result=[]
parser.reset()
