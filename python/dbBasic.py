import psycopg2 as p
import psycopg2.extras as e
conn=p.connect("dbname='postgres' user='postgres' host='localhost' password='postgrass'")
c=conn.cursor(cursor_factory=e.DictCursor)

q=input("query: ")

c.execute(q)

rows=c.fetchall()


def closeGraphemes(rows):
    for r in rows:
        print(str(r["char"]) + ";" + str(r["count"])  + ";" +  str(r["forms"]))
 


def catStatistics(rows):
    table={}
    for r in rows:
        print(r)
        if r["char"] not in table:
            print("adding property")
            table[r["char"]]={"t4":0, "t5":0, "t6":0, "t7":0, "t8":0, "t9":0, "t10":0}
        else:
            print("nothing to add")
           # print(table[r["char"]])
        table[r["char"]]["t"+str(r["text"])]=r["count"]
        print(r["count"])

    for t in table:
        print(t + ";" + str(table[t]['t4'])+ ";" + str(table[t]['t5'])+ ";" + str(table[t]['t6'])+ ";" + str(table[t]['t7'])+ ";" + str(table[t]['t8'])+ ";" + str(table[t]['t9'])+ ";" + str(table[t]['t10']))

        
for r in rows:
    print(r)
        
# catStatistics(rows)
  
    
# SELECT lexel, form FROM pm_corpus WHERE strid IN (SELECT )