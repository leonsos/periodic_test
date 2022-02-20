SELECT * FROM movies as m
LEFT JOIN movies_gender as mg ON mg.movie_id=m.id
WHERE m.title LIKE  '%America%' OR m.description LIKE '%America%' AND mg.gender_id='126'