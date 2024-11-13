<?php

//classe para verificação de login

namespace src\handlers;

use Exception;
use src\models\User;
use src\models\UserRelation;

class UserHandler
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
            'avatar' => 'avatar.jpg',
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
            if (password_verify($userpass, $user['password'])) {
                //gera o token, grava no banco e retorna
                $token = bin2hex(random_bytes(16));

                User::update()
                    ->set('token', $token)
                    ->where('id', $user['id'])
                    ->execute();

                return $token;
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
                $loggedUser->avatar = $data['avatar'];

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

    //puxa dados do usuário único
    public static function getUser($id, $fullData = false)
    {
        $data = User::select()
            ->where('id', $id)
            ->one();

        if ($data) {
            //montando um novo objeto usuário com o dados recuperados
            $user = new User();
            $user->id = $data['id'];
            $user->name = $data['name'];
            $user->birthdate = $data['birthdate'];
            $user->city = $data['city'];
            $user->work = $data['work'];
            $user->avatar = $data['avatar'];
            $user->cover = $data['cover'];

            if ($fullData) {
                //setando os arrays para receber os dados relacionados ao usuário
                $user->followers = [];
                $user->following = [];
                $user->photos = [];

                //puxando seguidores do usuário (ID)
                $followers = UserRelation::select()
                    ->where('user_to', $id)
                    ->get();
                var_dump($followers);

                //armazenando os dados de cada seguidor do usuário
                foreach ($followers as $follower) {
                    $userData = User::select()
                        ->where('id', $follower['user_from'])
                        ->one();
                    $newUser = new User();
                    $newUser->id = $userData['id'];
                    $newUser->name = $userData['name'];
                    $newUser->avatar = $userData['avatar'];

                    //adicionado cada seguidores ao array
                    $user->followers[] = $newUser;
                }

                //puxando amigos que o usuário está seguindo (ID)
                $following = UserRelation::select()
                    ->where('user_from', $id)
                    ->get();

                //armazenando os dados de cada amigo que o usuário está seguindo
                foreach ($following as $friend) {
                    $userData = User::select()
                        ->where('id', $friend['user_to'])
                        ->one();

                    $newUser = new User();
                    $newUser->id = $userData['id'];
                    $newUser->name = $userData['name'];
                    $newUser->avatar = $userData['avatar'];

                    //adicionando os amigos do usuário ao array
                    $user->following[] = $newUser;
                }
                //puxando fotos do usuário
            }

            return $user;
        }

        return false;
    }
}
