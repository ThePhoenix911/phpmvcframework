<?php

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;

require_once __DIR__ .'/../vendor/autoload.php';

// We use the following command to load the env file using some phpdotenv package
// we passed the dirname(), we want the search to occur from the top directory
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// dirname(__DIR__) returns the root directory path
// The idea is to pass the root path into the application so that we can move relative to that path
// Which is better compared to moving in relative to the current directory
// This removes the back and forth transitioning and makes it easy to move from top folder down to the bottom file/folder

$config = [
    'db' => [
       'dsn' => $_ENV['DB_DSN'],
       'user' => $_ENV['DB_USER'],
       'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/contact',[SiteController::class, 'contact']);

$app->router->post('/contact', [SiteController::class, 'handleContact']);

$app->router->get('/login', [AuthController::class, 'login']);

$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/register', [AuthController::class, 'register']);

$app->router->post('/register', [AuthController::class, 'register']);





$app->run();