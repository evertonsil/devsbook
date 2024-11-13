<?php

namespace src\models;

use \core\Model;

class User extends Model
{
    public $id;
    public $name;
    public $email;
    public $avatar;
    public $birthdate;
    public $city;
    public $work;
    public $cover;
    public $followers;
    public $following;
    public $photos;
}
