<?php

//classe para verificação de login

namespace src\handlers;

use src\models\User;

class LoginHandler
{

    public static function verifyLogin($usermail, $userpass)
    {
        //verificando se o email existe
        $user = User::select()
            ->where('email', $usermail)
            ->one();
        //validação da senha caso usuário existir
        if ($user) {
            //validando senha
            if (password_verify($user['password'],  $userpass)) {
                //gera o token, grava no banco e retorna
                $token = bin2hex(random_bytes(16));

                $updateToken = User::update()
                    ->set('token', $token)
                    ->where('id', $user['id'])
                    ->execute();

                if ($updateToken) {
                    return $token;
                }
            }
        }
        return false;
    }
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
