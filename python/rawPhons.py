import rawSets
rawPhons=[
{"ph":"i", "gr":["i","y","u"], "c":"V", "props":{"lh":0, "fb":0, "r":0, "sl":0}},
{"ph":"ɵ", "gr":["ue","oe","o","u"], "c":"V", "props":{"lh":1, "fb":2, "r":1, "sl":0}},
{"ph":"e", "gr":["e"], "c":"V", "props":{"lh":1, "fb":1, "r":0, "sl":0}},
{"ph":"a","gr":["a","æ","e","ea"], "c":"V", "props":{"lh":2, "fb":3, "r":0, "sl":0}},
{"ph":"o","gr":["o"], "c":"V", "props":{"lh":1, "fb":4, "r":1, "sl":0}},
{"ph":"u","gr":["u","v","o"], "c":"V", "props":{"lh":0, "fb":6, "r":1, "sl":0}},
{"ph":"y","gr":["u"], "c":"V", "props":{"lh":0, "fb":5, "r":1, "sl":0}},
{"ph":"i:", "gr":["i","ii","ij","y","ey","ei","i-e"], "c":"V", "props":{"lh":0, "fb":0, "r":0, "sl":1}},
{"ph":"e:", "gr":["e","eo","oe","ue","o","eu","u","ee","ei"], "c":"V", "props":{"lh":1, "fb":1, "r":0, "sl":1}},
#{"ph":"ɛ:","gr":["ea","æ","e","ee","e-e"], "c":"V", , "props":{"lh":1, "fb":1, "r":0, "l":0}},
{"ph":"a:","gr":["a","aa","ai","ay"], "c":"V", "props":{"lh":2, "fb":3, "r":0, "sl":1}},
#{"ph":"ɔ:","gr":["a","oa","o"], "c":"V"},
#{"ph":"o:","gr":["o","oo","ou","oe","o-e"], "c":"V"},
{"ph":"u:","gr":["u","uw","ow","ou","ov"], "c":"V", "props":{"lh":0, "fb":6, "r":1, "sl":1}},
{"ph":"ɵ:","gr":["eo","oe","o","ue","u","eu","o-e","u-e"], "c":"V", "props":{"lh":1, "fb":2, "r":1, "sl":1}},
{"ph":"y:","gr":["y","u","ui","uy","y-e"], "c":"V",  "props":{"lh":0, "fb":5, "r":1, "sl":1}},
#{"ph":"ə","gr":["e"], "c":"V"},
    #DIPHTHONGS
{"ph":"aj", "gr":["æi","ei","ey","eȜ","aȜ","æȜ","ai","ay"], "c":"V",  "props":{"lh":0, "fb":5, "r":1, "sl":1}},
{"ph":"aw","gr":["au","aw"], "c":"V",  "props":{"lh":0, "fb":5, "r":1, "sl":1}},
{"ph":"ow","gr":["au","aw","ow","ou"], "c":"V",  "props":{"lh":0, "fb":5, "r":1, "sl":1}},
{"ph":"iw", "gr":["iw","eow","uw","eu","ew","u","w","iw","iu","yw","ui","u-e"], "c":"V",  "props":{"lh":0, "fb":5, "r":1, "sl":1}},
{"ph":"ew","gr":["eouw","eow","uw","eaw","ew","eu"], "c":"V",  "props":{"lh":0, "fb":5, "r":1, "sl":1}},
{"ph":"ie","gr":["ie"], "c":"V",  "props":{"lh":0, "fb":5, "r":1, "sl":1}},
{"ph":"oj","gr":["oi","oy"], "c":"V",  "props":{"lh":0, "fb":5, "r":1, "sl":1}},
{"ph":"uj","gr":["oi","oy","ui"], "c":"V",  "props":{"lh":0, "fb":5, "r":1, "sl":1}},
    #CONSONANTS
{"ph":"p","gr":["p","pp"], "c":"C", "props":{"m":0, "p":0, "v":0, "n":0}},
{"ph":"t", "gr":["tt"], "c":"C", "props":{"m":0, "p":2, "v":0, "n":0}},
{"ph":"c","gr":["c","ch","cch","eu","ew","u","w","iw","iu","yw","ui","u-e"], "c":"C", "props":{"m":1, "p":2, "v":0, "n":0}},
{"ph":"k","gr":["c","k","q","kk","ck","cu"], "c":"C", "props":{"m":0, "p":4, "v":0, "n":0}},
{"ph":"b","gr":["b","bb"], "c":"C", "props":{"m":0, "p":0, "v":1, "n":0}},   
{"ph":"d","gr":["dd"], "c":"C", "props":{"m":0, "p":2, "v":1, "n":0}},
{"ph":"d͡ʒ","gr":["gg","g","ng","i","j","dg"], "c":"C", "props":{"m":1, "p":3, "v":1, "n":0}},
{"ph":"g","gr":["g","ʒ","gu","gg","ᵹ"], "c":"C", "props":{"m":0, "p":4, "v":1, "n":0}},
{"ph":"f","gr":["f","ff","ph","ff"], "c":"C", "props":{"m":2, "p":0, "v":0, "n":0}},
{"ph":"v","gr":["f","u","fu","v"], "c":"C", "props":{"m":2, "p":0, "v":1, "n":0}},
{"ph":"θ","gr":["þ","ð","th","þþ","thþ"], "c":"C", "props":{"m":2, "p":1, "v":0, "n":0}},
{"ph":"ð","gr":["þ","ð","th"], "c":"C", "props":{"m":2, "p":1, "v":1, "n":0}},
{"ph":"s","gr":["ss"], "c":"C", "props":{"m":2, "p":2, "v":0, "n":0}},
{"ph":"z","gr":["s","Ȝ","z"], "c":"C",  "props":{"m":2, "p":2, "v":1, "n":0}},
{"ph":"ʃ","gr":["s","sh","sch","ss","sc","ssh","ssch"], "c":"C", "props":{"m":2, "p":3, "v":0, "n":0}},
{"ph":"x","gr":["h","Ȝ","g","Ȝh","gh","ch"], "c":"C",  "props":{"m":2, "p":4, "v":0, "n":0}},
{"ph":"ʍ","gr":["wh","w","quh","qu","qw","hw","hƿ","wƿ"], "c":"C", "props":{"m":3, "p":0, "v":0, "n":0}},
{"ph":"m","gr":["m","mm"], "c":"C",  "props":{"m":0, "p":0, "v":1, "n":1}},
{"ph":"n","gr":["n","nn","ng"], "c":"C",  "props":{"m":0, "p":2, "v":1, "n":1}},
{"ph":"l","gr":["l","ll"], "c":"C", "props":{"m":3, "p":2, "v":1, "n":0}},
{"ph":"r","gr":["r","rr"], "c":"C", "props":{"m":3, "p":2, "v":1, "n":0}},
{"ph":"w","gr":["u","w","ƿ","v"], "c":"C", "props":{"m":3, "p":0, "v":1, "n":0}},
{"ph":"j","gr":["Ȝ","g","y","yh"], "c":"C", "props":{"m":3, "p":3, "v":1, "n":0}},
{"ph":"h","gr":["h"], "c":"C",  "props":{"m":2, "p":5, "v":0, "n":0}},
    {"ph":"ɣ","gr":["g"], "c":"C",  "props":{"m":2, "p":4, "v":1, "n":0}}
]


