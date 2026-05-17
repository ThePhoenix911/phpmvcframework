<?php

namespace app\core;


class Application
{

    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;

    public Response $response;
    public static Application $app;
    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request;
        $this->response = new Response;
        $this->router = new Router($this->request, $this->response);
    }

    // Whatever the user wants, we listen to them and send them a response
    // The response could be what they requested or a rejection letter
    public function run()
    {
        echo $this->router->resolve();
    }
}