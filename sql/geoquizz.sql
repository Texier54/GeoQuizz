#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: utilisateur
#------------------------------------------------------------

CREATE TABLE utilisateur(
        id       int (11) Auto_increment  NOT NULL ,
        nom      Varchar (50) ,
        prenom   Varchar (50) ,
        mail     Varchar (50) ,
        pseudo   Varchar (50) ,
        password Varchar (255) ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: photo
#------------------------------------------------------------

CREATE TABLE photo(
        id          int (11) Auto_increment  NOT NULL ,
        nom         Varchar (50) ,
        description Varchar (255) ,
        url         Varchar (255) ,
        longitude   Varchar (255) ,
        latitude    Varchar (25) ,
        id_serie Int ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: serie
#------------------------------------------------------------

CREATE TABLE serie(
        id        int (11) Auto_increment  NOT NULL ,
        ville     Varchar (50) ,
        latitude  Varchar (50) ,
        longitude Varchar (50) ,
        distance  Varchar (25) ,
        temps  Varchar (25) ,
        zoom      Varchar (25) ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: partie
#------------------------------------------------------------

CREATE TABLE partie(
        id        int (11) Auto_increment  NOT NULL ,
        token     Varchar (255) ,
        nb_photos Int ,
        status    Varchar (25) ,
        score     Varchar (25) ,
        joueur    Varchar (255) ,
        id_serie Int ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;

ALTER TABLE serie ADD CONSTRAINT FK_serie_id_photo FOREIGN KEY (id_photo) REFERENCES photo(id);
