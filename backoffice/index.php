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
        'cache' => false
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));
    return $view;
};
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
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
$app->post('/connexion', function ($request, $response, $args) {
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
            return $response->withRedirect($this->router->pathFor('connexion'), 301);
        }
    }
    else 
    {
        return $response->withRedirect($this->router->pathFor('connexion'), 301);
    }
});
$app->post('/register', function ($request, $response, $args) {
    $parsedBody = $request->getParsedBody();
    $user = new \geoquizz\common\models\User();
    $existsPseudo = $user->where('pseudo', '=', $parsedBody['pseudo'])->first();
    $existsMail = $user->where('mail', '=', $parsedBody['email'])->first();
            
    if( isset($parsedBody['pseudo']) && isset($parsedBody['password']) &&
        isset($parsedBody['nom']) && isset($parsedBody['prenom']) && isset($parsedBody['email']) &&
        !$existsPseudo && !$existsMail
    )
    {
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
});

// Run app
$app->run();