import psycopg2 as p
import psycopg2.extras as e


def countQuery(c,q):
    c.execute(q)
    rows=c.fetchall()
    return rows[0]
    



conn=p.connect("dbname='postgres' user='postgres' host='localhost' password='postgrass'")
c=conn.cursor(cursor_factory=e.DictCursor)

rule=input("define correspondence:")

parts=rule.split(",")
first=parts[0].split("-")
second=parts[1].split("-")


getIntersect="SELECT count(*) FROM ((SELECT p.strid||'-'||pos FROM positions p INNER JOIn pm_corpus c ON c.oid=p.tag WHERE char='"+first[0]+"' AND text="+first[1]+")INTERSECT (SELECT p.strid||'-'||pos FROM positions p INNER JOIn pm_corpus c ON c.oid=p.tag WHERE char='"+second[0]+"' AND text="+second[1]+")) AS sub "

getUnion="SELECT count(*) FROM ((SELECT p.strid||'-'||pos FROM positions p INNER JOIn pm_corpus c ON c.oid=p.tag WHERE char='"+first[0]+"' AND text="+first[1]+") UNION (SELECT p.strid||'-'||pos FROM positions p INNER JOIn pm_corpus c ON c.oid=p.tag WHERE char='"+second[0]+"' AND text="+second[1]+")) AS sub "


union=countQuery(c,getUnion)
intersect=countQuery(c,getIntersect)

print(str(union[0]/2)+"/"+str(intersect[0]))
ratio=(union[0]/2)/intersect[0]
print(ratio)