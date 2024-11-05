<?php

//classe para verificação de login

namespace src\handlers;

use Exception;
use src\models\Post;

class PostHandler
{

    public static function createPost($idUser, $type, $data)
    {
        $data - trim($data);
        if (!empty($idUser && !empty($data))) {
            Post::insert([
                'id_user' => $idUser,
                'type' => $type,
                'created_at' => date('Y-m-d H:i:s'),
                'body' => $data
            ])->execute();
        }
    }
}
