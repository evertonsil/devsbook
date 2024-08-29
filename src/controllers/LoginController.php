<?php

namespace src\controllers;

use \core\Controller;

class LoginController extends Controller
{
    //rota para página de login
    public function signin()
    {
        $this->render('login');
    }

    //rota para página de cadastro
    public function signup()
    {
        $this->render('register');
    }

    //rota para login de usuário
    public function signinUser() {}

    //rota para cadastro de novo usuário
    public function signupUser() {}
}
