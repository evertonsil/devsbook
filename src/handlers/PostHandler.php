<?php

//classe para verificação de login

namespace src\handlers;

use src\models\Post;
use src\models\PostLike;
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

    public static function getHomeFeed($idUser, $page)
    {
        //variável para setar a quantidade de posts por página
        $perPage = 5;

        //retornando lista de amigos do usuário logado
        $userList = UserRelation::select()->where('user_from', $idUser)->get();
        $users = [];
        foreach ($userList as $user) {
            $users[] = $user['user_to'];
        }
        //adicionando o próprio usuário logado a lista
        $users[] = $idUser;

        //chamando os posts dos amigos ordenados por data e páginados
        $postList = Post::select()
            ->whereIn('id_user', $users)
            ->orderBy('created_at', 'desc')
            ->page($page, $perPage)
            ->get();

        //chamando a quantidade total de posts
        $postTotal = Post::select()
            ->whereIn('id_user', $users)
            ->count();

        //capturando a quantidade de páginas necessárias
        $qtdPages = ceil($postTotal / $perPage);

        //chamando função para convertos a lista de postagens em objeto
        $posts = self::_postListToObject($postList, $idUser);

        return [
            'posts' => $posts,
            'qtdPages' => $qtdPages,
            'currentPage' => $page
        ];
    }

    public static function _postListToObject($postList, $loggedUser)
    {
        //convertendo lista de posts em objetos
        $posts = [];
        foreach ($postList as $post) {
            $newPost = new Post();
            $newPost->id = $post['id'];
            $newPost->type = $post['type'];
            $newPost->created_at = $post['created_at'];
            $newPost->body = $post['body'];
            $newPost->isOwner = false;

            //verificando se usuário logado é titular do post
            if ($post['id_user'] == $loggedUser) {
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
            $postLikes = PostLike::select()->where('post_id', $post['id'])->get();

            $newPost->likesCount = count($postLikes);
            $newPost->liked = self::isLiked($post['id'], $loggedUser);
            $newPost->comments = [];

            //atribui todas as informações dos posts em um array
            $posts[] = $newPost;
        }

        return $posts;
    }

    public static function isLiked($postID, $loggedUserID): bool
    {
        $liked = PostLike::select()
            ->where('post_id', $postID)
            ->where('user_id', $loggedUserID)
            ->get();
        if (count($liked) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function deleteLike($postID, $loggedUserID)
    {
        PostLike::delete()
            ->where('post_id', $postID)
            ->where('user_id', $loggedUserID)
            ->execute();
    }

    public static function insertLike($postID, $loggedUserID)
    {
        PostLike::insert([
            'post_id' => $postID,
            'user_id' => $loggedUserID
        ])->execute();
    }

    public static function getUserFeed($userID, $page, $loggedUser)
    {
        //chamando os posts do próprio usuário
        $perPage = 5;
        $userPosts = Post::select()
            ->where('id_user', $userID)
            ->orderBy('created_at', 'desc')
            ->page($page, $perPage)
            ->get();

        //chamando a quantidade total de posts do usuário
        $totalPosts = Post::select()
            ->where('id_user', $userID)
            ->count();
        $pageCount = ceil($totalPosts / $perPage);

        //chamando função para convertos a lista de postagens em objeto
        $posts = self::_postListToObject($userPosts, $loggedUser);

        return [
            'posts' => $posts,
            'qtdPages' => $pageCount,
            'currentPage' => $page
        ];
    }

    public static function getUserPhotos($userID)
    {
        $photosData = Post::select()
            ->where('id_user', $userID)
            ->where('type', 'photo')
            ->get();

        $photos = [];

        //criando um novo objeto post e adicionando as informações das fotos do usuário
        foreach ($photosData as $photo) {
            $newPost = new Post();
            $newPost->id = $photo['id'];
            $newPost->type = $photo['type'];
            $newPost->created_at = $photo['created_at'];
            $newPost->body = $photo['body'];

            $photos[] = $newPost;
        }

        return $photos;
    }
}
