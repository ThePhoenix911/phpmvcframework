<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller
{
    public function login()
    {
        $this->setlayout('auth');
       return $this->render('login');
    }

    public function register(Request $request)
    {
        $user = new User();

        if($request->isPost())
        {
            $user->loadData($request->getBody());

            if($user->validate() && $user->save())
            {
                // if it succeeded
                Application::$app->session->setFlash('success', 'User registered successfully');
                Application::$app->response->redirect('/');
            }

            // if it failed and there's an error
            return $this->render('register', [
                'model' => $user
            ]);
        }

        $this->setlayout('auth');
        return $this->render('register', [
            'model' => $user
        ]);
    }
}