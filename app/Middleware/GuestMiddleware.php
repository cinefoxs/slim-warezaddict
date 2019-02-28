<?php

namespace App\Middleware;

use \App\Middleware\Middleware;

/**
 * GuestMiddleware Class
 *
 * @package App\Middleware
 *
 */
class GuestMiddleware extends \App\Middleware\Middleware
{

    public function __invoke($request, $response, $next)
    {
        if ($this->container->auth->check()) {
            return $response->withRedirect($this->container->router->pathFor('home'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
