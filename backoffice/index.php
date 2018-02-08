<?php
require_once __DIR__.'/../src/vendor/autoload.php';
session_start();
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
//Slim application instance
$conf = ['settings' => ['displayErrorDetails' => true]];
$app = new \Slim\App($conf);
//Eloquent ORM settings
require_once __DIR__.'/db.php';
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Respect\Validation\Validator as v;
use \DavidePastore\Slim\Validation\Validation as Validation;
$error = require_once __DIR__.'/../src/conf/error.php';
// Fetch DI Container
$container = $app->getContainer();
// Register Twig View helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('./templates', [
        'cache' => false,
        'debug' => true
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Twig_Extension_Debug());
    $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));
    $view->addExtension(new Knlv\Slim\Views\TwigMessages(
        new Slim\Flash\Messages()
    ));
    return $view;
};
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};
/************************************
        Routes
*************************************/
$app->get('/', function ($request, $response, $args) {

    if(!isset($_SESSION['pseudo'])) {
        return $response->withRedirect($this->router->pathFor('connexion'), 301);
    }

    $arr = new \geoquizz\common\models\Serie();
    $requete = $arr->get();
    return $this->view->render($response, 'index.html.twig', [
        'data' => $requete,
        'session' => isset($_SESSION['pseudo'])
    ]);
})->setName('home');

$app->get('/serie/{id}', function ($request, $response, $args) {

    if(!isset($_SESSION['pseudo'])) {
        return $response->withRedirect($this->router->pathFor('connexion'), 301);
    }

    $arr2 = \geoquizz\common\models\Photo::where('id_serie', '=', $args['id'])->get();
    $arr = \geoquizz\common\models\Serie::where('id', '=', $args['id'])->firstOrFail();

    return $this->view->render($response, 'serie.html.twig', [
        'data' => $arr,
        'photos' => $arr2,
        'session' => isset($_SESSION['pseudo'])
    ]);
})->setName('serie');

$app->get('/addPhoto/{id}', function ($request, $response, $args) {

    if(!isset($_SESSION['pseudo'])) {
        return $response->withRedirect($this->router->pathFor('connexion'), 301);
    }

    $arr = \geoquizz\common\models\Serie::where('id', '=', $args['id'])->firstOrFail();

    return $this->view->render($response, 'addPhoto.html.twig', [
        'data' => $arr,
        'session' => isset($_SESSION['pseudo'])
    ]);
})->setName('addPhoto');

$app->get('/addSerie', function ($request, $response, $args) {

    if(!isset($_SESSION['pseudo'])) {
        return $response->withRedirect($this->router->pathFor('connexion'), 301);
    }

    return $this->view->render($response, 'addSerie.html.twig', [
        'session' => isset($_SESSION['pseudo'])
    ]);
})->setName('addSerie');

/*     Validator     */
$validateAddSerie = [
    'ville'    => v::StringType()->length(3,30)->notEmpty(),
    'longitude'    => v::floatVal()->notEmpty(),
    'latitude'    => v::floatVal()->notEmpty(),
    'temps'    => v::positive()->notEmpty(),
    'distance'    => v::positive()->notEmpty(),
    'zoom'    => v::StringType()->intVal()->notEmpty()
];

$app->post('/addSerie', function ($request, $response, $args) {

    if ($request->getAttribute( 'has_errors' )) {

        $this->flash->addMessage('ville', 'Ville needs to be a string 3 to 30 characters long.');
        $this->flash->addMessage('longitude', 'Longitude needs to be a float value.');
        $this->flash->addMessage('latitude', 'Latitude needs to be a float value.');
        $this->flash->addMessage('temps', 'Temps needs to be a positive integer.');
        $this->flash->addMessage('distance', 'Distance needs to be a positive integer.');
        $this->flash->addMessage('zoom', 'Zoom needs to be an integer.');

        return $response->withRedirect($this->router->pathFor('addSerie'), 302);

    }

    $parsedBody = $request->getParsedBody();
    $serie = new \geoquizz\common\models\Serie();

    if( isset($parsedBody['longitude']) && isset($parsedBody['latitude']) &&
        isset($parsedBody['ville']) && isset($parsedBody['zoom']) &&
        isset($parsedBody['temps']) && isset($parsedBody['distance']) 
    )
    {
		$serie->ville = $parsedBody['ville'];
		$serie->zoom = $parsedBody['zoom'];
		$serie->longitude = $parsedBody['longitude'];
		$serie->latitude = $parsedBody['latitude'];
		$serie->temps = $parsedBody['temps'];
		$serie->distance = $parsedBody['distance'];
		try {
			$serie->save();
		} catch(\Exception $e) {
			echo $e->getmessage();
		}
        
        return $response->withRedirect($this->router->pathFor('home'), 301);
    }
    else 
    {
        return $this->view->render($response, 'addSerie.html.twig', []);
    }
})->add(new Validation($validateAddSerie));

