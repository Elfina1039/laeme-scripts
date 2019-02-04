SELECT t.lexel, count(DISTINCT t.form) AS freq, array_agg(DISTINCT m.form) AS forms, count(DISTINCT m.form) AS endings FROm laeme.tags t
INNER JOIN laeme.morphemes m ON m.tagid=t.id
WHERE t.grammel SIMILAR TO 'n%' AND m.type='E' GROUP BY t.lexel ORDER BY freq DESC