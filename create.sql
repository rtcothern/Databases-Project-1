CREATE TABLE Movie (
    id int,
    title varchar(100) NOT NULL,
    year int NOT NULL,
    rating varchar(10),
    company varchar(50) NOT NULL,
    PRIMARY KEY (id),
    CHECK (id >= 0)
) ENGINE = INNODB;

/* Constraints
	Movie:
	1. Id is primary key
	2. Title is not null
	3. Year between 1890 and 2020
	4. Identification number is non null
	5. Year is not null
	6. Production company is not null
*/

CREATE TABLE Actor (
    id int,
    last varchar(20) NOT NULL,
    first varchar(20) NOT NULL,
    sex varchar(6) NOT NULL,
    dob date NOT NULL,
    dod date NOT NULL,
    PRIMARY KEY (id),
    CHECK (id >= 0)
) ENGINE = INNODB;

/* Constraints
	Actor
	1. Id is primary key
	2. First and last name not null
	3. Sex non null
	4. Dob non null
	5. Dob and Dod are both before 10/29/2014
*/

CREATE TABLE Director (
    id int,
    last varchar(20) NOT NULL,
    first varchar(20) NOT NULL,
    dob date NOT NULL,
    dod date NOT NULL,
    PRIMARY KEY (id),
    CHECK (id >= 0)
) ENGINE = INNODB;

/* Constraints
	Director
	1. Id is primary key
	2. First and last name not null
	3. Dob non null
	4. Dob and Dod are both before 10/29/2014
*/

CREATE TABLE MovieGenre (
    mid int NOT NULL,
    genre varchar(20) NOT NULL,
    FOREIGN KEY (mid) REFERENCES Movie(id)
) ENGINE = INNODB;

/* Constraints
	MovieGenre
	1. Mid is a ForeignKey to Movie ID
	2. Mid is not null
	3. Genre is not null
*/

CREATE TABLE MovieDirector (
    mid int NOT NULL,
    did int NOT NULL,
    FOREIGN KEY (mid) REFERENCES Movie(id),
    FOREIGN KEY (did) REFERENCES Director(id)
) ENGINE = INNODB;

/* Constraints
Movie Director
	1. Mid is a ForeignKey to Movie ID
	2. Mid is not null
	3. Did is a ForeignKey to Director
	4. Director is not null
*/

CREATE TABLE MovieActor (
    mid int NOT NULL,
    aid int NOT NULL,
    role varchar(50) NOT NULL,
    FOREIGN KEY (mid) REFERENCES Movie(id),
    FOREIGN KEY (aid) REFERENCES Actor(id)
) ENGINE = INNODB;

/* Constraints
	Movie Actor
	1. Mid is a ForeignKey to Movie ID
	2. Mid is not null
	3. Aid is a ForeignKey to Movie ID
	4. Aid is not null
	5. Role is not null
*/

CREATE TABLE Review (
    name varchar(20) NOT NULL,
    time timestamp,
    mid int NOT NULL,
    rating int NOT NULL,
    comment varchar(500),
    FOREIGN KEY (mid) REFERENCES Movie(id),	
) ENGINE = INNODB;

/* Constraints
	Review
	1. Name is not null
	2. Time is not null
	3. Mid is a ForeignKey to Movie ID
	4. Mid is not null
	5. Rating not null
*/

CREATE TABLE MaxPersonID (
    id int NOT NULL,
    CHECK (id >= 0)
) ENGINE = INNODB;

/* Constraints
	MaxPersonID
	1. Id is non null
	2. Id is >= 0
*/

CREATE TABLE MaxMovieID (
    id int NOT NULL,
    CHECK (id >= 0)
) ENGINE = INNODB;

/* Constraints
	MaxMovieID
	1. Id is non null
	2. Id is >= 0
*/
