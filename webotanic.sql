/* CREAZIONE TABELLE */
/*DROP DATABASE IF EXISTS webotanic;
CREATE DATABASE webotanic;

USE webotanic;*/

SET foreign_key_checks = 0;
DROP TABLE IF EXISTS Prenotazioni;
DROP TABLE IF EXISTS Eventi;
DROP TABLE IF EXISTS Notizie;

DROP TABLE IF EXISTS Gruppi;
DROP TABLE IF EXISTS Piante;
DROP TABLE IF EXISTS Foglie;
DROP TABLE IF EXISTS Principi;
DROP TABLE IF EXISTS PrincipiPiante;
DROP TABLE IF EXISTS UtilizziPiante;
DROP TABLE IF EXISTS Frutti;
DROP TABLE IF EXISTS Fiori;
DROP TABLE IF EXISTS BiomiAcquatici;
DROP TABLE IF EXISTS BiomiTerrestri;
DROP TABLE IF EXISTS Stati;
DROP TABLE IF EXISTS PianteBiomiA;
DROP TABLE IF EXISTS PianteBiomiT;
DROP TABLE IF EXISTS PianteStati;

CREATE TABLE Prenotazioni (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    DataP DATE NOT NULL,
    Tipo ENUM('intero', 'ridotto','gratuito') NOT NULL,
    Intestatario VARCHAR(50) NOT NULL
);

CREATE TABLE Eventi (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    DataInizio DATE NOT NULL,
    DataFine DATE NOT NULL,
    Nome VARCHAR(100) NOT NULL,
    Descrizione VARCHAR(1000) NOT NULL,
    Immagine VARCHAR(50),
    Alt VARCHAR(200)
);

CREATE TABLE Notizie (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    DataPub DATE NOT NULL,
    Titolo VARCHAR(100) NOT NULL,
    Testo VARCHAR(1000) NOT NULL,
    Immagine VARCHAR(50), 
    Alt VARCHAR(200)
);

CREATE TABLE Gruppi (
    Id VARCHAR(3) PRIMARY KEY,
    Gruppo VARCHAR(20) NOT NULL,
    Divisione VARCHAR(20),
    Sottodivisione VARCHAR(20)
);

CREATE TABLE Piante (
    NomeScientifico VARCHAR(50) PRIMARY KEY,
    NomeComune VARCHAR(50),
    NumEsemplari SMALLINT(3) DEFAULT 0,
    AltezzaCm SMALLINT(5) DEFAULT 0,
    Descrizione VARCHAR(2000) DEFAULT NULL,
    Gruppo VARCHAR(3),
    Fusto ENUM('Eretto', 'Rampicante', 'Strisciante', 'Rampante'),
    Radice ENUM('Ramosa', 'Tuberiforme', 'Fascicolata', 'A fittone', 'Avventizia', 'Aerea'),
    Immagine VARCHAR(50),
    Alt VARCHAR(200),
    FOREIGN KEY (Gruppo)
        REFERENCES Gruppi (Id)
        ON UPDATE CASCADE 
);

