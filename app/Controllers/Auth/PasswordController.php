<?php

namespace App\Controllers\Auth;

use \App\Controllers\Controller;
use \App\Models\User;
use \Respect\Validation\Validator as v;

class PasswordController extends \App\Controllers\Controller
{

    public function getChangePassword($request, $response)
    {
        return $this->view->render($response, 'auth/change.twig');
    }

    public function postChangePassword($request, $response)
    {
        $validation = $this->validator->validate($request, [
            'password_old' => v::noWhitespace()->notEmpty()->matchesPassword($this->auth->user()->password),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->flash->addMessageNow('error', 'Error! Something went wrong!');
            return $response->withRedirect($this->router->pathFor('auth.password.change'));
        }

        $this->auth->user()->setPassword($request->getParam('password'));

        $this->flash->addMessageNow('info', 'Your password was sucessfully changed!');
        return $response->withRedirect($this->router->pathFor('home'));
    }
}
