<?php

namespace src\controllers;

use \core\Controller;
use src\handlers\LoginHandler;

class LoginController extends Controller
{
    //rota para página de login
    public function signin()
    {
        //atribuindo o valor da sessão na variável, para que seja exibida apenas uma vez
        $flash = '';
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('login', [
            'flash' => $flash
        ]);
    }

    //rota para página de cadastro
    public function signup()
    {
        $this->render('register');
    }

    //rota para login de usuário
    public function signinAction()
    {
        $usermail = filter_input(INPUT_POST, 'email',  FILTER_VALIDATE_EMAIL);
        $userpass = filter_input(INPUT_POST, 'password');

        if ($usermail && $userpass) {

            //validando login no handler
            $token = LoginHandler::verifyLogin($usermail, $userpass);

            if ($token) {
                $_SESSION['token'] = $token;
                $this->redirect('/');
            } else {
                $_SESSION['flash'] = 'Email e/ou senha inválidos';
                $this->redirect('/login');
            }
        } else {
            $_SESSION['flash'] = 'Por favor, verifique os dados e tente novamente!';
            $this->redirect('/login');
        }
    }

    //rota para cadastro de novo usuário
    public function signupAction()
    {
        echo 'Cadastrando...';
    }
}
