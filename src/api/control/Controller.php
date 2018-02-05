<?php

	namespace geoquizz\api\control;

	use Ramsey\Uuid\Uuid;

	class Controller {

	private $container;

		public function  __construct(\Slim\Container $c)
		{
			$this->container = $c;
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
				$photo = $photo->select('id', 'longitude', 'latitude')->get();

				try {
					$partie->save();
				} catch(\Exception $e) {
					echo $e->getmessage();
				}

				$resp= $resp->withHeader( 'Content-type', "application/json;charset=utf-8");

				$resp= $resp->withStatus(201);

				//$resp = $resp->withHeader('Location', $this->container['router']->pathFor('comid', ['id' => $com->id] ) );

				$tab = ['token' => $partie->token, 'image' => [ $photo ]];

				$resp->getBody()->write(json_encode($tab));
				return $resp;

			}
		}




	}
