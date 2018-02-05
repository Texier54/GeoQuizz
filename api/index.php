<?php


require_once __DIR__.'/../src/vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Slim application instance
$conf = ['settings' => ['displayErrorDetails' => true]];
$app = new \Slim\App($conf);

//Eloquent ORM settings
require_once 'db.php';

use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Respect\Validation\Validator as v;
use \DavidePastore\Slim\Validation\Validation as Validation;

$error = require_once __DIR__.'/../src/conf/error.php';


function checkToken ( Request $rq, Response $rs, callable $next ) 
{
	// récupérer l'identifiant de cmmde dans la route et le token
	$id = $rq->getAttribute('route')->getArgument( 'id');
	$token = $rq->getQueryParam('token', null);

	// vérifier que le token correspond à la commande
	try 
	{
		\geoquizz\common\models\Commande::where('id', '=', $id)->where('token', '=',$token)->firstOrFail();

	} catch (ModelNotFoundException $e) {

		$rs= $rs->withHeader( 'Content-type', "application/json;charset=utf-8");

		$rs= $rs->withStatus(404);

		$temp = array("type" => "error", "error" => '404', "message" => "Le token n'est pas valide");
			
		$rs->getBody()->write(json_encode($temp));
		return $rs;

	};

	return $next($rq, $rs);
};



/* Validator */
$validatorsCreatePartie = [
    'pseudo' => v::notEmpty(),
];


$app->post('/partie[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->createPartie($req, $resp, $args);
    }
)->add(new Validation( $validatorsCreatePartie));


$app->run();
 