$app->get('/deleteSerie/{id}', function ($request, $response, $args) {

    $photo = \geoquizz\common\models\Photo::where('id_serie', '=', $args['id'])->delete();

    $serie = \geoquizz\common\models\Serie::where('id', '=', $args['id'])->firstOrFail();
    $serie->delete();

    return $response->withRedirect($this->router->pathFor('home'));

})->setName('deleteSerie');

$app->get('/deletePhoto/{id}', function ($request, $response, $args) {

    $arr = \geoquizz\common\models\Photo::where('id', '=', $args['id'])->firstOrFail();

    $arr->delete();

    return $response->withRedirect($this->router->pathFor('home'));

})->setName('deletePhoto');

/*     Validator     */
$validateAddPhoto = [
    'longitude'    => v::floatVal()->notEmpty(),
    'latitude'    => v::floatVal()->notEmpty(),
    'nom'    => v::StringType()->length(3,30)->notEmpty(),
    'desc'    => v::StringType()->length(3,30)->notEmpty(),
    'url'    => v::notEmpty()
];

$app->post('/addPhoto/{id}', function ($request, $response, $args) {
    if ($request->getAttribute( 'has_errors' )) {

        $this->flash->addMessage('nom', 'Nom needs to be a string 3 to 30 characters long.');
        $this->flash->addMessage('desc', 'Description needs to be a string 3 to 30 characters long.');
        $this->flash->addMessage('url', 'Url needs to be an image and not empty.');
        $this->flash->addMessage('longitude', 'Longitude needs to be a float value.');
        $this->flash->addMessage('latitude', 'Latitude needs to be a float value.');

        return $response->withRedirect($this->router->pathFor('addPhoto', ['id' => $args['id']]));

    }

    $parsedBody = $request->getParsedBody();
    $photo = new \geoquizz\common\models\Photo();

    if( isset($parsedBody['longitude']) && isset($parsedBody['latitude']) &&
        isset($parsedBody['nom']) && isset($parsedBody['desc']) &&
        isset($parsedBody['url']) 
    )
    {
		$photo->nom = $parsedBody['nom'];
		$photo->description = $parsedBody['desc'];
		$photo->longitude = $parsedBody['longitude'];
		$photo->latitude = $parsedBody['latitude'];
		$photo->url = $parsedBody['url'];
		$photo->id_serie = $args['id'];
		try {
			$photo->save();
		} catch(\Exception $e) {
			echo $e->getmessage();
        }
        
        return $response->withRedirect($this->router->pathFor('home'));
    }
    else 
    {
        return $response->withRedirect($this->router->pathFor('addPhoto', ['id' => $args['id']]));
    }
})->add(new Validation($validateAddPhoto));

$app->get('/connexion', function ($request, $response, $args) {
    if(isset($_SESSION['pseudo']))
        return $response->withRedirect($this->router->pathFor('home'), 301);
    return $this->view->render($response, 'connexion.html.twig', []);
})->setName('connexion');

$app->get('/register', function ($request, $response, $args) {
    if(isset($_SESSION['pseudo']))
        return $response->withRedirect($this->router->pathFor('home'), 301);
    return $this->view->render($response, 'register.html.twig', []);
})->setName('register');

