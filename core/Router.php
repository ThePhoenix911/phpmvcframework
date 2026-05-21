<?php


namespace app\core;

class Router
{
     public Request $request;
     public Response $response;

     // this stores a set of instructions that we'll execute based on the users request
    // the GET method is when the user wants to see something
    //  the POST method is when the want to store something
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        // Provides us simplified information about the client's request
        $this->request = $request;

        $this->response = $response;
    }

    // Stores instructions about what needs to happen if the user wants to read something from a specific path
    public function get($path, $callback)
    {
        // The callback function has all the instructions of how to provide the required user content
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }


    // Looks at what the user wants and determines appropriate action
    // From adding new furniture, buying extra land, or rejecting the user's ridiculous request
    public function resolve()
    {
        // Where does the user want to go?
        $path = $this->request->getPath();

        // What does he want to do?
        $method = $this->request->method();

        // Since the user want to go to this path and do this, call this function
        $callback = $this->routes[$method][$path] ?? false;

        // If there's no function associated with this path and method, that means the user is drunk
        if($callback === false)
        {
            $this->response->setStatusCode(404);
            return $this->renderView('_404');
        }


        // If it is a string that means we only need to update the content
        // In this instance, it means we need to add new furniture before deploying to the public
        if(is_string($callback))
        {
            // returns an RDP with updated furniture
            return $this->renderView($callback);
        }

        if(is_array($callback))
        {
            // If the callback is an array, it means it's a [ControllerClass, 'methodName']
            // We must convert the string 'SiteController' into a real Object first
            // This allows us to use the $this->render method inside the SiteController class since it has been instantiated
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }

        // If it is not a string that means, no content needs to be updated
        // Analogy: it has nothing to do with replacing old furniture
        // Maybe the user wants to buy a land or something
        /* execute the action and pass the request data to it */
        // call_user_func accepts the 2nd, 3rd, etc. arguments to be passed as the arguments of the $callback function
        // So basically, we are calling the $callback function and passing the '$this->>request' as its argument
        return call_user_func($callback, $this->request);
    }

    // Replaces old furniture with the new furniture
    // Return the report that the RDP is ready to be deployed for use
    public function renderView($view, $params = [])
    {
        // Layout = An RDP
        $layoutContent = $this->layoutContent();

        // View = new furniture for the RDP
        $viewContent = $this->renderOnlyView($view, $params);

        // Go into the RDP house, search for the old furniture and replace with the new one
        // Return the RDP with the new furniture - the RDP's furniture has been updated
        return str_replace('{{content}}', $viewContent, $layoutContent);

    }

    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        // instead of replacing the furniture, we put a notice box in place of the furniture
        // stating that there's no furniture for replacing
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    // Return the RDP but do not release it to the public until we have installed new furniture
    protected function layoutContent()
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    // Add the new furniture but do not show it to the public until it is inside the RDP house, so keep it covered
    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value)
        {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

}