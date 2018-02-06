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
				$partie->joueur = filter_var($parsedBody['pseudo'], FILTER_SANITIZE_STRING);
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




	}
