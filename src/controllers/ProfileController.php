<?php

namespace src\controllers;

use core\Controller;
use src\handlers\PostHandler;
use src\handlers\UserHandler;

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
            }
            else {
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

    public function settings()
    {
        $user = UserHandler::getUser($this->loggedUser->id);

        $flash = '';

        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }

        $this->render('profile_settings', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'flash' => $flash
        ]);
    }

    public function updateAction()
    {
        $avatar = $_FILES['avatar'] ?? null;
        $cover = $_FILES['cover'] ?? null;

        $username = filter_input(INPUT_POST, 'name');
        $userbirth = filter_input(INPUT_POST, 'birthdate');
        $usermail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $city = filter_input(INPUT_POST, 'city');
        $work = filter_input(INPUT_POST, 'work');
        $userpass = filter_input(INPUT_POST, 'password');
        $userpassConfirm = filter_input(INPUT_POST, 'confirm-password');

        $today = date("Y-m-d");

        //verificando os dados obrigatórios
        if ($username && $usermail) {
            //validando data de nascimento
            if (!validateDate($userbirth)) {
                $_SESSION['flash'] = "Data de nascimento inválida.";
                $this->redirect('/settings');
            }

            //validando senhas, caso houver
            if (!empty($userpass) && !empty($userpassConfirm)) {
                if ($userpass != $userpassConfirm) {
                    $_SESSION['flash'] = "As senhas não conferem.";
                    $this->redirect('/settings');
                }
                //realizando update dos dados com a senha
                UserHandler::updateUser($this->loggedUser->id, $username, $usermail, $userbirth, $city, $work, $userpass);
                $this->redirect('/profile/' . $this->loggedUser->id);
            }

            //realizando update dos dados
            UserHandler::updateUser($this->loggedUser->id, $username, $usermail, $userbirth, $city, $work);
            $this->redirect('/profile/' . $this->loggedUser->id);
        }
        else {
            $_SESSION['flash'] = 'Por favor preencha os campos obrigatórios.';
            $this->redirect('/settings');
        }
    }
}

function validateDate($date)
{
    $parts = explode('-', $date);
    if (count($parts) !== 3) return false;

    list($year, $month, $day) = $parts;

    // Verifica se a data é válida
    if (!checkdate($month, $day, $year)) {
        return false;
    }

    // Converte a data para um timestamp e compara com a data atual
    $birthdate = strtotime($date);
    $today = strtotime(date('Y-m-d'));

    return $birthdate <= $today;
}
