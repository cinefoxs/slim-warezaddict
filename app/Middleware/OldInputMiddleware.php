<?php

namespace App\Middleware;

use \App\Middleware\Middleware;

/**
 * OldInputMiddleware Class
 *
 * @package App\Middleware
 *
 */
class OldInputMiddleware extends \App\Middleware\Middleware
{

    public function __invoke($request, $response, $next)
    {
        $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
        $_SESSION['old'] = $request->getParams();

        $response = $next($request, $response);
        return $response;
    }
}
