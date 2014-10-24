#Primary Key Constraint Violations
	#1 These queries insert multiple movies withthe same id, which is a primary key. Thus the primary key unique constraint is violated
	INSERT INTO Movie(id, title, year, rating, company) VALUES (1,"Foo", 1992, "Great", "Cool Company");
	INSERT INTO Movie(id, title, year, rating, company) VALUES (1,"Foo", 1993, "Good", "Some other Company");

	#2 These queries insert multiple actors withthe same id, which is a primary key. Thus the primary key unique constraint is violated
	INSERT INTO Actor(id, last, first, sex, dob, dod) VALUES (1, "Foo", "Bar", "Male", "2014-03-01", NULL);
	INSERT INTO Actor(id, last, first, sex, dob, dod) VALUES (1, "Baz", "Qux", "Female", "2014-03-01", NULL);

	#3 These queries inserts a director with a null id, which violates the id's primary constraint of non nullity
	INSERT INTO Director(id, first, last, dob, dod) VALUES (NULL, "Foo", "Bar", "2014-03-01", NULL);

#Referential Integrity Constraint Violations

	#1 Say we start with no data in our tables
	#  The Movie with id 13 does not exist, therefore this violates the referential integrity constraint on the mid foreign key
	INSERT INTO MovieGenre VALUES (13, "Cool Genre");

	#2 Running the delete statment will result in a reference in MovieDirector to a movie that non longer exists
	#  Thus the referential integrity constraint on mid in MovieDirector is violated
	INSERT INTO Movie(id, title, year, rating, company) VALUES (1,"Foo", 1992, "Great", "Cool Company");
	INSERT INTO Director(id, first, last, dob, dod) VALUES (7, "Foo", "Bar", "2014-03-01", NULL);
	INSERT INTO MovieDirector VALUES (1, 7);
	DELETE FROM Movie WHERE id=1;





