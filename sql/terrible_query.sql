SELECT text, p.strid, pos, char, lexel, grammel FROM positions p
 INNER JOIN pm_corpus pm ON pm.oid=p.tag
 WHERE text=8 AND p.strid::text||pos::text||char NOT IN
(SELECT p.strid::text||pos::text||char FROM positions p
 INNER JOIN pm_corpus pm ON p.tag=pm.oid
 WHERE pm.text!=8)
GROUP BY text, p.strid, pos, char, lexel, grammel
HAVING count(*)>5