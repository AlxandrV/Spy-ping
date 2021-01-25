<?php
require dirname(__FILE__).'/../asset/router/Router.php';
require dirname(__FILE__).'/../asset/router/Request.php';

$router = new Router(new Request);

$router->get('/', function() {
    echo 'ça fonctionne';
});

$router->get('/test', function() {
    echo 'page test';
});
