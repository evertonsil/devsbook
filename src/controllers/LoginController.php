<?php

namespace src\controllers;

use \core\Controller;
use src\handlers\UserHandler;

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
        //atribuindo o valor da sessão na variável, para que seja exibida apenas uma vez
        $flash = '';
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $this->render('register', [
            'flash' => $flash
        ]);
    }

    //rota para login de usuário
    public function signinAction()
    {
        $usermail = filter_input(INPUT_POST, 'email',  FILTER_VALIDATE_EMAIL);
        $userpass = filter_input(INPUT_POST, 'password');

        if ($usermail && $userpass) {

            //validando login no handler
            $token = UserHandler::verifyLogin($usermail, $userpass);
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
        $username = filter_input(INPUT_POST, 'name');
        $usermail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $userpass = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_DEFAULT);
        $userbirth = filter_input(INPUT_POST, 'birthdate');

        if ($username && $usermail  && $userpass && $userbirth) {
            //verifica se o usuário já existe
            $user = UserHandler::isRegistered($usermail);

            if (!$user) {
                //validando a data (ela vem como yyyy-mm-dd)
                if (strtotime($userbirth)) {
                    //se a data for válida, cadastra o usuário e já envia o token retornado pelo método, fazendo o login automaticamente
                    $token = UserHandler::registerUser($username, $usermail, $userpass, $userbirth);
                    $_SESSION['token'] = $token;
                    $this->redirect('/');
                } else {
                    $_SESSION['flash'] = 'Data de nascimento inválida';
                    $this->redirect('/cadastro');
                }
            } else {
                $_SESSION['flash'] = 'O e-mail informado já está cadastrado';
                $this->redirect('/cadastro');
            }
        } else {
            $_SESSION['flash'] = 'Por favor preencha todos os campos corretamente.';
            $this->redirect('/cadastro');
        }
    }
}
