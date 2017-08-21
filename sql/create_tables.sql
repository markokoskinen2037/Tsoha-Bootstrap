-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja(
  id SERIAL PRIMARY KEY,
  kirjautumisnimi varchar(50) NOT NULL,
  salasana varchar(50) NOT NULL,
  adminrights boolean DEFAULT FALSE
  );
  
CREATE TABLE Luokka(
  id SERIAL PRIMARY KEY,
  luokkanimi varchar(100) NOT NULL
  );
  
CREATE TABLE Tarkeysaste(
  id SERIAL PRIMARY KEY,
  numeroarvo integer NOT NULL
  );
  
CREATE TABLE Tehtava(
  id SERIAL PRIMARY KEY,
  tehtavanimi varchar(100) NOT NULL,
  kuvaus varchar(500),
  tehty boolean DEFAULT FALSE,
  luomisaika timestamp,
  luokkatunnus INTEGER REFERENCES Luokka(id) ON DELETE CASCADE,
  tarkeysaste INTEGER REFERENCES Tarkeysaste(id) ON DELETE CASCADE,
  tekija INTEGER REFERENCES Kayttaja(id) ON DELETE CASCADE
  );

CREATE TABLE TehtavaLuokka(
  id SERIAL PRIMARY KEY,
  tehtavaid INTEGER REFERENCES Tehtava(id) ON DELETE CASCADE,
  luokkaid INTEGER REFERENCES Luokka(id) ON DELETE CASCADE
  );
  