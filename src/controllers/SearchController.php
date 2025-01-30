<?php

namespace src\controllers;

use core\Controller;
use src\handlers\UserHandler;

class SearchController extends Controller
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

    public function index($atts = [])
    {
        //capturando termo da pesquisa na query string
        $searchTerm = (filter_input(INPUT_GET, 's'));

        //verifica se o usuário enviou um termo para pesquisa
        if (empty($searchTerm)) {
            $this->redirect('/404');
        }

        //busca de usuário
        $users = UserHandler::searchUser($searchTerm);

        $this->render('search', [
            'loggedUser' => $this->loggedUser,
            'searchTerm' => $searchTerm,
            'users' => $users,
        ]);
    }
}
