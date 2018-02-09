<?php

/**
 * File:  rest.php
 * Creation Date: 06/02/2018
 * description:Geoquizz Documentation
 *
 * @author: jordan
 */

/**
 * @api {get} /series  accéder à toutes les séries
 * @apiGroup Series
 * @apiName getSeries
 * @apiVersion 0.1.0
 *
 *
 * @apiDescription Accès à toutes les ressources de type série :
 * permet d'accéder à la représentation des ressources séries.
 * Retourne une représentation json des ressources, incluant leur id, nom et description.
 *
 * @apisuccess (Succès : 200) OK Ressources trouvées
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        "type" : "collection",
 *          serie : {
 *              "id"  : 1 ,
 *              "ville" : "nancy",
 *              "latitude" : "48.6",
 *              "longitude" : "2.41112",
 *              "distance" : "20",
 *              "temps" : "60",
 *              "zoom" : "13"
 *          }
 *     }
 * 
 * @apiError (Erreur : 404) NotFound Pas de série dans la base de données.
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "type" : "error',
 *       "error" : 404,
 *       "message" : Ressource non disponible : /series/"
 *     }
 */

$app->get('/series[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->getSeries($req, $resp, $args);
    }
);

/**
 * @api {get} /series/{id}  accéder à une série
 * @apiGroup Series
 * @apiName getSeriesID
 * @apiVersion 0.1.0
 *
 * @apiDescription Accès à une ressource de type série :
 * permet d'accéder à la représentation de la ressource série désignée.
 * Retourne une représentation json de la ressource, incluant son id, son nom, sa description.
 *
 * @apiParam (request parameter) {Number} id Identifiant de la photo
 * 
 * @apisuccess (Succès : 200) OK Ressource trouvée
 * 
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        "type" : "object",
 *          série : {
 *              "id"  : 1 ,
 *              "ville" : "nancy",
 *              "latitude" : "48.6",
 *              "longitude" : "2.41112",
 *              "distance" : "20",
 *              "temps" : "60",
 *              "zoom" : "13"
 *          }
 *     }
 */

$app->get('/series/{id}', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->getSeriesID($req, $resp, $args);
    }
)->setName('serieID');


/**
 * @api {post} /partie/  Créer une partie
 * @apiGroup Partie
 * @apiName createPartie
 * @apiVersion 0.1.0
 *
 *
 * @apiDescription Création d'une ressource de type Partie:
 * permet d'ajouter une ressource partie.
 * Retourne une représentation json de la ressource, incluant son id, son nombre de photos, son status,
 * le score, le pseudo du joueur ainsi que l'id de la serie jouée.
 *
 * @apiParam {String} joueur Pseudo du joueur
 * @apiParam {Number} nb_photos Le nombre de photos choisi : entre 2 et 20
 * @apiParam {String} difficulte Choix de la difficulté : Normal, Medium, Hard
 * 
 * @apiSuccess (Réponse : 201) {json} Created représentation json de la nouvelle ressource partie
 *
 * @apiSuccessExample {response} exemple de réponse en cas de succès
 *     HTTP/1.1 201 CREATED
 *      Location: http://api.geoquizz.local/partie/
 *      Content-Type: application/json;charset=utf8
 *
 *
 * @apiError (Réponse : 400) MissingParameter paramètre manquant dans la requête
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 400 Bad Request
 *     {
 *       "type": "error",
 *       "error" : 400,
 *       "message" : "donnée manquante (pseudo)"
 *     }
 */

$app->post('/partie[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->createPartie($req, $resp, $args);
    }
)->add(new Validation( $validatorsCreatePartie));



/**
 * @api {put} /partie/{token} modifier une partie
 * @apiGroup Partie
 * @apiName updatePartie
 * @apiVersion 0.1.0
 *
 *
 *
 * @apiDescription Accès à unes ressource de type partie :
 * Permet de modifier une partie nottament son score ainsi que le pseudo principalement,
 * lorsque le joueur a terminé sa partie.
 *
 * @apiParam {String} etat L'état de la partie
 * @apiParam {Number} score Score du joueur
 *
 * @apiParam (request parameter) {Token}Token
 * 
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *      Location: http://api.geoquizz.local/partie/
 *      Content-Type: application/json;charset=utf8
 * 
 * @apiError (Réponse : 400) MissingParameter paramètre manquant dans la requête
 * 
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 400 Bad Request
 *     {
 *       "type": "error",
 *       "error" : 400,
 *       "message" : "donnée manquante (etat)"
 *     }
 */

