<?php

use todo\controllers\Json;
use todo\Router;

require __DIR__ .  "/Router.php";
require __DIR__ .  "/controllers/Json.php";


$router = new Router();


$router
    ->get('/', function () {
        require "views/index.php";
    })
    ->post('/insert', [Json::class, 'insert'])
    ->post('/delete', [Json::class, 'delete'])
    ->post('/update', [Json::class, 'update']);

$router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']), __DIR__.'/to-do.json');





