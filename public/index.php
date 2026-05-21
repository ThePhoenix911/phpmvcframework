<?php

require_once __DIR__ .'/../vendor/autoload.php';

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;

// dirname(__DIR__) returns the root directory path
// The idea is to pass the root path into the application so that we can move relative to that path
// Which is better compared to moving in relative to the current directory
// This removes the back and forth transitioning and makes it easy to move from top folder down to the bottom file/folder


$app = new Application(dirname(__DIR__));

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/contact',[SiteController::class, 'contact']);

$app->router->post('/contact', [SiteController::class, 'handleContact']);

$app->router->get('/login', [AuthController::class, 'login']);

$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/register', [AuthController::class, 'register']);

$app->router->post('/register', [AuthController::class, 'register']);





$app->run();