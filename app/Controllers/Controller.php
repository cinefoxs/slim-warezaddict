<?php

// Namespace
namespace App\Controllers;

// Use Libs
use \Psr\Container\ContainerInterface;

/**
 * Class Controller
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
        $log = $this->logger;
        $logData = \WarezAddict\Tools\Info::userInfo();
        $log->info('ANALYTICS', $logData);

        // Check If User Logged In
        if ($this->auth->check()) {
            // If True, Update Users "Last Seen" Record
            $this->auth->updatedAt();
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