$app->put('/partie[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->updatePartie($req, $resp, $args);
    }
)->add(new Validation( $validatorsUpdatePartie));


/**
 * @api {post} /user/  créer un utilisateur
 * @apiGroup User
 * @apiName createUser
 * @apiVersion 0.1.0
 *
 *
 * @apiDescription Création d'une ressource de type User.
 * L'utilisateur est ajoutée dans la base, son identifiant est créé.
 * Le nom, prénom, mail, password de l'utilisateur doivent être fournis.
 *
 *
 * @apiParam {String} nom Nom du nouvel utilisateur
 * @apiParam {String} prenom Prénom du nouvel utilisateur
 * @apiParam {String} mail Mail du nouvel utilisateur
 * @apiParam {String} password Mot de passe du nouvel utilisateur (hashé)
 * @apiParam {String} pseudo Pseudo du nouvel utilisateur
 *
 *
 * @apiSuccess (Réponse : 201) {json} Created représentation json de la nouvelle ressource utilisateur
 *
 * @apiSuccessExample {response} exemple de réponse en cas de succès
 *     HTTP/1.1 201 CREATED
 *     Location: http://api.geoquizz.local/user/{id}
 *     Content-Type: application/json;charset=utf8
 *
 *
 * @apiError (Réponse : 400) MissingParameter paramètre manquant dans la requête
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 400 Bad Request
 *     {
 *       "type": "error",
 *       "error" : 400,
 *       "message" : "donnée manquante (pseudo)"
 *     }
 */

$app->post('/user[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->createUser($req, $resp, $args);
    }
);

/**
 * @api {get} /users/  Récupérer tous les utilisateurs
 * @apiGroup User
 * @apiName getUsers
 * @apiVersion 0.1.0
 *
 *
 * @apiDescription Accès à la ressource User.
 * Retourne la liste de tous les utilisateurs avec toutes les informations les concernants.
 *
 * @apiSuccess (Réponse : 200) OK Ressources trouvées
 *
 *
 * @apiSuccessExample {response} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *     Content-Type: application/json;charset=utf8
 *
 *      {
 *          "type" : "collection",
 *          user : {
 *              "nom" : "Michel",
 *              "prenom" : "Jean",
 *              "mail" : "jeanMi@hotmail.fr"
 *              "pseudo" : "JM"
 *          }
 *      }
 *
 * 
 * @apiError (Réponse : 404) NotFound Pas d'utilisateur dans la base de données.
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur 400
 *     HTTP/1.1 404 Not Found
 *     {
 *       "type": "error",
 *       "error" : 404,
 *       "message" : "Ressource non disponnible"
 *     }
 *
 */

$app->get('/users[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->getUsers($req, $resp, $args);
    }
);


/**
 * @api {post} /photo/  Ajouter une photo dans la base de données
 * @apiGroup Photos
 * @apiName createPhoto
 * @apiVersion 0.1.0
 *

 *
 * @apiDescription Permet d'ajouter une photo dans la base de données.
 * Un id de la série concernée devra être renseigné ainsi que :
 *  Le nom, la description, l'url de la photo, la longitude et la latitude.
 *
 *
 * @apiSuccess (Réponse : 201) {json} Created représentation json de la nouvelle ressource photo
 *
 * @apiParam {String} nom Nom de la photo
 * @apiParam {String} description La description de la photo
 * @apiParam {String} url L'url de la photo
 * @apiParam {String} longitude La longitude de la photo
 * @apiParam {String} latitude La latitude de la photo 
 * @apiParam {Number} id_serie Id de la série ou la photo est présente
 * 
 * 
 * @apiSuccessExample {response} exemple de réponse en cas de succès
 *     HTTP/1.1 201 CREATED
 *     Location: http://api.geoquizz.local/photo/
 *     Content-Type: application/json;charset=utf8
 *
 *
 * @apiError (Réponse : 400) MissingParameter paramètre manquant dans la requête
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 400 Bad Request
 *     {
 *       "type": "error",
 *       "error" : 400,
 *       "message" : "donnée manquante (url)"
 *     }
 */

