<?php

// If No Session, Start It
if (!isset($_SESSION)) {
    session_start();
}

// PHP Dev Server
if (PHP_SAPI == 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

// Define Paths
define('WEB_ROOT', __DIR__);
define('APP_ROOT', dirname(__DIR__));

// Bootstrap
require_once APP_ROOT . '/app/app.php';

// Lets do this shit, bruuh!
$app->run();