CREATE TABLE Foglie (
    Pianta VARCHAR(50) PRIMARY KEY,
    Forma ENUM('Aghiforme', 'Falcata', 'Orbicolare', 'Romboidale', 'Acuminata', 'Flabellata', 'Ovata', 'Rosetta', 'Alternata', 'Astata', 'Palmata', 'Spatolata', 'Aristata', 'Lanceolata', 'Pedata', 'Sagittata', 'Bipennata', 'Lineare', 'Peltata', 'Lesiniforme', 'Cordata', 'Lobulata', 'Amplessicaule', 'Tripartita', 'Cuneiforme', 'Obcordata', 'Impari-pennata', 'Tripennata', 'Triangolare', 'Obovata', 'Paripennata', 'Troncata', 'Digitata', 'Ottusa', 'Pennatisecta', 'Intera', 'Ellittica', 'Opposte', 'Reniforme', 'Verticillata'),
    Composizione ENUM('Composta', 'Semplice'),
    Margine ENUM('Ciliato', 'Crenato', 'Dentato', 'Denticolato', 'Doppiamente dentato', 'Intero', 'Lobato', 'Seghettato', 'Finemente seghettato', 'Sinuato', 'Spinoso', 'Ondulato'),
    Superficie ENUM('Coriacea', 'Tomentosa', 'Scabra'),
    FOREIGN KEY (Pianta)
        REFERENCES Piante (NomeScientifico)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Principi (
    NomePrincipio VARCHAR(20) PRIMARY KEY,
    Beneficio VARCHAR(500)
);

CREATE TABLE PrincipiPiante (
    Pianta VARCHAR(50), 
    Principio VARCHAR(20), 
    PRIMARY KEY (Principio , Pianta),
	FOREIGN KEY (Principio) REFERENCES Principi (NomePrincipio) ON UPDATE CASCADE,
    FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico)
    ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE UtilizziPiante (
    Pianta VARCHAR(50),    
    Utilizzo ENUM('Alimentare', 'Aromatico', 'Farmacologico', 'Tessile', 'Legname', 'Ornamentale'),
    PRIMARY KEY (Pianta , Utilizzo),
	FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico) ON UPDATE CASCADE ON DELETE CASCADE
);
	
CREATE TABLE BiomiTerrestri (
    Nome VARCHAR(20) PRIMARY KEY,
    Clima ENUM('Mediterraneo', 'Tropicale', 'Equatoriale', 'Subtropicale', 'Temperato', 'Temperato Umido', 'Oceanico', 'Continentale', 'Subartico', 'Transiberiano', 'Polare', 'Nivale', 'Glaciale', 'Steppico', 'Desertico', 'Monsonico', 'Sinico', 'Della Savana', 'Alpino', 'Boreale', 'Boreale delle foreste', 'Della tundra'),
    Precipitazioni INT,
    Terreno ENUM('Argilloso', 'Sabbioso', 'Limoso', 'Torboso'),
    SezioneOrto VARCHAR(5)
);
	
CREATE TABLE BiomiAcquatici (
    Nome VARCHAR(20) PRIMARY KEY,
    Temperatura TINYINT,
    Salinita TINYINT,
    SezioneOrto VARCHAR(5)
);

CREATE TABLE Stati (
    Nome VARCHAR(20) PRIMARY KEY
);
	
CREATE TABLE PianteBiomiT (
    Pianta VARCHAR(50),
    BiomaT VARCHAR(20), 
    PRIMARY KEY (Pianta, BiomaT),
	FOREIGN KEY (BiomaT) REFERENCES BiomiTerrestri (Nome)
    ON UPDATE CASCADE,
	FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico)
    ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE PianteBiomiA (
    Pianta VARCHAR(50),
    BiomaA VARCHAR(20),
    PRIMARY KEY (Pianta, BiomaA),
	FOREIGN KEY(BiomaA)  REFERENCES BiomiAcquatici (Nome)
    ON UPDATE CASCADE,
	FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico)
    ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE PianteStati (
    Pianta VARCHAR(50),
    Stato VARCHAR(20),
    PRIMARY KEY(Pianta, Stato),
    FOREIGN KEY(Stato) REFERENCES Stati (Nome)
    ON UPDATE CASCADE,
    FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico)
    ON UPDATE CASCADE ON DELETE CASCADE
);
	
CREATE TABLE Fiori (
    Pianta VARCHAR(50) PRIMARY KEY, 
    NomeFiore VARCHAR(20),
    NumPetali TINYINT,
    ColoreFiore VARCHAR(20),
	FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Frutti (
    Pianta VARCHAR(50) PRIMARY KEY,
    NomeFrutto VARCHAR(20),
    ColoreFrutto VARCHAR(20),
    
	FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico)
    ON UPDATE CASCADE ON DELETE CASCADE
);
	
 
SET foreign_key_checks = 1;


/* INSERT */

