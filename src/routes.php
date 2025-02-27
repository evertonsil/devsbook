<?php

use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/login', 'LoginController@signin');

$router->get('/cadastro', 'LoginController@signup');

$router->get('/logout', 'LoginController@signout');

$router->get('/profile/{id}/photos', 'ProfileController@photos');
$router->get('/profile/{id}/friends', 'ProfileController@friends');
$router->get('/profile/{id}/follow', 'ProfileController@follow');
$router->get('/profile/{id}', 'ProfileController@index');
$router->get('/profile', 'ProfileController@index');

$router->get('/friends', 'ProfileController@friends');

$router->get('/photos', 'ProfileController@photos');

$router->get('/search', 'SearchController@index');

$router->get('/settings', 'ProfileController@settings');

$router->get('/ajax/like/{id}', 'AjaxController@like');

$router->post('/ajax/comment', 'AjaxController@comment');

$router->post('/login', 'LoginController@signinAction');

$router->post('/register', 'LoginController@signupAction');

$router->post('/update', 'ProfileController@updateAction');

$router->post('/post/new', 'PostController@new');

//$router->get('search');
//$router->get('profile');
// $router->get('friends');
// $router->get('photos');
// $router->get('settings');
