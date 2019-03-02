<?php

// Namespace
namespace App\Controllers\Auth;

// Use Libs
use \App\Controllers\Controller;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \App\Models\User;
use \Respect\Validation\Validator as v;
use \Carbon\Carbon;

class AuthController extends \App\Controllers\Controller
{

    public function getAdminSignIn(Request $request, Response $response)
    {
        if ($this->auth->checkAdmin()) {
            return $this->view->render($response, 'admin/dashboard.twig', array('users' => $this->auth->allUsers()));
        };
        return $this->view->render($response, 'auth/adminsignin.twig');
    }

    public function postAdminSignIn(Request $request, Response $response)
    {
        $authAdmin = $this->auth->verifyAdmin($request->getParam('email'), $request->getParam('password'));

        $logData = [
            'email' => $request->getParam('email'),
            'password' => $request->getParam('password'),
        ];

        if (!isset($authAdmin)) {
            $this->logger->info('AUTH', ['ERROR' => 'Failed Admin Login']);
            $this->flash->addMessageNow('info', 'Error! Try again later...');
            return $response->withRedirect($this->router->pathFor('home'));
        };

        $this->logger->info('ADMIN LOGIN', $logData);

        return $response->withRedirect($this->router->pathFor('admin.dash'));
    }

    public function getAdminDashboard(Request $request, Response $response, array $args)
    {
        if ($this->auth->checkAdmin()) {

            $logpath = '/GITHUB/slim-warezaddict/logs/';
            $file = 'WarezAddict_' . date('m-d-Y') . '.log';
            $path = $logpath . $file;
            $logData = file($path);
            return $this->view->render($response, 'admin/dashboard.twig', [
                'users' => $this->auth->allUsers(),
                'logData' => $logData,
            ]);
        } else {
            return $response->withRedirect($this->router->pathFor('admin.signin'));
        }
    }

    public function getSignOut(Request $request, Response $response)
    {
        $this->flash->addMessageNow('info', 'You are logged out!');
        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor('home'));
    }

    public function getSignIn(Request $request, Response $response, array $args)
    {
        $this->flash->addMessageNow('info', 'Please login or register an account!');
        return $this->view->render($response, 'auth/signin.twig');
    }

    public function postSignIn(Request $request, Response $response, array $args)
    {
        $auth = $this->auth->attempt($request->getParam('email'), $request->getParam('password'));

        $logData = [
          'email' => $request->getParam('email'),
          'password' => $request->getParam('password'),
        ];

        if (!isset($auth)) {
            $this->logger->info('AUTH', ['ERROR' => 'Failed Login']);
            $this->flash->addMessageNow('info', 'Error! Try again later...');
            return $response->withRedirect($this->router->pathFor('home'));
        } else {
            $this->logger->info('AUTH', $logData);
            $this->flash->addMessageNow('info', 'Welcome back! You are logged in...');
            return $response->withRedirect($this->router->pathFor('auth.password.change'));
        }
    }

    public function getSignUp(Request $request, Response $response)
    {
        return $this->view->render($response, 'auth/signup.twig');
    }

    public function postSignUp(Request $request, Response $response)
    {
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->EmailAvailable(),
            'name' => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->flash->addMessageNow('error', 'Error! Try again...');
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        $user = User::create([
            'name' => $request->getParam('name'),
            'email' => $request->getParam('email'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT, ['cost' => 10]),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'is_admin' => 0,
            'avatar_url' => '/images/default_avatar.jpg',
        ]);

        $logData = [
            'name' => $request->getParam('name'),
            'email' => $request->getParam('email'),
        ];
        $this->logger->info('AUTH', $logData);

        $this->flash->addMessageNow('info', 'Success! You have been signed up!');

        $this->auth->attempt($user->email, $request->getParam('password'));
        return $response->withRedirect($this->router->pathFor('home'));
    }
}
