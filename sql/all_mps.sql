SELECT lst, count(lst), array_agg(DISTINCT lexel) FROM
(SELECT pos, strid, lexel, array_agg(DISTINCT char) AS lst FROM positions ps
INNER JOIN pm_vocab v ON ps.strid=v.id
GROUP BY pos, strid, v.lexel) AS p
GROUP BY lst ORDER BY count DESC