<?php

namespace App\Middleware;

use \App\Middleware\Middleware;

class AdminMiddleware extends \App\Middleware\Middleware
{

    public function __invoke($request, $response, $next)
    {

        if (!$this->container->auth->checkAdmin()) {
            $this->container->flash->addMessageNow('error', 'Error! Something fucked up!');

            return $response->withRedirect($this->container->router->pathFor('admin.signin'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
