<?php

namespace app\core;


class Application
{

    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;

    public Response $response;

    public Database $db;
    public static Application $app;

    public Controller $controller;
    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);
    }

    // Whatever the user wants, we listen to them and send them a response
    // The response could be what they requested or a rejection letter
    public function run()
    {
        echo $this->router->resolve();
    }

    public function getController(): Controller
    {
        return $this->controller;
    }

    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }
}