class SoundInventory:
    def __init__(self,dictInput):
        self.sounds=self.getSounds(dictInput)
        
    def getSounds(self, dictInput):
        rsl={}
        for di in dictInput:
            rsl[di["ph"]]=Sound(di)
        return rsl
    
    def compareSounds(self,x ,y):
        cLowHigh=abs(self.sounds[x].props.hl-self.sounds[y].props.hl)
        cFrontBack=abs(self.sounds[x].props.fb-self.sounds[y].props.fb)
        total=cLowHigh+cFrontBack
        print(total)
        return total

class Sound:
    def __init__(self, dct):
        self.ph=dct["ph"]
        self.gr=dct["gr"]
        self.cat=dct["c"]
        self.props=SoundProps(dct)
        

class SoundProps:
    def __init__(self,dct):
        if(dct["c"]=="V"):
            self.hl=dct["props"]["lh"]
            self.fb=dct["props"]["fb"]
            self.r=dct["props"]["r"]
            self.sl=dct["props"]["sl"]
            self.v=1
            self.n=0
        elif(dct["c"]=="C"):
            self.hl=dct["props"]["m"]-4
            self.fb=dct["props"]["p"]
            self.v=dct["props"]["v"]
            self.n=dct["props"]["n"]
                        
                        
sounds=SoundInventory(rawPhons)
                        
#a=input("sound 1:")
#b=input("sound 2:")
#sounds.compareSounds(a,b)
            





