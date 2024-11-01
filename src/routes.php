<?php

use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/login', 'LoginController@signin');
$router->get('/cadastro', 'LoginController@signup');

//$router->get('search');
//$router->get('profile');
//$router->get('logout');
// $router->get('friends');
// $router->get('photos');
// $router->get('settings');

$router->post('/login', 'LoginController@signinAction');
$router->post('/register', 'LoginController@signupAction');
$router->post('/post/new', 'PostController@new');
