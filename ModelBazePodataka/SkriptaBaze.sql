DROP SCHEMA IF EXISTS brziprsti;
CREATE SCHEMA brziprsti;
USE brziprsti;

CREATE TABLE DnevnaRangLista
(
	id                   INTEGER NOT NULL,
	vreme                FLOAT NULL,
	idKor                INTEGER NOT NULL,
	idTekst              INTEGER NOT NULL
) ENGINE=InnoDB;

ALTER TABLE DnevnaRangLista
ADD CONSTRAINT XPKDnevnaRangLista PRIMARY KEY (id);


CREATE TABLE DnevniIzazov
(
	id                   INTEGER NOT NULL,
	sadrzaj              VARCHAR(4000) NULL,
	tezina               FLOAT NULL,
	nazivKategorije      VARCHAR(20) NULL,
	idTekst              INTEGER NOT NULL
) ENGINE=InnoDB;

ALTER TABLE DnevniIzazov
ADD CONSTRAINT XPKDnevniIzazov PRIMARY KEY (id);


CREATE TABLE jePrijatelj
(
	id                   INTEGER NOT NULL,
	idKor1               INTEGER NOT NULL,
	idKor2               INTEGER NOT NULL
) ENGINE=InnoDB;

ALTER TABLE jePrijatelj
ADD CONSTRAINT XPKjePrijatelj PRIMARY KEY (id);


CREATE TABLE Kategorija
(
	id                   INTEGER NOT NULL,
	naziv                VARCHAR(20) NULL
) ENGINE=InnoDB;

ALTER TABLE Kategorija
ADD CONSTRAINT XPKKategorija PRIMARY KEY (id);


CREATE TABLE Korisnik
(
	id                   INTEGER NOT NULL,
	username             VARCHAR(20) NULL,
	password             VARCHAR(100) NULL,
	zlato                INTEGER NULL,
	srebro               INTEGER NULL,
	bronza               INTEGER NULL,
	tip                  INTEGER NULL,
	aktivan              INTEGER NULL,
	brojPrijatelja       INTEGER NULL
) ENGINE=InnoDB;

ALTER TABLE Korisnik
ADD CONSTRAINT XPKKorisnik PRIMARY KEY (id);


CREATE TABLE RangLista
(
	id                   INTEGER NOT NULL,
	vreme                FLOAT NULL,
	idKor                INTEGER NOT NULL,
	idTekst              INTEGER NOT NULL
) ENGINE=InnoDB;

ALTER TABLE RangLista
ADD CONSTRAINT XPKRangLista PRIMARY KEY (id);


CREATE TABLE Tekst
(
	id                   INTEGER NOT NULL,
	sadrzaj              VARCHAR(4000) NULL,
	tezina               FLOAT NULL,
	idKat                INTEGER NOT NULL
) ENGINE=InnoDB;

ALTER TABLE Tekst
ADD CONSTRAINT XPKTekst PRIMARY KEY (id);


ALTER TABLE DnevnaRangLista
ADD CONSTRAINT R_20 FOREIGN KEY (idKor) REFERENCES Korisnik (id);

ALTER TABLE DnevnaRangLista
ADD CONSTRAINT R_21 FOREIGN KEY (idTekst) REFERENCES Tekst (id);

ALTER TABLE DnevniIzazov
ADD CONSTRAINT R_22 FOREIGN KEY (idTekst) REFERENCES Tekst (id);

ALTER TABLE jePrijatelj
ADD CONSTRAINT R_15 FOREIGN KEY (idKor1) REFERENCES Korisnik (id);

ALTER TABLE jePrijatelj
ADD CONSTRAINT R_16 FOREIGN KEY (idKor2) REFERENCES Korisnik (id);

ALTER TABLE RangLista
ADD CONSTRAINT R_17 FOREIGN KEY (idKor) REFERENCES Korisnik (id);

ALTER TABLE RangLista
ADD CONSTRAINT R_18 FOREIGN KEY (idTekst) REFERENCES Tekst (id);

ALTER TABLE Tekst
ADD CONSTRAINT R_2 FOREIGN KEY (idKat) REFERENCES Kategorija (id); 