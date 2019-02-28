<?php

// Namespace
namespace App\Middleware;

// Use Libs
// use \Example\Test;

/**
 * Middleware
 *
 * @package App\Middleware
 *
 */
class Middleware
{
    /**
     * @var
     *
     */
    protected $container;

    /**
     * Middleware Constructor
     *
     * @param $container
     *
     */
    public function __construct($container)
    {
        // Container
        $this->container = $container;
    }
}
