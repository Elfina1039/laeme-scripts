SELECT t.id AS tag,* FROM laeme.tags t LEFT JOIN laeme.morphemes m ON m.tagid=t.id 
LEFT JOIN laeme.comments c ON c.tagid=t.id WHERE t.lexel='open' AND t.grammel SIMILAR TO 'v%'
ORDER BY t.id DESC
