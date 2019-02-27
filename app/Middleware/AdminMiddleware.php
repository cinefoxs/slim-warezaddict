<?php

namespace App\Middleware;

class AdminMiddleware extends \App\Middleware\Middleware
{

    public function __invoke($request, $response, $next)
    {

        if (!$this->container->auth->checkAdmin()) {
            $this->container->flash->addMessage('error', 'You are not authorized to be here');
            return $response->withRedirect($this->container->router->pathFor('admin.signin'));
        }
        $response = $next($request, $response);
        return $response;
    }
}
