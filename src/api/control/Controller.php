<?php

	namespace geoquizz\api\control;

	use Ramsey\Uuid\Uuid;

	class Controller {

	private $container;

		public function  __construct(\Slim\Container $c)
		{
			$this->container = $c;
		}

		public function getSeries($req, $resp, $args) {

			$series = new \geoquizz\common\models\Serie();
			$series = $series->get();

			$resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

			$resp= $resp->withStatus(201);

			$tab = $series;

			$resp->getBody()->write(json_encode($tab));
			return $resp;		

		}


		public function getSeriesID($req, $resp, $args) {

			try{

				$series = new \geoquizz\common\models\Serie();
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

				$partie = new \geoquizz\common\models\Partie();
				$partie->token = Uuid::uuid1();
				$partie->joueur = $parsedBody['pseudo'];
				$partie->status = 1;
				$partie->score = 0;
				$partie->nb_photos = 10;

				$photo = new \geoquizz\common\models\Photo();
				$photo = $photo->select('id', 'longitude', 'latitude', 'url')->get();

				try {
					$partie->save();
				} catch(\Exception $e) {
					echo $e->getmessage();
				}

				$resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

				$resp= $resp->withStatus(201);

				//$resp = $resp->withHeader('Location', $this->container['router']->pathFor('comid', ['id' => $com->id] ) );

				$tab = ['token' => $partie->token, 'image' => $photo ];

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

				$partie = new \geoquizz\common\models\Partie();
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

				//$resp = $resp->withHeader('Location', $this->container['router']->pathFor('comid', ['id' => $com->id] ) );

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

				$user = new \geoquizz\common\models\User();
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

				//$resp = $resp->withHeader('Location', $this->container['router']->pathFor('comid', ['id' => $com->id] ) );
				//$tab = ['token' => $user->token, 'image' => $photo ];

				$resp->getBody()->write(json_encode($user));
				return $resp;

			}
		}

		public function getUsers($req, $resp, $args) {

			$users = new \geoquizz\common\models\User();
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

				$photo = new \geoquizz\common\models\Photo();
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

				//$resp = $resp->withHeader('Location', $this->container['router']->pathFor('comid', ['id' => $com->id] ) );
				//$tab = ['token' => $user->token, 'image' => $photo ];

				$resp->getBody()->write(json_encode($photo));
				return $resp;

			}
		}

		public function getPhotoID($req, $resp, $args) {

			try{
				$id = $args['id'];
				
				$resp = $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

				$photo = \geoquizz\common\models\Photo::where('id', '=', $id)->firstOrFail();

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

			$photos = new \geoquizz\common\models\Photo();
			$photos = $photos->get();

			$resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

			$resp= $resp->withStatus(201);

			$resp->getBody()->write(json_encode($photos));

			return $resp;
		}


	}
