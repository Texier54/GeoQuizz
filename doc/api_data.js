define({ "api": [
  {
    "type": "post",
    "url": "/partie/}",
    "title": "Créer une partie",
    "group": "Partie",
    "name": "createPartie",
    "version": "0.1.0",
    "description": "<p>Création d'une ressource de type Partie: permet d'ajouter une ressource partie. Retourne une représentation json de la ressource, incluant son id, son nombre de photos, son status, le score, le pseudo du joueur ainsi que l'id de la serie jouée.</p>",
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type de la réponse, ici resource</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Object",
            "optional": false,
            "field": "partie",
            "description": "<p>la ressource partie retournée</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "partie.id",
            "description": "<p>Identifiant du partie</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "partie.nb_photo",
            "description": "<p>Nombre de photos de la partie</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "partie.score",
            "description": "<p>Le score de la partie</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "partie.pseudo",
            "description": "<p>Le pseudo du joueur</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "partie.id_serie",
            "description": "<p>Identifiant de la série</p>"
          }
        ],
        "Réponse : 201": [
          {
            "group": "Réponse : 201",
            "type": "json",
            "optional": false,
            "field": "Created",
            "description": "<p>représentation json de la nouvelle ressource partie</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "HTTP/1.1 201 CREATED\nLocation: http://api.geoquizz.local/parties/{id}\nContent-Type: application/json;charset=utf8",
          "type": "response"
        }
      ]
    },
    "error": {
      "fields": {
        "Réponse : 400": [
          {
            "group": "Réponse : 400",
            "optional": false,
            "field": "MissingParameter",
            "description": "<p>paramètre manquant dans la requête</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 400 Bad Request\n{\n  \"type\": \"error\",\n  \"error\" : 400,\n  \"message\" : \"donnée manquante (description)\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./rest.php",
    "groupTitle": "Partie"
  },
  {
    "type": "put",
    "url": "/partie",
    "title": "modifier une partie",
    "group": "Partie",
    "name": "updatePartie",
    "version": "0.1.0",
    "description": "<p>Accès à unes ressource de type partie : Permet de modifier une partie nottament son score ainsi que le pseudo principalement, lorsque le joueur a terminé sa partie.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant unique de la partie à modifier</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type de la réponse, ici resource</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "HTTP/1.1 200 OK\n\n{\n   \"type\" : \"object\",\n   partie : {\n       \"id\"  : 24 ,\n       \"nb_photo\" : \"10\",\n       \"score\" : \"250\",\n       \"pseudo\" : \"Jean-Michel\",\n       \"id_serie\" : \"1\"\n   }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./rest.php",
    "groupTitle": "Partie"
  },
  {
    "type": "post",
    "url": "/photo/",
    "title": "Ajouter une photo dans la base de données",
    "group": "Photos",
    "name": "createPhoto",
    "version": "0.1.0",
    "description": "<p>Permet d'ajouter une photo dans la base de données. Un id de la série concernée devra être renseigné ainsi que : Le nom, la description, l'url de la photo, la longitude et la latitude.</p>",
    "success": {
      "fields": {
        "Réponse : 201": [
          {
            "group": "Réponse : 201",
            "type": "json",
            "optional": false,
            "field": "Created",
            "description": "<p>représentation json de la nouvelle ressource photo</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "HTTP/1.1 201 CREATED\nLocation: http://api.geoquizz.local/photo/{id}\nContent-Type: application/json;charset=utf8",
          "type": "response"
        }
      ]
    },
    "error": {
      "fields": {
        "Réponse : 400": [
          {
            "group": "Réponse : 400",
            "optional": false,
            "field": "MissingParameter",
            "description": "<p>paramètre manquant dans la requête</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 400 Bad Request\n{\n  \"type\": \"error\",\n  \"error\" : 400,\n  \"message\" : \"donnée manquante (url)\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./rest.php",
    "groupTitle": "Photos"
  },
  {
    "type": "get",
    "url": "/photo/{id}",
    "title": "accéder à une photo cible",
    "group": "Photos",
    "name": "getPhotoID",
    "version": "0.1.0",
    "description": "<p>Accès à une ressource de type photo : permet d'accéder à la représentation de la ressource photo désignée. Retourne une représentation json de la ressource, incluant son nom, description, l'url, longitude, latitude et son id de série.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant unique de la photo</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "Object",
            "optional": false,
            "field": "La",
            "description": "<p>photo cible</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "HTTP/1.1 200 OK\n\n{\n   \"type\" : \"object\",\n   \tphoto : {\n   \t    \"id\"  : \"3\",\n   \t    \"description\" : \"Place Charles III\",\n   \t    \"url\" : \"4\",\n   \t    \"longitude\" : \"48.16\"\n         \"latitude\" : \"-10.48\"\n         \"id_serie\" : \"1\"\n   \t}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "NotFound",
            "description": "<p>Ressource inconnue.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 404 Not Found\n\n{\n  \"type\" : \"error\",\n  \"error\" : 404,\n  \"message\" : \"ressource non disponible\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./rest.php",
    "groupTitle": "Photos"
  },
  {
    "type": "get",
    "url": "/photos",
    "title": "accéder aux photos",
    "group": "Photos",
    "name": "getPhotos",
    "version": "0.1.0",
    "description": "<p>Accès aux ressources de type photos : permet d'accéder à la représentation des ressources photos. Retourne une représentation json de la ressource, incluant l'url, longitude, latitude et son id de série.</p>",
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type de la réponse, ici resource</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "HTTP/1.1 200 OK\n\n{\n   \"type\" : \"object\",\n   \tphoto : {\n   \t    \"id\"  : \"3\",\n   \t    \"description\" : \"Place Stan\",\n   \t    \"url\" : \"4\",\n   \t    \"longitude\" : \"48.16\"\n         \"latitude\" : \"-10.48\"\n         \"id_serie\" : \"1\"\n   \t}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "NotFound",
            "description": "<p>Ressource inexistante</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 404 Not Found\n\n{\n  \"type\" : \"error\",\n  \"error\" : 404,\n  \"message\" : \"ressource non disponible, pas de photos dans la base.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./rest.php",
    "groupTitle": "Photos"
  },
  {
    "type": "get",
    "url": "/series",
    "title": "accéder à toutes les séries",
    "group": "Series",
    "name": "getSeries",
    "version": "0.1.0",
    "description": "<p>Accès à toutes les ressources de type série : permet d'accéder à la représentation des ressources séries. Retourne une représentation json des ressources, incluant leur id, nom et description.</p>",
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "Object",
            "optional": false,
            "field": "Serie",
            "description": "<p>la ressource serie retournée</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "HTTP/1.1 200 OK\n\n{\n   \"type\" : \"collection\",\n   serie : {\n       \"id\"  : 1 ,\n       \"nom\" : \"serieNancy\",\n       \"description\" : \"Une série de photo concernant la ville de Nancy\"\n   }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./rest.php",
    "groupTitle": "Series"
  },
  {
    "type": "get",
    "url": "/series/{id}",
    "title": "accéder à une série",
    "group": "Series",
    "name": "getSeriesID",
    "version": "0.1.0",
    "description": "<p>Accès à une ressource de type série : permet d'accéder à la représentation de la ressource série désignée. Retourne une représentation json de la ressource, incluant son id, son nom, sa description.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant unique de la série</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>type de la réponse, ici resource</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Object",
            "optional": false,
            "field": "serie",
            "description": "<p>la ressource serie retournée</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "serie.id",
            "description": "<p>Identifiant de la série</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "serie.nom",
            "description": "<p>Nom de la série</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "serie.description",
            "description": "<p>Description de la série</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "HTTP/1.1 200 OK\n\n{\n   \"type\" : \"resource,\n   série : {\n       \"id\"  : 1 ,\n       \"nom\" : \"série1\",\n       \"description\" : \"Série concernant la ville de Nancy\"\n   }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "NotFound",
            "description": "<p>Serie inexistante.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 404 Not Found\n\n{\n  \"type\" : \"error',\n  \"error\" : 404,\n  \"message\" : ressource non disponible : /serie/1/\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./rest.php",
    "groupTitle": "Series"
  },
  {
    "type": "post",
    "url": "/user/",
    "title": "créer un utilisateur",
    "group": "User",
    "name": "createUser",
    "version": "0.1.0",
    "description": "<p>Création d'une ressource de type User. L'utilisateur est ajoutée dans la base, son identifiant est créé. Le nom, prénom, mail, password de l'utilisateur doivent être fournis.</p>",
    "parameter": {
      "fields": {
        "request parameters": [
          {
            "group": "request parameters",
            "type": "String",
            "optional": false,
            "field": "nom",
            "description": "<p>Nom du nouvel utilisateur</p>"
          },
          {
            "group": "request parameters",
            "type": "String",
            "optional": false,
            "field": "pr",
            "description": "<p>énom Prénom du nouvel utilisateur</p>"
          },
          {
            "group": "request parameters",
            "type": "String",
            "optional": false,
            "field": "mail",
            "description": "<p>Mail du nouvel utilisateur</p>"
          },
          {
            "group": "request parameters",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>Mot de passe du nouvel utilisateur</p>"
          },
          {
            "group": "request parameters",
            "type": "String",
            "optional": false,
            "field": "pseudo",
            "description": "<p>du nouvel utilisateur</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "request headers": [
          {
            "group": "request headers",
            "type": "String",
            "optional": false,
            "field": "Content-Type:",
            "defaultValue": "application/json",
            "description": "<p>format utilisé pour les données transmises</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Réponse : 201": [
          {
            "group": "Réponse : 201",
            "type": "json",
            "optional": false,
            "field": "Created",
            "description": "<p>représentation json de la nouvelle ressource utilisateur</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "HTTP/1.1 201 CREATED\nLocation: http://api.geoquizz.local/user/{id}\nContent-Type: application/json;charset=utf8",
          "type": "response"
        }
      ]
    },
    "error": {
      "fields": {
        "Réponse : 400": [
          {
            "group": "Réponse : 400",
            "optional": false,
            "field": "MissingParameter",
            "description": "<p>paramètre manquant dans la requête</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 400 Bad Request\n{\n  \"type\": \"error\",\n  \"error\" : 400,\n  \"message\" : \"donnée manquante (description)\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./rest.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/users/",
    "title": "Récupérer tous les utilisateurs",
    "group": "User",
    "name": "getUsers",
    "version": "0.1.0",
    "description": "<p>Accès à la ressource User. Retourne la liste de tous les utilisateurs avec toutes les informations les concernants.</p>",
    "success": {
      "fields": {
        "Réponse : 200": [
          {
            "group": "Réponse : 200",
            "type": "json",
            "optional": false,
            "field": "OK",
            "description": "<p>json Représentation de la liste des utilisateurs.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "HTTP/1.1 200 OK\nContent-Type: application/json;charset=utf8\n\n{\n  \"nom\" : \"Michel\",\n  \"prenom\" : \"Jean\"\n  \"mail\" : \"jeanMi@hotmail.fr\"\n  \"pseudo\" : \"JM\"\n}",
          "type": "response"
        }
      ]
    },
    "error": {
      "fields": {
        "Réponse : 400": [
          {
            "group": "Réponse : 400",
            "optional": false,
            "field": "MissingParameter",
            "description": "<p>paramètre manquant dans la requête</p>"
          }
        ],
        "Réponse : 404": [
          {
            "group": "Réponse : 404",
            "optional": false,
            "field": "NotFound",
            "description": "<p>Pas d'utilisateurs présents dans la base de données.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur 400",
          "content": "HTTP/1.1 400 Bad Request\n{\n  \"type\": \"error\",\n  \"error\" : 400,\n  \"message\" : \"donnée manquante (description)\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./rest.php",
    "groupTitle": "User"
  }
] });
