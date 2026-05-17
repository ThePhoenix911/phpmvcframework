<?php

namespace app\core;

// This is a class that we use to strip down the information that comes with the request
// Determining the type of request
// Where it's heading and why

// Think of this class as an informant that you paid to snitch on his buddy
// Instead of following him around
class Request
{
       public function getPath()
       {
           // Returns the url with parameters
           $path = $_SERVER['REQUEST_URI'] ?? '/';

           // Verify if the url has parameters
           $position = strpos($path, '?');

           if($position === false) {
               return $path;
           }

           return substr($path, 0, $position);

           echo '<pre>';
           var_dump($position);
           echo '</pre>';
           exit;
       }

       public function getMethod()
       {
            return strtolower($_SERVER['REQUEST_METHOD']);
       }
}