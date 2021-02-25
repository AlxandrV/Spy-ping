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
use App\Scraper\Scraper;

require dirname(__FILE__).'/../vendor/autoload.php';
require dirname(__FILE__).'/../asset/Autoloader.php';
Autoloader::register();

$router = new Router(new Request);

// Path GET ___________________________________________________________________________________
// Default path
$router->get('/', function() {
    $session = (isset($_SESSION['user']) && $_SESSION['user'] === true) ? true : false;
    $id = (isset($_SESSION['id'])) ? $_SESSION['id'] : false;

    // Redirect if session active
    if($session === true && $id !== false){ header('Location: /data'); }

    $twig = new Twig('base.html.twig');
    $twig->render([
        'session' => $session,
    ]);
});

// Scrapping user data
$router->get('/data', function() {
    $session = (isset($_SESSION['user']) && $_SESSION['user'] === true) ? true : false;
    $id = (isset($_SESSION['id'])) ? $_SESSION['id'] : false;

    // Load data if session active else redirect to login
    if($session === true && $id !== false) {

        $listExtraction = ExtractionManager::listExtraction($id);

        $twig = new Twig('base.html.twig');
        $twig->render([
            'session' => $session,
            'id' => $id,
            'listExtraction' => $listExtraction
        ]); 
    }else{
        header('Location: /');
    }
});

// Session destroy
$router->get('/destroy', function() {
    session_destroy();
    header("Location: /");
});

// Path POST ___________________________________________________________________________________
// Add new extraction
$router->post('/add-extraction', function() {
    if(isset($_SESSION['id'])) {
        $user = new User(["id" => $_SESSION['id']]);
        $extraction = new Extraction(["url" => $_POST['urlExtract']]);
        ExtractionManager::addExtraction($extraction, $user);
    }
});

// Add new user
$router->post('/add-user', function() {
    $user = new User($_POST);
    unset($_POST);

    //  Verification user exist
    $exist = UserManager::existUser($user);
    if($exist === false) {
        // If user not exist add to db
        UserManager::addUser($user);
    }
    return json_encode($exist);
});

// Connexion user account
$router->post('/connexion-account', function() {
    $user = new User($_POST);

    //  Verification user exist
    $exist = UserManager::existUser($user);
    $validate = ($exist === true) ? true : false;
    if($exist === true) {
        // If user exist verificcation connexion and create session
        UserManager::connexionUser($user);
    }
    return json_encode($validate);
});

// Test part _________________________________________________________________________
$router->get('/test', function() {
    $url = "https://www.google.com/";
    $tag = 'div';
    $scraper = Scraper::crawler($url, $tag);
});
