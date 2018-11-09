SELECT text, comment FROm laeme.comments c INNER JOIN laeme.tags t ON t.id=c.tagid
WHERE comment SIMILAR TO '\{[0-9]{1,3}\}%' ORDER BY text