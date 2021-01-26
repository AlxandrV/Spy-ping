<?php
use App\Autoloader;
use App\Router\Router;
use App\Router\Request;
use App\Twig\Twig;

require dirname(__FILE__).'/../asset/Autoloader.php';
Autoloader::register();

$router = new Router(new Request);

$router->get('/', function() {
    $twig = new Twig('base.html.twig');
    $twig->render();
    // echo 'ça fonctionne';
});

$router->get('/test', function() {
    echo 'page test';
});
