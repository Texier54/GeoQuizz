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


$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', $req->getHeader('Origin')[0])
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});


$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});




$app->get('/series[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->getSeries($req, $resp, $args);
    }
);


$app->get('/series/{id}', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->getSeriesID($req, $resp, $args);
    }
)->setName('serieID');


/* Validator */
$validatorsCreatePartie = [
    'pseudo' => v::notEmpty(),
    'nb_photos' => v::notEmpty(),
    'serie_id' => v::notEmpty(),
    'difficulte' => v::notEmpty(),
];

$app->get('/partie[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->getTabScore($req, $resp, $args);
    }
);

$app->post('/partie[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->createPartie($req, $resp, $args);
    }
);


/* Validator */
$validatorsUpdatePartie = [
    'score' => v::intVal(),
    'etat' => v::notEmpty(),
];

$app->put('/partie/{token}', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->updatePartie($req, $resp, $args);
    }
)->add(new Validation($validatorsUpdatePartie));

$app->post('/user[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->createUser($req, $resp, $args);
    }
);

$app->get('/users[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->getUsers($req, $resp, $args);
    }
);

$app->post('/photo[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->createPhoto($req, $resp, $args);
    }
);

$app->get('/photo/{id}', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->getPhotoID($req, $resp, $args);
    }
)->setName('photoID');

$app->get('/photos[/]', function (Request $req, Response $resp, $args) {
    $c = new geoquizz\api\control\Controller($this);
    return $c->getPhotos($req, $resp, $args);
    }
);

$app->run();
 