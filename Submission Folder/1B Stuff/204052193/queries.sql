/*  The following query will return the names of all actors
 *  who participated in the movie "Die Another Day".
 *
 *  It works by joining the MovieActor and Actor tables so that
 *  each actor can be associated with a list of movies. Actors
 *  are selected based on whether their list contains the movie
 *  ID number of "Die Another Day"
 */
SELECT CONCAT(first, ' ', last)
    FROM MovieActor, Actor
    WHERE aid = id AND mid=(
        SELECT id FROM Movie
        WHERE title='Die Another Day');

/*  The following query will return the number of actors who
 *  participated in more than one movie.
 *
 *  It works by joining the MovieActor and Actor tables so that
 *  each actor can be associated with a list of movies. It then
 *  used the GROUP BY clause to count the number of times each
 *  actor appears in the joined table. This is then used in a
 *  subquery which is reduced to a list of counts that are
 *  greater than 1. The number of elements in the result set is
 *  then returned.
 */
SELECT COUNT(*)
    FROM (SELECT COUNT(*) AS moviecount
          FROM MovieActor, Actor
          WHERE aid=id GROUP BY id) AS temptable
     WHERE moviecount > 1;


/*  The following query will return the names of the directors
 *  who have directed at least one movie containing more than
 *  35 actors.
 *
 *  It works by identifying which movies have more than 35
 *  actors in them and by identifying which directors have
 *  directed these movies.
 */
SELECT DISTINCT CONCAT(Director.first, ' ', Director.last)
    FROM (SELECT mid, COUNT(*) AS actorcount
            FROM MovieActor GROUP BY mid)
          AS MovieActorCounts, MovieDirector, Director
    WHERE MovieActorCounts.mid = MovieDirector.mid
          AND MovieDirector.did = Director.id
          AND MovieActorCounts.actorcount > 35;

