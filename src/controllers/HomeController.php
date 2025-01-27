<?php

namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use src\handlers\PostHandler;

class HomeController extends Controller
{
    private $loggedUser;

    public function __construct()
    {
        //se existir usuário logado, atribui a variável
        $this->loggedUser = UserHandler::isLogged();
        //verificando se o usuário está logado e é válido no método construtor
        if (UserHandler::isLogged() === false) {
            $this->redirect('/login');
        }
    }

    public function index()
    {
        //capturando a página atual da query string
        $page = intval(filter_input(INPUT_GET, 'page'));

        $feed = PostHandler::getHomeFeed(
            $this->loggedUser->id,
            $page
        );

        $this->render('home', [
            'loggedUser' => $this->loggedUser,
            'feed' => $feed
        ]);
    }
}
