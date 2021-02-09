<?php
session_start();

use App\Autoloader;
use App\Router\Router;
use App\Router\Request;
use App\Twig\Twig;
use App\User\User;
use App\User\UserManager;
use App\Extraction\Extraction;
use App\Extraction\ExtractionManager;

require dirname(__FILE__).'/../asset/Autoloader.php';
Autoloader::register();

$router = new Router(new Request);

// Default path
$router->get('/', function() {
    $session = (isset($_SESSION['user']) && $_SESSION['user'] === true) ? true : false;
    $id = (isset($_SESSION['id'])) ? $_SESSION['id'] : false;

    if($session === true && $id !== false){ header('Location: /data'); }

    $twig = new Twig('base.html.twig');
    $twig->render([
        'session' => $session,
    ]);
});

// Scrapping user path
$router->get('/data', function() {
    $session = (isset($_SESSION['user']) && $_SESSION['user'] === true) ? true : false;
    $id = (isset($_SESSION['id'])) ? $_SESSION['id'] : false;

    if($session === true && $id !== false) {
        $twig = new Twig('base.html.twig');
        $twig->render([
            'session' => $session,
            'id' => $id
        ]); 
    }else{
        header('Location: /');
    }
});

$router->post('/test', function() {
    $user = new User($_POST);
});

// Add new user
$router->post('/add-user', function() {
    $user = new User($_POST);
    unset($_POST);

    $exist = UserManager::existUser($user);
    if($exist === false) {
        UserManager::addUser($user);
    }
    return json_encode($exist);
});

// Connexion user account
$router->post('/connexion-account', function() {
    $user = new User($_POST);

    $exist = UserManager::existUser($user);
    $validate = ($exist === true) ? true : false;
    if($exist === true) {
        UserManager::connexionUser($user);
    }
    return json_encode($validate);
});

// Session destroy
$router->get('/destroy', function() {
    session_destroy();
    header("Location: /");
});