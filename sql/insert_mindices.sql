BEGIN;
INSERT INTO laeme.morpheme_index (lexel, type, word_class, freq, form_count) 
SELECT lexel, type, substr(grammel,1,3) AS word_class, count(*) AS freq, count(DISTINCT form) AS form_count
FROM laeme.morphemes WHERE substr(grammel,1,3) IN ('vpp','vSp','vpt') AND  type='R' AND lexel!=''
GROUP BY lexel, type, word_class 