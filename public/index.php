<?php

require_once __DIR__ .'/../vendor/autoload.php';

use app\controllers\SiteController;
use app\core\Application;

// dirname(__DIR__) returns the root directory path
// The idea is to pass the root path into the application so that we can move relative to that path
// Which is better compared to moving in relative to the current directory
// This removes the back and forth transitioning and makes it easy to move from top folder down to the bottom file/folder


$app = new Application(dirname(__DIR__));

$app->router->get(
    '/', 'home'
);

$app->router->get(
    '/contact','contact'
);

$app->router->post(
    '/contact', [SiteController::class, 'handleContact']
);


$app->run();