INSERT INTO Eventi (DataInizio, DataFine, Nome, Descrizione, Immagine, Alt) VALUES   
('2017-06-21', '2017-09-21', 'Quest&#39; estate, porte aperte a Belluno nei centri della cultura', 'Stanco delle estati nelle solite mete turistiche affollate? Vieni a Belluno! Tutti i principali centri culturali sono aperti, e promuovono attivita esclusive. Anche noi ne facciamo parte! Porta i tuoi amici, o la tua famiglia, all&#39; Orto Botanico.  Una visita emozionante  vi aspetta!', 'quadri.jpg', 'Esposizione di quadri in un museo di Belluno'),
('2017-07-14', '2017-07-14', 'Incontro con Angela Alberti','Il 14 luglio avremo il piacere di ospitare un incontro con Angela Alberti, nota giornalista ed esperta conoscitrice dell&#39; ambiente del Triveneto. Angela ci racconter&agrave; dove trovare i panorami e i paradisi naturali pi&ugrave; sconosciuti nella nostra regione. Inoltre, presenter&agrave; la nuova sezione di conifere sempreverdi.', 'ang.jpg', 'Primo piano di Angela Alberti, giornalista e ambientalista' ),
('2017-07-01', '2017-10-31', 'Prossima escursione al lago Stua', 'Periodicamente organizziamo escursioni nella zona alpina, divise per fasce di et&agrave;. La prossima data &egrave; il 26 Settembre, e partir&agrave; dal centro di Belluno alle ore 7:00. Il percorso seguito comprender&agrave; le seguenti tappe: lago Stua, Val Caoram, malga Cimonega, bivacco Feltre W.Bodo, passo Mura, rifugio Boz, passo Alvis, malga Alvis, lago Stua. Il dislivello supera i 1800 Metri. Le iscrizioni cominceranno a breve.', 'stua.jpg','Foto del lago stua scattata durante un escursione');

INSERT INTO Notizie (DataPub, Titolo, Testo, Immagine, Alt) VALUES
('2017-06-10','Scopri la nuova sezione dedicata alla flora delle Dolomiti','Il paesaggio dolomitico si mostra generosamente nella sua estrema variet&agrave; vegetale e cromatica, generata dalle diversit&agrave; morfologiche e microclimatiche del territorio. Dai fondovalle alle pendici dei monti, ricoperte di foreste, alle praterie alpine d&#39; alta quota, dove si scorgono le fioriture estreme, lo scenario cambia straordinariamente aspetto ad ogni stagione. Nelle fasce altimetriche pi&ugrave; basse i boschi si compongono in prevalenza di latifoglie, che, salendo verso l&#39; alto, si uniscono poi a conifere e faggete. La fascia soprastante &egrave; costituita da conifere: l&#39; abete rosso (primeggiante nel bosco rado della Vallunga e nella foresta di Paneveggio in Trentino), il larice e il pino cembro formano la fascia arborea antecedente a quella dominata dai pini mughi, dagli arbusti quali i rododendri e, ancor pi&ugrave;, in alto, dai salici nani.', 'abeteRosso.jpg', 'Gli Abeti rossi ricoprono le valli tra le dolomiti'),

('2017-04-01','Ingresso gratuito per anziani e piccini', 'Alcune fasce di et&agrave; godono di agevolazioni sui prezzi! Sei un ragazzo giovane? Una famiglia con bambini piccoli o parenti anziani? Potresti avere un piccolo sconto sul prezzo del biglietto. ', 'nen.jpg','Un luogo dove nonni e nipoti possono trascorrere del tempo assieme'),

