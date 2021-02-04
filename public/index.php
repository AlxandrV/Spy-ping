<?php
session_start();

use App\Autoloader;
use App\Router\Router;
use App\Router\Request;
use App\Twig\Twig;
use App\Connexion\Connexion;
use App\User\User;
use App\User\UserManager;

require dirname(__FILE__).'/../asset/Autoloader.php';
Autoloader::register();

$router = new Router(new Request);

$router->get('/', function() {
    $session = (isset($_SESSION['user']) && $_SESSION['user'] === true) ? true : false;

    $twig = new Twig('base.html.twig');
    $twig->render([
        'session' => $session
    ]);
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
    }else{
        echo "l'utilisateur existe déjà";
    }
});

// Connexion user account
$router->post('/connexion-account', function() {
    $user = new User($_POST);

    $exist = UserManager::existUser($user);
    if($exist === true) {
        UserManager::connexionUser($user);
    }
    header("Location: /");
    exit;
});