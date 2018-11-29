changes={}

changes["PVLD"]={"types":["p"], "code":"PVLD", "name":"Palatal Vicinity l-deletion",
"date":["OE","ME"], 
"regular":False, 
"sets":[{"pre":["l"], "post":["_"]}],
"context":[{"position":[-2,-1,1,2], "crit":"segment", "values":["ch","c","cch"]}]}

changes["IFV"]={"types":["p"], "code":"IFV", "name":"Initial Fricative Voicing",
"date":["OE","ME"], 
"regular":False, 
"sets":[{"pre":["f"], "post":["v", "u"]},{"pre":["s"],"post":["z"]}],
"context":[{"position":[0], "crit":"order", "values":[0]}]}