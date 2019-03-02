<?php

use \App\Middleware\GuestMiddleware;
use \App\Middleware\AuthMiddleware;
use \App\Middleware\AdminMiddleware;

// Main
$app->get('/', 'HomeController:index')->setName('home');

$app->group('', function () {
    // Read More - Detailed Info
    $this->get('/movie/{name}', 'MovieController:readMore')->setName('readMore');
    // Search
    $this->get('/search', 'SearchController:index')->setName('search');
    $this->post('/search', 'SearchController:index')->setName('search.post');
    // Auth
    $this->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
    $this->post('/auth/signup', 'AuthController:postSignUp');
    $this->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/auth/signin', 'AuthController:postSignIn');
})->add(new GuestMiddleware($container));

$app->group('', function () {
    // Logout
    $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');
    // Change Password
    $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', 'PasswordController:postChangePassword');
})->add(new AuthMiddleware($container));

// Admin Auth
$app->get('/admin', 'AuthController:getAdminSignIn')->setName('admin.signin');
$app->post('/admin', 'AuthController:postAdminSignIn');

$app->group('', function () {
    // Admin Dashboard
    $this->get('/admin/dash', 'AuthController:getAdminDashboard')->setName('admin.dash');
})->add(new AdminMiddleware($container));
