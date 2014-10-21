CREATE TABLE Movie (
    id int,
    title varchar(100) NOT NULL,
    year int NOT NULL,
    rating varchar(10),
    company varchar(50) NOT NULL,
    PRIMARY KEY (id),
    CHECK (year >= 1890),
    CHECK (year <= 2020)
) ENGINE = INNODB;

CREATE TABLE Actor (
    id int,
    last varchar(20) NOT NULL,
    first varchar(20) NOT NULL,
    sex varchar(6) NOT NULL,
    dob date NOT NULL,
    dod date NOT NULL,
    PRIMARY KEY (id),
    CHECK (dob <= '2014-10-29'),
    CHECK (dod <= '2014-10-29')
) ENGINE = INNODB;

CREATE TABLE Director (
    id int,
    last varchar(20) NOT NULL,
    first varchar(20) NOT NULL,
    dob date NOT NULL,
    dod date NOT NULL,
    PRIMARY KEY (id),
    CHECK (dob <= '2014-10-29'),
    CHECK (dod <= '2014-10-29')
) ENGINE = INNODB;

CREATE TABLE MovieGenre (
    mid int NOT NULL,
    genre varchar(20) NOT NULL,
    FOREIGN KEY (mid) REFERENCES Movie(id)
) ENGINE = INNODB;

CREATE TABLE MovieDirector (
    mid int NOT NULL,
    did int NOT NULL,
    FOREIGN KEY (mid) REFERENCES Movie(id),
    FOREIGN KEY (did) REFERENCES Director(id)
) ENGINE = INNODB;

CREATE TABLE MovieActor (
    mid int NOT NULL,
    aid int NOT NULL,
    role varchar(50) NOT NULL,
    FOREIGN KEY (mid) REFERENCES Movie(id),
    FOREIGN KEY (aid) REFERENCES Actor(id)
) ENGINE = INNODB;

CREATE TABLE Review (
    name varchar(20) NOT NULL,
    time timestamp NOT NULL,
    mid int NOT NULL,
    rating int NOT NULL,
    comment varchar(500),
    PRIMARY KEY (name, time),
    FOREIGN KEY (mid) REFERENCES Movie(id),
    FOREIGN KEY (aid) REFERENCES Actor(id)
) ENGINE = INNODB;

CREATE TABLE MaxPersonID (
    id int NOT NULL,
    CHECK (id >= 0)
) ENGINE = INNODB;

CREATE TABLE MaxMovieID (
    id int NOT NULL,
    CHECK (id >= 0)
) ENGINE = INNODB;
