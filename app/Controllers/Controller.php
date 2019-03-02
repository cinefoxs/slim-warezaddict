<?php

// Namespace
namespace App\Controllers;

// Use Libs
use \Psr\Container\ContainerInterface;

/**
 * Controller Class
 *
 * @package App\Controllers
 *
*/
class Controller
{

    /**
     * @var
     */
    protected $container;
    protected $log;

    /**
     * Controller constructor.
     *
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        // Slim Container
        $this->container = $container;

        // Analytics Log Message
        $logData = \WarezAddict\Info::userInfo();
        $this->logger->info('ANALYTICS', $logData);

        // Check If User Logged In
        if ($this->auth->check()) {
            // Get Username
            $username = $this->auth->user();

            // Log It
            if ($username) {
                $this->logger->info('AUTH', ['User' => $username]);
            }

            // Update Last Seen Time
            $this->auth->updateLoginTime();
        }
    }

    /**
     * @param $property
     *
     * @return mixed
     *
     */
    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
    }
}
