DROP SCHEMA IF EXISTS brziprsti;
CREATE SCHEMA brziprsti;
USE brziprsti;

CREATE TABLE DnevnaRangLista
(
	id                   INTEGER NOT NULL AUTO_INCREMENT,
	vreme                FLOAT NULL,
	idKor                INTEGER NOT NULL,
	idTekst              INTEGER NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE DnevniIzazov
(
	id                   INTEGER NOT NULL AUTO_INCREMENT,
	sadrzaj              VARCHAR(4000) NULL,
	tezina               FLOAT NULL,
	nazivKategorije      VARCHAR(20) NULL,
	idTekst              INTEGER NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE jePrijatelj
(
	id                   INTEGER NOT NULL AUTO_INCREMENT,
	idKor1               INTEGER NOT NULL,
	idKor2               INTEGER NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE Kategorija
(
	id                   INTEGER NOT NULL AUTO_INCREMENT,
	naziv                VARCHAR(20) NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE Korisnik
(
	id                   INTEGER NOT NULL AUTO_INCREMENT,
	username             VARCHAR(20) NULL,
	password             VARCHAR(100) NULL,
	zlato                INTEGER NULL,
	srebro               INTEGER NULL,
	bronza               INTEGER NULL,
	tip                  INTEGER NULL,
	aktivan              INTEGER NULL,
	brojPrijatelja       INTEGER NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE RangLista
(
	id                   INTEGER NOT NULL AUTO_INCREMENT,
	vreme                FLOAT NULL,
	idKor                INTEGER NOT NULL,
	idTekst              INTEGER NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE Tekst
(
	id                   INTEGER NOT NULL AUTO_INCREMENT,
	sadrzaj              VARCHAR(4000) NULL,
	tezina               FLOAT NULL,
	idKat                INTEGER NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;


ALTER TABLE DnevnaRangLista
ADD CONSTRAINT R_20 FOREIGN KEY (idKor) REFERENCES Korisnik (id);

ALTER TABLE DnevnaRangLista
ADD CONSTRAINT R_21 FOREIGN KEY (idTekst) REFERENCES Tekst (id) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE DnevniIzazov
ADD CONSTRAINT R_22 FOREIGN KEY (idTekst) REFERENCES Tekst (id) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE jePrijatelj
ADD CONSTRAINT R_15 FOREIGN KEY (idKor1) REFERENCES Korisnik (id);

ALTER TABLE jePrijatelj
ADD CONSTRAINT R_16 FOREIGN KEY (idKor2) REFERENCES Korisnik (id);

ALTER TABLE RangLista
ADD CONSTRAINT R_17 FOREIGN KEY (idKor) REFERENCES Korisnik (id);

ALTER TABLE RangLista
ADD CONSTRAINT R_18 FOREIGN KEY (idTekst) REFERENCES Tekst (id) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE Tekst
ADD CONSTRAINT R_2 FOREIGN KEY (idKat) REFERENCES Kategorija (id); 