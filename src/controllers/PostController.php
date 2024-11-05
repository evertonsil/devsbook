<?php

namespace src\controllers;

use \core\Controller;
use src\handlers\LoginHandler;
use src\handlers\PostHandler;

class PostController extends Controller
{

    private $loggedUser;

    public function __construct()
    {
        $this->loggedUser = LoginHandler::isLogged();
        if ($this->loggedUser === false) {
            $this->redirect('/login');
        }
    }

    public function new()
    {
        $data = filter_input(INPUT_POST,  'feed-new-data', FILTER_SANITIZE_STRING);

        if ($data) {
            PostHandler::createPost(
                $this->loggedUser->id,
                'text',
                $data
            );
        }

        $this->redirect('/');
    }
}
