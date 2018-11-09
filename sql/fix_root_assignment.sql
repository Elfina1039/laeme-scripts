SELECT * FROM laeme.tags t INNER jOIN laeme.morphemes m ON m.tagid=t.id
INNER JOIN laeme.morphemes m2 ON m.tagid=m2.tagid
WHERE m.type='E' AND regexp_replace(m.form,'\+','','g')=m2.form AND m.form!=m2.form AND m2.type='R' AND t.lexel='open'