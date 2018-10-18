

class Game:

    def __init__(self):
        self.txt=self.loadFile()
        self.tarr=self.txt.split(" ")
        self.guess=[]
        self.sol=""


    def loadFile(self):
        txt=open("text.txt","r")
        return txt.read()


