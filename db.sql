Create DATABASE hw1;
USE hw1;

CREATE TABLE users (
    id integer primary key auto_increment,
    password varchar(255) not null,
    email varchar(255) not null unique,
    name varchar(255) not null,
    surname varchar(255) not null,
    data_nascita date not null,
    corso varchar(255) not null
) Engine = InnoDB;

CREATE TABLE materie (
    id integer primary key auto_increment,
    nome_materia varchar(255) not null,
    cfu integer not null
) Engine = InnoDB;

CREATE TABLE materie (
    id integer primary key auto_increment,
    id_studente integer,
    id_materia integer,
    FOREIGN KEY (id_studente) REFERENCES users(id),
    FOREIGN KEY (id_materia) REFERENCES materie(id)
) Engine = InnoDB;

INSERT INTO materie (nome_materia, cfu) VALUES ('Informatica_musicale', 3);
INSERT INTO materie (nome_materia, cfu) VALUES ('Improvvisazione', 3);
INSERT INTO materie (nome_materia, cfu) VALUES ('Tedesco', 6);
INSERT INTO materie (nome_materia, cfu) VALUES ('Organizzazione', 3);
INSERT INTO materie (nome_materia, cfu) VALUES ('Tecniche', 3);

SELECT * FROM hw1.users;

SELECT * FROM hw1.materie;

SELECT * FROM hw1.materie_scelte;