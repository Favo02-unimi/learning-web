DROP TABLE IF EXISTS Studenti;
CREATE TABLE Studenti(
  StudenteID INTEGER,
  Nome TEXT,
  Cognome TEXT,
  CodiceFiscale TEXT,
  DataDiNascita DATE,
  Sesso BOOLEAN,
  ClasseID TEXT,
  PRIMARY KEY (StudenteID),
  FOREIGN KEY (ClasseID) REFERENCES Classi(Nome)
);

DROP TABLE IF EXISTS Classi;
CREATE TABLE Classi(
  ClasseID TEXT,
  Anno INTEGER,
  Sezione CHAR,
  Indirizzo TEXT,
  CoordinatoreID INTEGER,
  ConsiglioID INTEGER,
  PRIMARY KEY (ClasseID),
  FOREIGN KEY (ConsiglioID) REFERENCES Consigli(ConsiglioID),
  FOREIGN KEY (CoordinatoreID) REFERENCES Docenti(DocenteID)
);

DROP TABLE IF EXISTS Consigli;
CREATE TABLE Consigli(
  ConsiglioID INTEGER,
  DocenteID INTEGER,
  MateriaID INTEGER,
  ClasseID INTEGER,
  PRIMARY KEY (ConsiglioID),
  FOREIGN KEY (ClasseID) REFERENCES Classi(ClasseID),
  FOREIGN KEY (MateriaID) REFERENCES Materie(MateriaID),
  FOREIGN KEY (DocenteID) REFERENCES Docenti(DocenteID)
);

DROP TABLE IF EXISTS Docenti;
CREATE TABLE Docenti (
  DocenteID INTEGER,
  Nome TEXT,
  Cognome TEXT,
  CodiceFiscale TEXT,
  Sesso BOOLEAN,
  ClasseDiConcorso TEXT,
  PRIMARY KEY (DocenteID),
  FOREIGN KEY (ClasseDiConcorso) REFERENCES ClassiDiConcorso(ClasseDiConcorsoID)
);

DROP TABLE IF EXISTS ClassiDiConcorso;
CREATE TABLE ClassiDiConcorso (
  ClasseDiConcorsoID INTEGER,
  MateriaID INTEGER,
  DocenteID INTEGER,
  PRIMARY KEY (ClasseDiConcorsoID),
  FOREIGN KEY (MateriaID) REFERENCES Materie(MateriaID),
  FOREIGN KEY (DocenteID) REFERENCES Docenti(DocenteID)
);

DROP TABLE IF EXISTS Materie;
CREATE TABLE Materie (
  MateriaID INTEGER,
  Nome TEXT,
  ClasseDiConcorsoID INTEGER,
  PRIMARY KEY (MateriaID),
  FOREIGN KEY (ClasseDiConcorso) REFERENCES ClassiDiConcorso(ClasseDiConcorsoID)
);

DROP TABLE IF EXISTS Voti;
CREATE TABLE Voti (
  VotoID INTEGER,
  MateriaID INTEGER,
  StudenteID INTEGER,
  DocenteID INTEGER,
  Data DATE,
  Voto REAL,
  PRIMARY KEY (VotoID),
  FOREIGN KEY (MateriaID) REFERENCES Materie(MateriaID),
  FOREIGN KEY (StudenteID) REFERENCES Studenti(StudenteID),
  FOREIGN KEY (DocenteID) REFERENCES Docenti(DocenteID)
);

DROP TABLE IF EXISTS Pagelle;
CREATE TABLE Pagelle (
  PagellaID INTEGER,
  StudenteID INTEGER,
  MateriaID INTEGER,
  Media INTEGER,
  Periodo TEXT,
  PRIMARY KEY (PagellaID),
  FOREIGN KEY (StudenteID) REFERENCES Studenti(StudenteID),
  FOREIGN KEY (MateriaID) REFERENCES Materie(MateriaID)
);

DROP TABLE IF EXISTS MaterieIstituzionali;
CREATE TABLE MaterieIstituzionali (
  MateriaID INTEGER,
  Anno INTEGER,
  Indirizzo TEXT,
  OreSettimanali INTEGER,
  PRIMARY KEY (MateriaID, Anno, Indirizzo),
  FOREIGN KEY (MateriaID) REFERENCES Materie(MateriaID)
);

INSERT INTO Studenti VALUES (001, "Luca", "Favini", "FVNLCU", "", 1, "5Ai");
INSERT INTO Docenti VALUES (001, "Enrico", "Sartirana", "SRTNRC", 1, "INF");
INSERT INTO Classi VALUES ("5Ai", 5, "A", "inf", 1, 1);