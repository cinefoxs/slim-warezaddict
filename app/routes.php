<?php

use \App\Middleware\GuestMiddleware;
use \App\Middleware\AuthMiddleware;
use \App\Middleware\AdminMiddleware;

$app->group('', function () {
    // main
    $this->get('/', 'HomeController:index')->setName('home');
    
    // $this->get('/omdb/search', 'MovieController:OmdbMovieSearch')->setName('OmdbMovieSearch');

    // Read More - Detailed Info
    $this->get('/movie/{name}', 'MovieController:readMore')->setName('readMore');

    // Search
    $this->get('/search', 'SearchController:index')->setName('search');
    $this->post('/search', 'SearchController:index')->setName('search.post');

    /** /auth/ signup and signin **/
    $this->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
    $this->post('/auth/signup', 'AuthController:postSignUp');
    $this->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/auth/signin', 'AuthController:postSignIn');
})->add(new GuestMiddleware($container));

$app->group('', function () {
    $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

    $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', 'PasswordController:postChangePassword');
})->add(new AuthMiddleware($container));

$app->get('/admin', 'AuthController:getAdminSignIn')->setName('admin.signin');
$app->post('/admin', 'AuthController:postAdminSignIn');

$app->group('', function () {
    $this->get('/admin/dash', 'AuthController:getAdminDashboard')->setName('admin.dash');
})->add(new AdminMiddleware($container));
