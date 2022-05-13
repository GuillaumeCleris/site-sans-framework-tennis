--##############################################################
--# Script SQL
--# Author: Marine Guiraud, Yvon Cocks, Guillaume Cléris
--# Function: Création schéma BD et remplissage des tables
--###############################################################


--Création de la base de données

DROP TABLE IF EXISTS administrateurs;
DROP TABLE IF EXISTS arbitres;
DROP TABLE IF EXISTS adherents;
DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS tournois;
DROP TABLE IF EXISTS inscrits;
DROP TABLE IF EXISTS matchs;



CREATE TABLE administrateurs(
  id           VARCHAR(10) NOT NULL,
  adresse_mail VARCHAR(100) NOT NULL,
  date_naiss   DATE NOT NULL,
  nom          VARCHAR(30) NOT NULL,
  prenom       VARCHAR(30) NOT NULL,
  mdp          VARCHAR(100) NOT NULL,
  CONSTRAINT cleprim_administrateurs PRIMARY KEY(id)
);

CREATE TABLE arbitres(
  id           VARCHAR(10) NOT NULL,
  adresse_mail VARCHAR(100) NOT NULL,
  date_naiss   DATE NOT NULL,
  nom          VARCHAR(30) NOT NULL,
  prenom       VARCHAR(30) NOT NULL,
  mdp          VARCHAR(100) NOT NULL,
  moderateur   BOOLEAN,
  CONSTRAINT cleprim_arbitres PRIMARY KEY(id)
);

CREATE TABLE adherents(
  id           VARCHAR(10) NOT NULL,
  adresse_mail VARCHAR(100) NOT NULL,
  date_naiss   DATE NOT NULL,
  adresse      VARCHAR(100) NOT NULL,
  nom          VARCHAR(30) NOT NULL,
  prenom       VARCHAR(30) NOT NULL,
  mdp          VARCHAR(100) NOT NULL,
  classement   INTEGER NOT NULL,
  nb_points    INTEGER,
  banni        BOOLEAN,
  CONSTRAINT cleprim_adherents PRIMARY KEY(id)
);


CREATE TABLE reservations(
  adresse_mail VARCHAR(100) NOT NULL, --celui qui a fait la reservation--
  date         DATE,
  court        VARCHAR(7) CONSTRAINT dom_court_reservations CHECK(court IN ('central', 'un')) NOT NULL,
  h_deb        INTEGER CONSTRAINT dom_h_deb_reservations CHECK(h_deb BETWEEN 8 AND 16) NOT NULL,
  type         VARCHAR(12) CONSTRAINT dom_type_reservations CHECK(type IN ('entrainement','tournoi')) NOT NULL,
  mail1        VARCHAR(100) NOT NULL,
  mail2        VARCHAR(100) NOT NULL,
  CONSTRAINT cleprim_reservations PRIMARY KEY(court, date, h_deb)
);


CREATE TABLE tournois(
  num               INTEGER NOT NULL,
  nom_tournoi       VARCHAR(30) NOT NULL,
  nb_max            INTEGER NOT NULL,
  nb_reel           INTEGER NOT NULL,
  vainqueur_tournoi VARCHAR(100),
  situation         VARCHAR(12) CONSTRAINT dom_sit_tournois CHECK(situation IN ('inscription', 'en cours', 'terminé')) NOT NULL,
  CONSTRAINT cleprim_tournois PRIMARY KEY(num)
);


CREATE TABLE inscrits(
  num       INTEGER NOT NULL,
  mail      VARCHAR(100) NOT NULL
);


CREATE TABLE matchs(
  num_tournoi  INTEGER NOT NULL,
  num_match    INTEGER NOT NULL,
  tour         INTEGER NOT NULL, 
  mail1        VARCHAR(100) NOT NULL,
  mail2        VARCHAR(100) NOT NULL,
  classement1  INTEGER,
  classement2  INTEGER,
  vainqueur    VARCHAR(100) NOT NULL,
  CONSTRAINT cleprim_matchs PRIMARY KEY(num_tournoi, num_match)
);


--Remplissage de la base de données

--Administrateurs
INSERT INTO  administrateurs VALUES('AAA-1', 'marine.guiraud@ensiie.fr', '2000-09-16', 'GUIRAUD', 'Marine', 'motdepasse');
INSERT INTO  administrateurs VALUES('AAA-2', 'yvon.cocks@ensiie.fr', '2000-11-06', 'COCKS', 'Yvon', 'motdepasse');

--Arbitres
INSERT INTO  arbitres VALUES('AA-1', 'marine.guiraud@ensiie.fr', '2000-09-16', 'GUIRAUD', 'Marine', 'motdepasse', FALSE);
INSERT INTO  arbitres VALUES('AA-2', 'yvon.cocks@ensiie.fr', '2000-11-06', 'COCKS', 'Yvon', 'motdepasse', FALSE);

