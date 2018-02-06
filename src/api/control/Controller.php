<?php

	namespace geoquizz\api\control;

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	use illuminate\database\Eloquent\ModelNotFoundException as ModelNotFoundException;
	
	use Ramsey\Uuid\Uuid;

	use \geoquizz\common\models\Serie as serie;
	use \geoquizz\common\models\Partie as partie;
	use \geoquizz\common\models\Photo as photo;
	use \geoquizz\common\models\User as user;

	class Controller {

	private $container;

		public function  __construct(\Slim\Container $c)
		{
			$this->container = $c;
		}

		public function getSeries($req, $resp, $args) {

			$series = new serie();
			$series = $series->get();

			$resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

			$resp= $resp->withStatus(201);

			$tab = $series;

			$resp->getBody()->write(json_encode($tab));
			return $resp;		

		}


		public function getSeriesID($req, $resp, $args) {

			try{

				$series = new serie();
				$series = $series->where('id', '=', $args['id'])->firstOrFail();

				$resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

				$resp= $resp->withStatus(201);

				$tab = $series;

				$resp->getBody()->write(json_encode($tab));
				return $resp;	

			} catch(\Exception $e) {


				$resp= $resp->withStatus(400);

				$url = $this->container['router']->pathFor('serieID', [ 'id' => $args['id'] ]);

				$temp = array("type" => "error", "error" => '404', "message" => "ressource non disponible : ".$url);
				
				$resp->getBody()->write(json_encode($temp));

				return $resp;	
			}	

		}


		public function createPartie($req, $resp, $args) {

			if ($req->getAttribute( 'has_errors' )) {

				$resp= $resp->withStatus(400);

				$temp = array("type" => "error", "error" => '400', "message" => "Donnée manquante");
				
				$resp->getBody()->write(json_encode($temp));

				return $resp;	
			} 
			else {

				$parsedBody = $req->getParsedBody();

				$partie = new partie();
				$partie->token = Uuid::uuid1();
				$partie->joueur = $parsedBody['pseudo'];
				$partie->status = 1;
				$partie->score = 0;
				$partie->nb_photos = 10;

				$photo = new photo();
				$photo = $photo->where('id_serie', '=', 1)->select('id', 'longitude', 'latitude', 'url')->get();

				$serie = new serie();
				$serie = $serie->where('id', '=', 1)->first();

				try {
					$partie->save();
				} catch(\Exception $e) {
					echo $e->getmessage();
				}

				$resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

				$resp= $resp->withStatus(201);

				$tab = ['token' => $partie->token, 'image' => $photo, 'serie' => $serie ];

				$resp->getBody()->write(json_encode($tab));
				return $resp;

			}
		}

		public function updatePartie($req, $resp, $args) {

			if ($req->getAttribute( 'has_errors' )) {

				$resp= $resp->withStatus(400);

				$temp = array("type" => "error", "error" => '400', "message" => "Donnée manquante");
				
				$resp->getBody()->write(json_encode($temp));

				return $resp;	
			} 
			else {

				$parsedBody = $req->getParsedBody();

				$partie = new partie();
				$partie = $partie->where('token', '=', $parsedBody['token'])->first();
				$partie->status = 2;
				$partie->score = $parsedBody['score'];

				try {
					$partie->save();
				} catch(\Exception $e) {
					echo $e->getmessage();
				}

				$resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

				$resp= $resp->withStatus(201);

				$tab = ['token' => $partie->token];

				$resp->getBody()->write(json_encode($tab));
				return $resp;

			}
		}


		public function createUser($req, $resp, $args) {

			if ($req->getAttribute( 'has_errors' )) {

				$resp= $resp->withStatus(400);

				$temp = array("type" => "error", "error" => '400', "message" => "Donnée manquante");
				
				$resp->getBody()->write(json_encode($temp));

				return $resp;	
			} 
			else {

				$parsedBody = $req->getParsedBody();

				$user = new user();
				$user->nom = $parsedBody['nom'];
				$user->prenom = $parsedBody['prenom'];
				$user->mail = $parsedBody['mail'];
				$user->pseudo = $parsedBody['pseudo'];
				$user->password = $parsedBody['password'];

				try {
					$user->save();
				} catch(\Exception $e) {
					echo $e->getmessage();
				}

				$resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

				$resp= $resp->withStatus(201);

				$resp->getBody()->write(json_encode($user));
				return $resp;

			}
		}

		public function getUsers($req, $resp, $args) {

			$users = new user();
			$users = $users->get();

			$resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

			$resp= $resp->withStatus(200);

			$resp->getBody()->write(json_encode($users));

			return $resp;

		}

		public function createPhoto($req, $resp, $args) {

			if ($req->getAttribute( 'has_errors' )) {

				$resp= $resp->withStatus(400);

				$temp = array("type" => "error", "error" => '400', "message" => "Donnée manquante");
				
				$resp->getBody()->write(json_encode($temp));

				return $resp;	
			} 
			else {

				$parsedBody = $req->getParsedBody();

				$photo = new photo();
				$photo->nom = $parsedBody['nom'];
				$photo->description = $parsedBody['description'];
				$photo->url = $parsedBody['url'];
				$photo->longitude = $parsedBody['longitude'];
				$photo->latitude = $parsedBody['latitude'];
				$photo->id_serie = 1;

				try {
					$photo->save();
				} catch(\Exception $e) {
					echo $e->getmessage();
				}

				$resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

				$resp= $resp->withStatus(201);

				$resp->getBody()->write(json_encode($photo));
				return $resp;

			}
		}

		public function getPhotoID($req, $resp, $args) {

			try{
				$id = $args['id'];
				
				$resp = $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

				$photo = photo::where('id', '=', $id)->firstOrFail();

				$resp->getBody()->write(json_encode($photo));

				return $resp;

			}catch(\Exception $e) {

				$resp= $resp->withStatus(400);

				$url = $this->container['router']->pathFor('serieID', [ 'id' => $args['id'] ]);

				$temp = array("type" => "error", "error" => '404', "message" => "ressource non disponible : ".$url);
				
				$resp->getBody()->write(json_encode($temp));

				return $resp;	
			}
		}

		public function getPhotos($req, $resp, $args) {

			$photos = new photo();
			$photos = $photos->get();

			$resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

			$resp= $resp->withStatus(201);

			$resp->getBody()->write(json_encode($photos));

			return $resp;
		}


	}
