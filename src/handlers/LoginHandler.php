<?php

//classe para verificação de login

namespace src\handlers;

use src\models\User;

class LoginHandler
{
    public static function isLogged()
    {
        if (!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];

            //verifica se o token do usuário é valido
            $data = User::select()
                ->where('token', $token)
                ->one();

            if (count($data) > 0) {

                $loggedUser = new User();
                $loggedUser->id = $data['id'];
                $loggedUser->name = $data['name'];
                $loggedUser->email = $data['email'];

                return $loggedUser;
            }
        }
        return false;
    }
}
