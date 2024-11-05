<?php

namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;
use src\handlers\PostHandler;

class HomeController extends Controller
{
    private $loggedUser;

    public function __construct()
    {
        //se existir usuário logado, atribui a variável
        $this->loggedUser = LoginHandler::isLogged();
        //verificando se o usuário está logado e é válido no método construtor
        if (LoginHandler::isLogged() === false) {
            $this->redirect('/login');
        }
    }

    public function index()
    {
        $feed = PostHandler::getHomeFeed($this->loggedUser->id);

        $this->render('home', [
            'loggedUser' => $this->loggedUser,
            'feed' => $feed
        ]);
    }
}