$app->get('/deconnexion', function ($request, $response, $args) {
    unset ($_SESSION['pseudo']);
    session_destroy();
    return $response->withRedirect($this->router->pathFor('home'), 301);
})->setName('deconnexion');

/*     Validator     */
$validateConnexion = [
    'pseudo'    => v::notEmpty(),
    'password'    => v::notEmpty()
];

$app->post('/connexion', function ($request, $response, $args) {

    if ($request->getAttribute( 'has_errors' )) {

        $this->flash->addMessage('pseudo', 'Please fill in your credentials.');

        return $response->withRedirect($this->router->pathFor('addPhoto', ['id' => $args['id']]));

    }

    $parsedBody = $request->getParsedBody();
    $arr = new \geoquizz\common\models\User();
            
    if(isset($parsedBody['pseudo']) && isset($parsedBody['password']))
    {
        
        try {
            $user = $arr->where('pseudo', '=', $parsedBody['pseudo'])->firstOrFail();
            if(password_verify($parsedBody['password'], $user->password))
            {
                $_SESSION['pseudo'] = $user->pseudo;
                return $response->withRedirect($this->router->pathFor('home'), 301);
            }
            else
            {
                return $response->withRedirect($this->router->pathFor('connexion'), 301);
            }  
        } catch(\Exception $e) {
            $this->flash->addMessage('credentials', 'Your credentials are false.');
            return $response->withRedirect($this->router->pathFor('connexion'), 301);
        }
    }
    else 
    {
        return $response->withRedirect($this->router->pathFor('connexion'), 301);
    }
})->add(new Validation($validateConnexion));

/*     Validator     */
$validateRegister = [
    'pseudo'    => v::StringType()->length(3,30)->notEmpty(),
    'password'    => v::StringType()->length(3,30)->notEmpty(),
    'nom'    => v::StringType()->length(3,30)->notEmpty(),
    'prenom'    => v::StringType()->length(3,30)->notEmpty(),
    'email'    => v::email()->notEmpty()
];

$app->post('/register', function ($request, $response, $args) {
    if ($request->getAttribute( 'has_errors' )) {

        $this->flash->addMessage('pseudo', 'Pseudo needs to be a string 3 to 30 characters long.');
        $this->flash->addMessage('password', 'Password needs to be a string 3 to 30 characters long.');
        $this->flash->addMessage('nom', 'Nom needs to be 3 to 30 characters long.');
        $this->flash->addMessage('prenom', 'Prenom needs to be 3 to 30 characters long.');
        $this->flash->addMessage('email', 'Email needs to be a valid email address.');

        return $response->withRedirect($this->router->pathFor('register'));

    }

    $parsedBody = $request->getParsedBody();
    $user = new \geoquizz\common\models\User();
    $existsPseudo = $user->where('pseudo', '=', $parsedBody['pseudo'])->first();
    $existsMail = $user->where('mail', '=', $parsedBody['email'])->first();
            
    if( isset($parsedBody['pseudo']) && isset($parsedBody['password']) &&
        isset($parsedBody['nom']) && isset($parsedBody['prenom']) && isset($parsedBody['email'])
    )
    {
        if($existsPseudo) {
            $this->flash->addMessage('pseudo', 'The pseudo needs to be unique.');
            return $response->withRedirect($this->router->pathFor('register'));
        } else if ($existsMail) {
            $this->flash->addMessage('email', 'The email needs to be unique.');
            return $response->withRedirect($this->router->pathFor('register'));
        }

        echo password_hash($parsedBody['password'], PASSWORD_DEFAULT);
		$user->pseudo = $parsedBody['pseudo'];
		$user->password = password_hash($parsedBody['password'], PASSWORD_DEFAULT);
		$user->nom = $parsedBody['nom'];
		$user->prenom = $parsedBody['prenom'];
		$user->mail = $parsedBody['email'];
		try {
			$user->save();
		} catch(\Exception $e) {
			echo $e->getmessage();
		}
        
        return $response->withRedirect($this->router->pathFor('connexion'), 301);
    }
    else 
    {
        return $this->view->render($response, 'register.html.twig', []);
    }
})->add(new Validation($validateRegister));

// Run app
$app->run();