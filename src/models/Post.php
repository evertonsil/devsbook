<?php

namespace src\models;

use \core\Model;

class Post extends Model
{
    public $id;
    public $type;
    public $created_at;
    public $body;
    public $user;
    public $isOwner;
    public $likesCount;
    public $comments;
    public $liked;
}
