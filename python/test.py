

def calcOverlap(patt1="CVC", patt2="CVCCCVC"):
    rsl=""
    streak=0
    shift=0
    x=0
    while(patt1[x+shift:x+shift+1] and patt2[x:x+1]):
        if(patt1[x+shift]==patt2[x]):
            streak+=1
            x+=1
            print("streak: " + str(streak))
        else:
            rsl=rsl+str(streak)
            print("reset ("+rsl+")")
            streak=0
            shift-=1
            x+=1
    rsl=rsl+str(streak)
    print(patt1 + " : "+ patt2 + " = " +rsl)
    return rsl;

calcOverlap()