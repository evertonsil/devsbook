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

    public function follow($atts)
    {
        $user_to = intval($atts['id']);

        //verificando se o id do usuário existe
        if (UserHandler::idExists($user_to)) {
            //veririca se o usuário logado está seguindo o usuário
            if (UserHandler::isFollowing($this->loggedUser->id, $user_to)) {
                UserHandler::unfollow($this->loggedUser->id, $user_to);
            } else {
                UserHandler::follow($this->loggedUser->id, $user_to);
            }
        }

        $this->redirect('/profile/' . $user_to);
    }

    public function friends($atts = [])
    {
        //verifica se existe ID na rota de perfil
        $idUser = $this->loggedUser->id;
        if (!empty($atts['id'])) {
            $idUser = $atts['id'];
        }

        //captura informações do usuário
        $user = UserHandler::getUser($idUser, true);

        //verifica se o usuário retornado existe
        if (!$user) {
            $this->redirect('/404');
        }

        //verificando se usuário logado segue o usuário acessado
        $isFollowing = false;
        if ($user->id != $this->loggedUser->id) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        //renderizando view da página de amigos
        $this->render('profile_friends', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing' => $isFollowing
        ]);
    }

    public function photos($atts = [])
    {
        //verifica se existe ID na rota de perfil
        $idUser = $this->loggedUser->id;
        if (!empty($atts['id'])) {
            $idUser = $atts['id'];
        }

        //captura informações do usuário
        $user = UserHandler::getUser($idUser, true);

        //verifica se usuário exsite
        if (!$user) {
            $this->redirect('/404');
        }

        //verificando se usuário logado segue o usuário acessado
        $isFollowing = false;
        if ($user->id != $this->loggedUser->id) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile_photos', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing' => $isFollowing
        ]);
    }
}
