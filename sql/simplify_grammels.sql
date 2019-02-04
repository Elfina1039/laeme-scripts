SELECT substr(grammel,1,3) as gram, count(*) FROM laeme.tags 
WHERE lexel!=''
GROUP BY gram ORDER BY count DESC