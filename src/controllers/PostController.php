<?php

namespace src\controllers;

use \core\Controller;

class PostController extends Controller
{

    public function new()
    {
        $data = filter_input(INPUT_POST,  'feed-new-data', FILTER_SANITIZE_STRING);
        echo $data;
    }
}
