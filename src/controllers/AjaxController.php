<?php

namespace src\controllers;

use core\Controller;
use src\handlers\PostHandler;
use src\handlers\UserHandler;

class AjaxController extends Controller
{
    private $loggedUser;

    public function __construct()
    {
        $this->loggedUser = UserHandler::isLogged();
        if ($this->loggedUser === false) {
            header("Content-Type: application/json");
            echo json_encode(['error' => "User not logged"]);
            exit();
        }
    }

    public function like($atts)
    {
        $id = $atts['id'];
        if (PostHandler::isLiked($id, $this->loggedUser->id)) {
            PostHandler::deleteLike($id, $this->loggedUser->id);
        }
        else {
            PostHandler::insertLike($id, $this->loggedUser->id);
        }
    }

    public function comment($atts)
    {
        $response = ['error' => ''];

        $id = filter_input(INPUT_POST, 'id');
        $body = filter_input(INPUT_POST, 'txt');

        if ($id && $body) {
            PostHandler::insertComment($id, $body, $this->loggedUser->id);

            //preenchendo array para o js construir a div de comentários
            $response['link'] = '/perfil/' . $this->loggedUser->id;
            $response['avatar'] = '/media/avatars/' . $this->loggedUser->avatar;
            $response['name'] = $this->loggedUser->name;
            $response['body'] = $body;
        }

        header("Content-Type: application/json");
        echo json_encode($response);
        exit();
    }

}