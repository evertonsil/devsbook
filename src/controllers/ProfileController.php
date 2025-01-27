<?php

namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use src\handlers\PostHandler;

class ProfileController extends Controller
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
        //capturando a página atual pela query string
        $page = intval(filter_input(INPUT_GET, 'page'));

        //por padrão, atribui o ID do usuário logado
        $idUser = $this->loggedUser->id;

        //verifica se existe ID na rota de perfil
        if (!empty($atts['id'])) {
            $idUser = $atts['id'];
        }

        //chamando as informações do usuário
        $user = UserHandler::getUser($idUser, true);

        //verifica se o usuário retornado existe
        if (!$user) {
            $this->redirect('/404');
        }

        //chamando o feed do usuário
        $feed = PostHandler::getUserFeed(
            $idUser,
            $page,
            $this->loggedUser->id
        );

        //verificando se usuário logado segue o usuário acessado
        $isFollowing = false;
        if ($user->id != $this->loggedUser->id) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'feed' => $feed,
            'isFollowing' => $isFollowing
        ]);
    }
}
