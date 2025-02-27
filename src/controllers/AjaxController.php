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

}