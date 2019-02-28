<?php

namespace App\Middleware;

use \App\Middleware\Middleware;

class ValidationErrorsMiddleware extends \App\Middleware\Middleware
{

    public function __invoke($request, $response, $next)
    {

        $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);

        if ($_SESSION['errors']) {
            $this->logger->info('ERRORS!', $_SESSION['errors']);
        }

        unset($_SESSION['errors']);

        $response = $next($request, $response);
        return $response;
    }
}
