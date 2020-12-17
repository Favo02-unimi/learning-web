DROP TABLE IF EXISTS Dati_Grezzi;
CREATE TABLE Dati_Grezzi(
  IdSensore INTEGER PRIMARY KEY,
  Tipologia TEXT,
  UnitaDiMisura TEXT,
  IdStazione INTEGER,
  NomeStazione TEXT,
  Quota INTEGER,
  Provincia TEXT,
  DataStart DATE,
  DataStop DATE,
  Storico TEXT,
  UTM_Nord INTEGER,
  UTM_Est INTEGER,
  lng REAL,
  lat REAL,
  location POSITION
);

.mode csv
.import Stazioni_Meteorologiche.csv Dati_Grezzi

DROP TABLE IF EXISTS Stazioni;
CREATE TABLE Stazioni(
  IdStazione INTEGER PRIMARY KEY,
  NomeStazione TEXT,
  Quota INTEGER,
  Provincia TEXT,
  UTM_Nord INTEGER,
  UTM_Est INTEGER,
  lng REAL,
  lat REAL,
  location POSITION
);

DROP TABLE IF EXISTS Sensori;
CREATE TABLE Sensori(
  IdSensore INTEGER PRIMARY KEY,
  Tipologia TEXT,
  UnitaDiMisura TEXT,
  IdStazione INTEGER,
  DataStart DATE,
  DataStop DATE,
  Storico TEXT,
  FOREIGN KEY(IdStazione) REFERENCES Stazioni(IdStazione)
);

REPLACE INTO Stazioni (IdStazione, NomeStazione, Quota, Provincia, UTM_Nord, UTM_Est, lng, lat, location)
SELECT IdStazione, NomeStazione, Quota, Provincia, UTM_Nord, UTM_Est, lng, lat, location
FROM Dati_Grezzi;

REPLACE INTO Sensori (IdSensore, Tipologia, UnitaDiMisura, IdStazione, DataStart, DataStop, Storico)
SELECT IdSensore, Tipologia, UnitaDiMisura, IdStazione, DataStart, DataStop, Storico
FROM Dati_Grezzi;

SELECT NomeStazione, Provincia, Quota, Tipologia, UnitaDiMisura
FROM Stazioni, Sensori
WHERE Stazioni.IdStazione = Sensori.IdStazione AND Provincia IN("MI", "VA")
AND Tipologia = ;

SELECT Tipologia, count(*) AS ConteggioSensori FROM Sensori GROUP BY Tipologia;

/*

DROP TABLE IF EXISTS Misurazioni;
CREATE TABLE Misurazioni(
  IdSensore INTEGER,
  Data DATE,
  Valore REAL,
  idOperatore INTEGER,
  Stato TEXT,
  PRIMARY KEY (IdSensore, Data),
  FOREIGN KEY(IdSensore) REFERENCES Sensori(IdSensore)
);

.import Misurazioni.csv Misurazioni

SELECT NomeStazione, Provincia, Quota, Tipologia, UnitaDiMisura from Stazioni, Sensori
WHERE Stazioni.IdStazione = Sensori.IdStazione;

SELECT Valore, UnitaDiMisura, NomeStazione, Provincia from Misurazioni, Stazioni, Sensori
WHERE

*/
