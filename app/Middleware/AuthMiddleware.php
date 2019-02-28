<?php

namespace App\Middleware;

use \App\Middleware\Middleware;

/**
 * AuthMiddleware Class
 *
 * @package App\Middleware
 *
 */
class AuthMiddleware extends \App\Middleware\Middleware
{

    public function __invoke($request, $response, $next)
    {
        if (!$this->container->auth->check()) {
            $this->container->flash->addMessageNow('error', 'Error! Please Login Or Register!');

            return $response->withRedirect($this->container->router->pathFor('auth.signin'));
        }

        $response = $next($request, $response);

        return $response;
    }
}
