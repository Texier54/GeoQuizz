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
        latitude    Float (11) ,
        longitude   Float (11) ,
        id_serie Int ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: serie
#------------------------------------------------------------

CREATE TABLE serie(
        id        int (11) Auto_increment  NOT NULL ,
        ville     Varchar (50) ,
        latitude    Float (11) ,
        longitude   Float (11) ,
        distance  int (11) ,
        temps  int (11) ,
        zoom      int (11) ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: partie
#------------------------------------------------------------

CREATE TABLE partie(
        id        int (11) Auto_increment  NOT NULL ,
        token     Varchar (255) ,
        nb_photos Int ,
        status    int (11) ,
        score     int (11) ,
        joueur    Varchar (255) ,
	difficulte Float (11) ,
  	created_at datetime DEFAULT NULL,
  	updated_at datetime DEFAULT NULL,
        id_serie Int ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;
