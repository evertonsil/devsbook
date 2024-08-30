<?php

//classe para verificação de login

namespace src\handlers;

use Exception;
use src\models\User;

class LoginHandler
{

    //cadastrando novo usuário
    public static function registerUser($username, $usermail, $userpass, $userbirth)
    {
        //gerando um token pra logar após o cadastro
        $token = bin2hex(random_bytes(16));

        User::insert([
            'name' => $username,
            'email' => $usermail,
            'password' => $userpass,
            'birthdate' => $userbirth,
            'avatar' => 'default.jpg',
            'cover' => 'cover.jpg',
            'token' => $token
        ])->execute();

        return $token;
    }

    //fazendo login de usuário existente
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

    //verificando se usuário está logado
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

    //verificando se email está registrado
    public static function isRegistered($usermail)
    {
        $user = User::select()
            ->where('email', $usermail)
            ->one();

        return $user;
    }
}
