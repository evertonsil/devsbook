<?php

//classe para verificação de login

namespace src\handlers;

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

    //verifica se usuário existe
    public static function idExists($id)
    {
        $user = User::select()->where('id', $id)->one();
        return $user ? true : false;
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
            //montando um novo objeto usuário com os dados recuperados
            $user = new User();
            $user->id = $data['id'];
            $user->name = $data['name'];
            $user->email = $data['email'];
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
                $user->photos = PostHandler::getUserPhotos($id);
            }

            return $user;
        }

        return false;
    }

    public static function isFollowing($from, $to)
    {
        $follow = UserRelation::select()
            ->where('user_from', $from)
            ->where('user_to', $to)
            ->one();

        //retorna true se houver resultado
        return $follow ? true : false;
    }

    public static function follow($user_from, $user_to)
    {
        UserRelation::insert([
            'user_from' => $user_from,
            'user_to' => $user_to
        ])->execute();
    }

    public static function unfollow($user_from, $user_to)
    {
        UserRelation::delete()
            ->where('user_from', $user_from)
            ->where('user_to', $user_to)
            ->execute();
    }

    public static function searchUser($username)
    {
        $users = [];
        $data = User::select()
            ->where('name', 'like', '%' . $username . '%')
            ->get();

        if ($data) {
            foreach ($data as $user) {
                $newUser = new User();
                $newUser->id = $user['id'];
                $newUser->name = $user['name'];
                $newUser->avatar = $user['avatar'];

                $users[] = $newUser;
            }
        }

        return $users;
    }

    public function updateUser($userId, $name, $email, $birthdate, $city, $work, $password = '')
    {
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_BCRYPT);

            User::update()
                ->where('id', $userId)
                ->set([
                    'name' => $name,
                    'email' => $email,
                    'birthdate' => $birthdate,
                    'city' => $city,
                    'work' => $work,
                    'password' => $hash
                ])
                ->execute();
        }
        else {
            User::update()
                ->where('id', $userId)
                ->set([
                    'name' => $name,
                    'email' => $email,
                    'birthdate' => $birthdate,
                    'city' => $city,
                    'work' => $work,
                ])
                ->execute();
        }
    }
}
