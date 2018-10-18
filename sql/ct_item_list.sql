CREATE TABLE palatalisation AS SELECT 'C' AS cat, p.strid, pos, lexel, grammel, chars, forms FROM
(SELECT strid, pos, array_agg(DISTINCT char) AS chars FROM positions WHERE char in ('c','k','ch') GROUP BY strid, pos ORDER BY strid, pos) AS p
INNER JOIN (SELECT id, lexel, grammel FROM pm_vocab GROUP BY id, lexel, grammel) AS v ON p.strid=v.id
INNER JOIN (SELECT strid, array_agg(DISTINCT form) AS forms FROM pm_corpus GROUP BY strid) AS c ON p.strid=c.strid