('2016-10-12', 'Chiusura temporanea della mostra interna', 'Dal dal 10 al 24 novembre la parte al coperto dell&#39; Orto sar&agrave; chiusa per poter effettuare dei scambi con altri centri botanici e aggiornare la collezione di esemplari. Cionondimeno, la sezione all&#39; aperto non subir&agrave; cambiamenti e rester&agrave; visitabile.', NULL, NULL),
('2016-09-20', 'Il fiore del giorno: la Sassifraga di Burser', 'Il nome generico deriva dal latino saxum, sasso, e frangere, rompere. Significa quindi "pianta che spezza le pietre", a causa dell&#39; ecologia di molte specie che vivono sulle rocce. La specie &egrave; dedicata a John Burser, medico e botanico tedesco. La suaorma biologica &egrave; camefita pulvinata. Il suo periodo di fioritura &egrave; compreso tra giugno e luglio.', 'sas.jpg', 'Il fiore Sassifraga di Burser si possono trovare tra le alte rocce'),
('2016-09-10', 'Vieni a lavorare con noi!', 'Siamo un&#39; ente affermato nel territorio, e vogliamo continuare a crescere. Per questo vogliamo collaborare con persone capaci, affidabili, gentili con il pubblico e certamente, amanti della natura. 
Non ci sono requisiti minimi, non cerchiamo necessariamente persone con esperienza nel settore. Se sei interessato, contattaci inviando una tua breve presentazione e il tuo curriculum.', 'peo.jpg', 'Lavorare in gruppo e conoscere nuove persone'),
('2017-05-01', 'Corso per principianti fioristi', 'Il corso si chiama Stage Art. Questo percorso rappresenta la base completa per l&#39; attivit&agrave; di un fiorista interessato all&#39; uso artistico del fiore. Il percorso completo si tiene presso la Sede Ovest, e consta di 4 moduli distinti. Ogni modulo si svolge in 4 giorni. Inizia alla Domenica e termina il Mercoled&igrave; dalle ore 14.30 alle ore 21.30. Lo Stage Art completo d&agrave; la possibilit&agrave; di accedere al percorso Floral Designer e/o partecipare ai master o full immersion del percorso formativo della scuola. Al termine dello Stage Art verr&agrave; rilasciato il diploma della Scuola Internazionale Mastrofioristi.', 'fiorista.jpg','Imparare a comporre di un mazzo di fiori');


INSERT INTO Gruppi VALUES 	('B', 'Briofita', NULL, NULL), 
							('A', 'Alga', NULL, NULL), 
                            ('TP', 'Tracheofita', 'Pteridofita', NULL), 
                            ('TSG', 'Tracheofita', 'Spermatofita', 'Gimnosperma'),
                            ('TSA', 'Tracheofita', 'Spermatofita', 'Angiosperma');
                            
INSERT INTO Piante VALUES  ('Gossypium Herbaceum', 'Cotone', 5, 150,  'Una specie di cotone che viene coltivata e commercializzata per la fibra tessile', 'TSA', 'Eretto', 'A fittone', 'gossypiumherbaceum.jpg', 'Pianta di Gossypium Herbaceum'),
							('Juniperus Communis', 'Ginepro', 10, 250, 'Alberello o arbusto conosciuto per le sue bacche', 'TSG', 'Rampante', 'Ramosa', 'juniperuscommunis.jpg', 'Pianta di Juniperus Communis'),
                            ('Porphyra Tenera', 'Ama-nori', 20,10, 'Alga rossa commercializzata col nome generico giapponese Nori', 'A', NULL, NULL, 'porphyratenera.jpg', 'Pianta di Porphyra Tenera'),
                            ('Cedrus Libani', 'Cedro del Libano', 2, 4000, 'Pianta arborea distinguibile per alcuni rami che assumono un portamento a candelabro', 'TSG', 'Eretto', 'Ramosa','cedruslibani.jpg', 'Pianta di Cedrus Libani'),
                            ('Eucalyptus','Eucalipto', 4, 300, 'Piante arboree sempreverdi oriiginarie dell Oceania', 'TSA', 'Eretto', 'Ramosa','eucalyptus.jpg', 'Pianta di Eucalyptus'),
                            ('Melaleuca Alternifolia', 'Albero del Te', 10, 600, 'Albero dalle cui foglie si estrae un olio essenziale, dal fortissimo odore e dal sapore assai intenso e caratteristico', 'TSA', 'Eretto', 'Ramosa','melaleucaalternifolia.jpg', 'Pianta di Melaleuca Alternifolia'),
							('Eriobotrya Japonica', 'Nespolo del Giappone', 8, 500, 'Pianta di tipo arboreo coltivata a scopo ornamentale e per il suo frutto', 'TSA', 'Eretto', 'Ramosa','eriobotryajaponica.jpg', 'Pianta di Eriobotrya Japonica'),
                            ('Elaeocarpus Angustifolius', 'Blue Marble Tree', 5, 350, 'Albero indiano sacro conosciuto per i suoi frutti blu brillante', 'TSA', 'Eretto', 'Ramosa','elaeocarpusangustifolius.jpg', 'Pianta di Elaeocarpus Angustifolius'),
							('Vallisneria Gigantea', 'Vallisneria', 14, 50, 'Tipica pianta da acquario', 'TSA', 'Eretto', 'Ramosa','vallisneriagigantea.jpg', 'Pianta di Vallisneria Gigantea');

INSERT INTO Foglie VALUES 	('Gossypium Herbaceum', 'Palmata', 'Semplice', 'Lobato', 'Scabra'),
							('Juniperus Communis', 'Aghiforme', 'Composta', 'Intero', 'Coriacea'),
                            ('Cedrus Libani', 'Aghiforme', 'Semplice', 'Intero', 'Coriacea'),
                            ('Eucalyptus', 'Lanceolata', 'Semplice', 'Intero', 'Coriacea'),
                            ('Melaleuca Alternifolia', 'Lanceolata', 'Composta', 'Intero', 'Coriacea'),
                            ('Eriobotrya Japonica', 'Lanceolata', 'Semplice', 'Ondulato', 'Coriacea'),
                            ('Elaeocarpus Angustifolius', 'Lanceolata', 'Semplice', 'Intero', 'Coriacea'),
                            ('Vallisneria Gigantea', 'Lanceolata', 'Semplice', 'Intero', 'Scabra')
;
INSERT INTO Principi VALUES ('Flavonoidi', 'Antiossidante'),
							('Acidi Diterpenici', 'Diuretico'),
                            ('Olio Essenziale', 'Analgesico'),
                            ('Terpinolo', 'Antisettico'),
                            ('Cineolo', 'Antimicotico')
                            
;
INSERT INTO PrincipiPiante VALUES	('Juniperus Communis', 'Flavonoidi'),
									('Juniperus Communis', 'Acidi Diterpenici'),
                                    ('Eucalyptus', 'Olio Essenziale'),
                                    ('Melaleuca Alternifolia', 'Olio Essenziale'),
                                    ('Melaleuca Alternifolia', 'Terpinolo'),
                                    ('Melaleuca Alternifolia', 'Cineolo'),
                                    ('Eriobotrya Japonica', 'Flavonoidi'),
                                    ('Eucalyptus', 'Flavonoidi')
;
INSERT INTO UtilizziPiante VALUES	('Gossypium Herbaceum', 'Tessile'),
							        ('Juniperus Communis', 'Alimentare'),
                                    ('Porphyra Tenera', 'Alimentare'),
                                    ('Cedrus Libani', 'Ornamentale'),
                                    ('Eucalyptus', 'Farmacologico'),
                                    ('Eucalyptus', 'Legname'),
                                    ('Eucalyptus', 'Ornamentale'),
                                    ('Melaleuca Alternifolia', 'Farmacologico'),
                                    ('Eriobotrya Japonica', 'Alimentare'),
                                    ('Eriobotrya Japonica', 'Farmacologico'),
                                    ('Elaeocarpus Angustifolius','Ornamentale'),
                                    ('Elaeocarpus Angustifolius', 'Alimentare'),
                                    ('Vallisneria Gigantea', 'Ornamentale')
;

INSERT INTO Fiori VALUES('Gossypium Herbaceum', NULL, 5, 'Bianco'),
						('Eucalyptus', NULL, NULL, 'Bianco'),
                        ('Melaleuca Alternifolia', NULL, NULL, 'Bianco'),
                        ('Eriobotrya Japonica', NULL, 5, 'Giallo'),
                        ('Elaeocarpus Angustifolius', NULL, 5, 'Bianco'),
                        ('Vallisneria Gigantea', NULL ,NULL,'Verde')
;

INSERT INTO Frutti VALUES('Gossypium Herbaceum', NULL, 'Verde'),
						  ('Eucalyptus', NULL, 'Grigio'),
                          ('Melaleuca Alternifolia', NULL, 'Marrone'),
                          ('Eriobotrya Japonica', 'Nespola del Giappone', 'Arancione'),
                          ('Elaeocarpus Angustifolius', 'Blue Marble', 'Blu'),
                          ('Vallisneria Gigantea', NULL,'Verde')
;

INSERT INTO BiomiAcquatici VALUES ('Oceano Indiano', 25, 33, 'OCEAN'),
							      ('Oceano Pacifico', 21, 28, 'OCEAN'),
								  ('Fiume Mississipi', 20, 0,'RIVER');

INSERT INTO BiomiTerrestri VALUES	('Foresta Monsonica', 'Monsonico', 1800, 'Torboso', 'TROP'),
									('Foresta Temperata', 'Temperato', 800, 'Torboso', 'TEMP'),
                                    ('Macchia Mediterranea', 'Mediterraneo', 1000, 'Sabbioso', 'MEDIT')
                                    
;
INSERT INTO Stati VALUES ('India'), ('Germania'), ('Francia'), ('Isole Mauritius'), ('Cina'), ('Giappone'), ('Libano'), ('Turchia'), ('Tasmania'), ('Australia'), ('Nuova Guinea'),
('Louisiana')
;

INSERT INTO PianteBiomiA VALUES ('Porphyra Tenera', 'Oceano Indiano'),
							 ('Porphyra Tenera', 'Oceano Pacifico'),
                             ('Vallisneria Gigantea', 'Fiume Mississipi')
;
                              
INSERT INTO PianteBiomiT VALUES('Gossypium Herbaceum', 'Foresta Monsonica'),
							('Juniperus Communis', 'Foresta Temperata'),
                            ('Cedrus Libani', 'Macchia Mediterranea'),
                            ('Eucalyptus', 'Foresta Temperata'),
                            ('Melaleuca Alternifolia', 'Foresta Temperata'),
                            ('Eriobotrya Japonica', 'Foresta Temperata'),
                            ('Elaeocarpus Angustifolius', 'Foresta Monsonica'),
                            ('Elaeocarpus Angustifolius', 'Foresta Temperata')
;

INSERT INTO PianteStati VALUES   ('Porphyra Tenera','Isole Mauritius'),
                                 ('Porphyra Tenera', 'Giappone'),
                                 ('Porphyra Tenera', 'Cina'),
                                 ('Vallisneria Gigantea', 'Louisiana'),
                                 ('Gossypium Herbaceum', 'India'),
                                 ('Juniperus Communis', 'Germania'),
                                 ('Juniperus Communis', 'Francia'),
                                 ('Cedrus Libani', 'Libano'),
                                 ('Cedrus Libani','Turchia'),
                                 ('Eucalyptus','Australia'),
                                 ('Eucalyptus','Tasmania'),
                                 ('Eucalyptus','Nuova Guinea'),
                                 ('Melaleuca Alternifolia','Australia'),
                                 ('Eriobotrya Japonica','Giappone'),
                                 ('Elaeocarpus Angustifolius','India'),
                                 ('Elaeocarpus Angustifolius','Nuova Guinea'),
                                 ('Elaeocarpus Angustifolius','Australia')
;
                              
DROP VIEW IF EXISTS PianteBiomi;

CREATE VIEW PianteBiomi AS 
SELECT DISTINCT Pianta, BiomaA as Bioma FROM PianteBiomiA
UNION 
SELECT DISTINCT Pianta, BiomaT as Bioma FROM PianteBiomiT
;

SET foreign_key_checks = 1


