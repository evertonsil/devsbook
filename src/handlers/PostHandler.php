<?php

//classe para verificação de login

namespace src\handlers;

use Exception;
use src\models\Post;
use src\models\User;
use src\models\UserRelation;

class PostHandler
{

    public static function createPost($idUser, $type, $data)
    {
        $data = trim($data);
        if (!empty($idUser && !empty($data))) {
            Post::insert([
                'id_user' => $idUser,
                'type' => $type,
                'created_at' => date('Y-m-d H:i:s'),
                'body' => $data
            ])->execute();
        }
    }

    public static function getHomeFeed($idUser)
    {
        //retornando lista de amigos do usuário logado
        $userList = UserRelation::select()->where('user_from', $idUser)->get();
        $users = [];
        foreach ($userList as $user) {
            $users[] = $user['user_to'];
        }
        //adicionando o próprio usuário logado a lista
        $users[] = $idUser;

        //chamando os posts dos amigos ordenados por data
        $postList = Post::select()
            ->whereIn('id_user', $users)
            ->orderBy('created_at', 'desc')
            ->get();

        //convertendo lista de posts em objetos
        $posts = [];
        foreach ($postList as $post) {
            $newPost = new  Post();
            $newPost->id = $post['id'];
            $newPost->type = $post['type'];
            $newPost->created_at = $post['created_at'];
            $newPost->body = $post['body'];
            $newPost->isOwner = false;

            //verificando se usuário logado é titular do post
            if ($post['id_user'] == $idUser) {
                $newPost->isOwner = true;
            }

            //chamando as informações do usuário "dono" dos posts
            $newUser = User::select()->where('id', $post['id_user'])->one();
            $newPost->user = new User();

            //atribuindo as informações do "dono" do post ao objeto
            $newPost->user->id = $newUser['id'];
            $newPost->user->name = $newUser['name'];
            $newPost->user->avatar = $newUser['avatar'];
            $newPost->user->email = $newUser['email'];

            //verificnado informações de comentários e likes de cada post
            $newPost->liked = false;
            $newPost->likesCount = 0;
            $newPost->comments = [];

            //atribui todas as informações dos posts em um array
            $posts[] = $newPost;
        }
        return $posts;
    }
}