--Adhérents
INSERT INTO  adherents VALUES('A-1', 'marine.guiraud@ensiie.fr', '2000-09-16', '1 rue Pablo Picasso 91000 Evry', 'GUIRAUD', 'Marine', 'motdepasse', 0, 0, FALSE);
INSERT INTO  adherents VALUES('A-2', 'yvon.cocks@ensiie.fr', '2000-11-06', '1 rue Jean-Baptiste Lully 78100 Saint-Germain-en-Laye', 'COCKS', 'Yvon', 'motdepasse', 0, 0, FALSE);
INSERT INTO  adherents VALUES('A-3', 'elie.chambraud@ensie.fr', '2001-05-11', '303 allée du dragon 91000 Evry', 'CHAMBRAUD', 'Elie', 'motdepasse', 0, 0, FALSE);
INSERT INTO  adherents VALUES('A-4', 'morgan.loop@ensiie.fr', '2005-09-15', '3 place de la republique 7500 Paris', 'LOOP', 'Morgan', 'motdepasse', 0, 0, FALSE);
INSERT INTO  adherents VALUES('A-5', 'jean.socket@gmail.com', '1990-02-10', '5 rue de la paix 92500 Rueil-Malmaison', 'SOCKET', 'Jean', 'motdepasse', 0, 0, FALSE);
INSERT INTO  adherents VALUES('A-6', 'jeanne.soccer@ensiie.fr', '2001-05-11', '1 place de la republique 7500 Paris', 'SOCCER', 'Jeanne', 'motdepasse', 0, 0, FALSE);
INSERT INTO  adherents VALUES('A-7', 'marie.loop@ensiie.fr', '2005-09-15', '3 place de la republique 7500 Paris', 'LOOP', 'Marie', 'motdepasse', 0, 0, FALSE);
INSERT INTO  adherents VALUES('A-8', 'julie.socket@gmail.com', '1990-02-10', '5 rue de la paix 92500 Rueil-Malmaison', 'SOCKET', 'Julie', 'motdepasse', 0, 0, FALSE);

-- Réservations
--Le planning étant dynamique, pour ne pas avoir une page de planning vide, nous avons décidé de faire des réservations pour plusieurs semaines

--central
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-04-26', 'central', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-04-27', 'central', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-04-28', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-04-29', 'central', 8, 'entrainement','yvon.cocks@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-04-30', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-01', 'central', 9, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-02', 'central', 10, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
--un
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-04-26', 'un', 8, 'entrainement','julie.socket@gmail.com','yvon.cocks@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-04-27', 'un', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-04-28', 'un', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-04-29', 'un', 13, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-04-30', 'un', 14, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-01', 'un', 16, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-02', 'un', 13, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr'); 

--central
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-03', 'central', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-04', 'central', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-05', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-06', 'central', 8, 'entrainement','yvon.cocks@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-07', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-08', 'central', 9, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-09', 'central', 10, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
--un
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-03', 'un', 8, 'entrainement','julie.socket@gmail.com','yvon.cocks@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-04', 'un', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-05', 'un', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-06', 'un', 13, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-07', 'un', 14, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-08', 'un', 16, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-09', 'un', 13, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr'); 

--central
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-10', 'central', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-11', 'central', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-12', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-13', 'central', 8, 'entrainement','yvon.cocks@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-14', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-15', 'central', 9, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-16', 'central', 10, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
--un
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-10', 'un', 8, 'entrainement','julie.socket@gmail.com','yvon.cocks@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-11', 'un', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-12', 'un', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-13', 'un', 13, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-14', 'un', 14, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-15', 'un', 16, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-16', 'un', 13, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr'); 

--central
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-17', 'central', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-18', 'central', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-19', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-20', 'central', 8, 'entrainement','yvon.cocks@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-21', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-22', 'central', 9, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-23', 'central', 10, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
--un
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-17', 'un', 8, 'entrainement','julie.socket@gmail.com','yvon.cocks@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-18', 'un', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-19', 'un', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-20', 'un', 13, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-21', 'un', 14, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-22', 'un', 16, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-23', 'un', 13, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr'); 

--central
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-24', 'central', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-25', 'central', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-26', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-27', 'central', 8, 'entrainement','yvon.cocks@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-28', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-29', 'central', 9, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-30', 'central', 10, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
--un
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-24', 'un', 8, 'entrainement','julie.socket@gmail.com','yvon.cocks@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-25', 'un', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-26', 'un', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-27', 'un', 13, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-28', 'un', 14, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-05-29', 'un', 16, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-30', 'un', 13, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr'); 

--central
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-05-31', 'central', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-06-01', 'central', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-06-02', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-06-03', 'central', 8, 'entrainement','yvon.cocks@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-06-04', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-06-05', 'central', 9, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-06-06', 'central', 10, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
--un
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-05-31', 'un', 8, 'entrainement','julie.socket@gmail.com','yvon.cocks@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-06-01', 'un', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-06-02', 'un', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-06-03', 'un', 13, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-06-04', 'un', 14, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-06-05', 'un', 16, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-06-06', 'un', 13, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr'); 

--central
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-06-07', 'central', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-06-08', 'central', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-06-09', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-06-10', 'central', 8, 'entrainement','yvon.cocks@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-06-11', 'central', 12, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-06-12', 'central', 9, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-06-13', 'central', 10, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
--un
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-06-07', 'un', 8, 'entrainement','julie.socket@gmail.com','yvon.cocks@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-06-08', 'un', 9, 'entrainement','yvon.cocks@ensiie.fr','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('marine.guiraud@ensiie.fr','2021-06-09', 'un', 8, 'entrainement','marine.guiraud@ensiie.fr','jean.socket@gmail.com');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-06-10', 'un', 13, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-06-11', 'un', 14, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr');
INSERT INTO  reservations VALUES('yvon.cocks@ensiie.fr','2021-06-12', 'un', 16, 'entrainement','yvon.cocks@ensiie.fr','julie.socket@gmail.com');
INSERT INTO  reservations VALUES('julie.socket@gmail.com','2021-06-13', 'un', 13, 'entrainement','julie.socket@gmail.com','marine.guiraud@ensiie.fr'); 
