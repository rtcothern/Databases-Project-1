-- For each violation, assume that initially the data tables are initialized but empty

-- Primary Key Constraint Violations
    -- #1 These queries insert multiple movies with the same id, which is a primary key. Thus the primary key unique constraint is violated
    INSERT INTO Movie(id, title, year, rating, company) VALUES (1,"Foo", 1992, "Great", "Cool Company");
    INSERT INTO Movie(id, title, year, rating, company) VALUES (1,"Foo", 1993, "Good", "Some other Company");
    -- MySQL Output: ERROR 1062 (23000) at line 6: Duplicate entry '1' for key 1

    -- #2 These queries insert multiple actors withthe same id, which is a primary key. Thus the primary key unique constraint is violated
    INSERT INTO Actor(id, last, first, sex, dob, dod) VALUES (1, "Foo", "Bar", "Male", "2014-03-01", NULL);
    INSERT INTO Actor(id, last, first, sex, dob, dod) VALUES (1, "Baz", "Qux", "Female", "2014-03-01", NULL);
    -- MySQL Output: ERROR 1062 (23000) at line 11: Duplicate entry '1' for key 1

    -- #3 These queries inserts a director with a null id, which violates the id's primary constraint of non nullity
    INSERT INTO Director(id, first, last, dob, dod) VALUES (NULL, "Foo", "Bar", "2014-03-01", NULL);
    -- MySQL Output: ERROR 1048 (23000) at line 15: Column 'id' cannot be null

-- Referential Integrity Constraint Violations
    -- #1 The Movie with id 13 does not exist, therefore this violates the referential integrity constraint on the mid foreign key
    INSERT INTO MovieGenre VALUES (13, "Cool Genre");
    -- MySQL Output: ERROR 1452 (23000) at line 20: Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

    -- #2 Running the delete statment will result in a reference in MovieDirector to a movie that non longer exists
    --    Thus the referential integrity constraint on mid in MovieDirector is violated
    INSERT INTO Movie(id, title, year, rating, company) VALUES (1, "Foo", 1992, "Great", "Cool Company");
    INSERT INTO Director(id, first, last, dob, dod) VALUES (7, "Foo", "Bar", "2014-03-01", NULL);
    INSERT INTO MovieDirector VALUES (1, 7);
    DELETE FROM Movie WHERE id=1;
    -- MySQL Ouput: ERROR 1451 (23000) at line 28: Cannot delete or update a parent row: a foreign key constraint fails (`CS143/MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

    -- #3 Running the update statment will result in a reference in MovieDirector to a director that non longer exists
    --    Thus the referential integrity constraint on mid in MovieDirector is violated
    INSERT INTO Movie(id, title, year, rating, company) VALUES (1, "Foo", 1992, "Great", "Cool Company");
    INSERT INTO Director(id, first, last, dob, dod) VALUES (7, "Foo", "Bar", "2014-03-01", NULL);
    INSERT INTO MovieDirector VALUES (1, 7);
    UPDATE MovieDirector SET did = 2 WHERE did = 7;
    -- MySQL Ouput: ERROR 1452 (23000) at line 36: Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))

    -- #4 Running the update statment will result in a reference in MovieActor to a movie that does not exist
    --    Thus the referential integrity constraint on mid in MovieActor is violated
    INSERT INTO MovieActor VALUES (NULL, NULL, "Cool Role");
    UPDATE MovieActor SET mid = 1 WHERE role = "Cool Role";
    -- MySQL Ouput: ERROR 1452 (23000) at line 42: Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

    -- #5 The Actor with id 20 does not exist, therefore this violates the referential integrity constraint on the aid foreign key
    INSERT INTO MovieActor VALUES (NULL, 20, "Cool Role");
    -- MySQL Ouput: ERROR 1452 (23000) at line 46: Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))

    -- #6 The Movie with id 23 does not exist, therefore this violates the referential integrity constraint on the mid foreign key
    INSERT INTO Review VALUES ("foo", NULL, 23, 10, "Great movie!");
    -- MySQL Ouput: ERROR 1452 (23000) at line 50: Cannot add or update a child row: a foreign key constraint fails (`CS143/Review`, CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

-- Check Constraint Violations
    -- NO MySQL output was generated for these constraints
    -- because MySQL ignores CHECK constraints.

    -- #7 Violates CHECK constraint that id must always be >= 0
    INSERT INTO Movie VALUES (-1,"Foo", 1992, "Great", "Cool Company");

    -- #8 Violates CHECK constraint that id must always be >= 0
    INSERT INTO Actor VALUES (-1, "Foo", "Bar", "Male", "2014-03-01", NULL);

    -- #9 Violates CHECK constraint that id must always be >= 0
    INSERT INTO Director VALUES (-1, "Foo", "Bar", "2014-03-01", NULL);

