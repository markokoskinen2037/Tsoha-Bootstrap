-- Lisää INSERT INTO lauseet tähän tiedostoon


INSERT INTO Kayttaja (kirjautumisnimi,salasana) VALUES ('TESTI','1234');
INSERT INTO Kayttaja (kirjautumisnimi,salasana) VALUES ('Pekka','salasana');

INSERT INTO Luokka (luokkanimi) VALUES ('Kotityöt');
INSERT INTO Luokka (luokkanimi) VALUES ('Autoprojekti');

INSERT INTO Tarkeysaste (numeroarvo) VALUES (1);
INSERT INTO Tarkeysaste (numeroarvo) VALUES (2);
INSERT INTO Tarkeysaste (numeroarvo) VALUES (3);
INSERT INTO Tarkeysaste (numeroarvo) VALUES (4);
INSERT INTO Tarkeysaste (numeroarvo) VALUES (5);

INSERT INTO Tehtava (tehtavanimi,kuvaus,luomisaika,luokkatunnus,tarkeysaste,tekija) VALUES ('Pese tiskit','Ota harja käteen ja ala hommiin jne :D',Now(),1,1,1);
INSERT INTO Tehtava (tehtavanimi,kuvaus,luomisaika,luokkatunnus,tarkeysaste,tekija) VALUES ('Vaihda takaiskarit','Hae eka kauppiselta uudet',Now(),2,5,1);

INSERT INTO TehtavaLuokka (tehtavaid,luokkaid) VALUES (1,1);
INSERT INTO TehtavaLuokka (tehtavaid,luokkaid) VALUES (1,2);