$app->post('/photo[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->createPhoto($req, $resp, $args);
    }
);

/**
 * @api {get} /photo/{id} accéder à une photo cible
 * @apiGroup Photos
 * @apiName getPhotoID
 * @apiVersion 0.1.0
 *
 *
 * @apiDescription Accès à une ressource de type photo :
 * permet d'accéder à la représentation de la ressource photo désignée.
 * Retourne une représentation json de la ressource, incluant son nom, description,
 * l'url, longitude, latitude et son id de série.
 *
 * @apiParam (request parameter) {Number} id Identifiant unique de la photo
 *
 *
 * @apiSuccess (Succès : 200) OK Ressource trouvée
 * 
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        "type" : "object",
 *        	photo : {
 *              "id"  : "3",
 *              "description" : "Place Charles III",
 *              "url" : "http://image-photos.linternaute.com/image_photo/450/2976037860/571681.jpg",
 *              "longitude" : "48.16"
 *              "latitude" : "-10.48"
 *              "id_serie" : "1"
 *        	}
 *     }
 *
 * @apiError (Erreur : 404) NotFound Ressource inconnue.
 * @apiError (Erreur : 400) MissingParameters Données manquantes (id).
 * 
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "type" : "error",
 *       "error" : 404,
 *       "message" : "ressource non disponible"
 *     }
 */

$app->get('/photo/{id}', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->getPhotoID($req, $resp, $args);
    }
)->setName('photoID');

/**
 * @api {get} /photos  accéder aux photos
 * @apiGroup Photos
 * @apiName getPhotos
 * @apiVersion 0.1.0
 *
 *
 * @apiDescription Accès aux ressources de type photos :
 * permet d'accéder à la représentation des ressources photos.
 * Retourne une représentation json de la ressource, incluant l'url, longitude, latitude et son id de série.
 *
 * @apiSuccess(Succès : 200) OK Ressources trouvées.
 * 
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        "type" : "object",
 *        	photo : {
 *              "id"  : "3",
 *              "nom" : "PlaceStan",
 *              "description" : "Place Stan",
 *              "url" : "http://image-photos.linternaute.com/image_photo/450/2976037860/571681.jpg",
 *              "longitude" : "48.16",
 *              "latitude" : "-10.48",
 *              "id_serie" : "1"
 *        	}
 *     }
 *
 * @apiError (Erreur : 404) NotFound Pas de photo dans la base de données.
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "type" : "error",
 *       "error" : 404,
 *       "message" : "ressource non disponible, pas de photos dans la base."
 *     }
 */

$app->get('/photos[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->getPhotos($req, $resp, $args);
    }
);









$app->get('/partie[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->getTabScore($req, $resp, $args);
    }
);



public function getTabScore($req, $resp, $args) {

    $tabScore = new partie();
    $tabScore = $tabScore->select("nb_photos", "status", "score", "joueur", "id_serie", "difficulte", "created_at")
                        ->take(10)
                        ->where("status", "=", 2)
                        ->orderBy("score", "DESC")
                        ->get();

    $resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

    $resp= $resp->withStatus(201);

    $tab = $tabScore;

    $resp->getBody()->write(json_encode($tab));
    return $resp;		

}

/**
 * @api {get} /partie/ Obtenir le tableau des scores
 * @apiGroup Partie
 * @apiName getTabScore
 * @apiVersion 0.1.0
 *
 *
 * @apiDescription Accès à une ressource de type partie :
 * Tableau qui affiche le score, le nombre de photos, la série et sa difficulté, le status de la partie ainsi que le pseudo du joueur.
 * Enfin, la date de la création de la partie
 *
 *
 *
 * @apiSuccess (Succès : 200) OK Ressource trouvée
 * 
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        "type" : "array",
 *        	partie : {
 *              "nb_photos"  : "10",
 *              "status" : "2",
 *              "score" : "120",
 *              "joueur" : "Jeandudu",
 *              "id_serie" : "1",
 *              "difficulté" : "1",
 *              "created_at" : "2018-05-02 10:20:21"
 *        	}
 *     }
 *
 * @apiError (Erreur : 404) NotFound Ressource inconnue.
 * 
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "type" : "error",
 *       "error" : 404,
 *       "message" : "ressource non disponible, aucune partie de créée."
 *     }
 */







