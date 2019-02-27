<?php

// Composer Autoload
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Use Libs
use Respect\Validation\Validator as v;

// Set Timezone
date_default_timezone_set('America/New_York');

// Load .env File
$dotenv = \Dotenv\Dotenv::create(APP_ROOT);
$dotenv->load();

// Init Slim Framework With Settings
$app = new \Slim\App([
    'settings' => [
      'debug' => getenv('APP_DEBUG') === "yes" ? true : false,
      'displayErrorDetails' => getenv('APP_DEBUG') === "yes" ? true : false,
      'addContentLengthHeader' => false,
      'determineRouteBeforeAppMiddleware' => true,
      'routerCacheFile' => false,
      'whoops.editor' => 'sublime',
      'whoops.page_title' => 'ERROR!',
    ]
]);

// Get Slim Container
$container = $app->getContainer();

// Database
require_once __DIR__ . '/database.php';

// Cool Kids Errors, If Debug Mode Is Enabled
if (getenv('APP_DEBUG') === "yes") {
    $whoopsGuard = new \Zeuxisoo\Whoops\Provider\Slim\WhoopsGuard();
    $whoopsGuard->setApp($app);
    $whoopsGuard->setRequest($container['request']);
    $whoopsGuard->setHandlers([]);
    $whoopsGuard->install();
}

// Database
$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

// Logger
$container['logger'] = function ($container) {
    $logsPath = APP_ROOT . '/logs/WarezAddict_' . date('m-d-Y') . '.log';
    $logger = new \Monolog\Logger('WarezAddict');
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($logsPath, \Monolog\Logger::DEBUG));
    return $logger;
};

// Flash Messages
$container['flash'] = function () {
    return new \Slim\Flash\Messages;
};

// Auth
$container['auth'] = function () {
    return new \App\Auth\Auth;
};

// View Renderer
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(APP_ROOT . '/views', [
        'debug' => true,
        'cache' => false,
        'auto_reload' => true,
        'autoescape' => false,
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));
    $view->addExtension(new Twig_Extension_Debug());
    $view->addExtension(new Twig_Extensions_Extension_Text());

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user()
    ]);
    $view->addExtension(new \Knlv\Slim\Views\TwigMessages($container->flash));
    $view->getEnvironment()->addGlobal('flash', $container->flash);
    $view->getEnvironment()->addGlobal('baseUrl', $container['request']->getUri()->getBaseUrl());
    $view->getEnvironment()->addGlobal('TmdbImage', 'http://image.tmdb.org/t/p/w300');
    return $view;
};

// The Movie Database API
$container['tmdb'] = function ($container) {
    $tmdbKey = getenv('TMDB_KEY');
    $token = new \Tmdb\ApiToken($tmdbKey);
    $client = new \Tmdb\Client($token, [
        'cache' => [
            'enabled' => true,
            'path' => APP_ROOT . '/cache/',
        ],
        'secure' => false,
    ]);
    $configRepository = new \Tmdb\Repository\ConfigurationRepository($client);
    $config = $configRepository->load();
    $imageHelper = new \Tmdb\Helper\ImageHelper($config);
    $langPlugin = new \Tmdb\HttpClient\Plugin\LanguageFilterPlugin('en-US');
    $adultPlugin = new \Tmdb\HttpClient\Plugin\AdultFilterPlugin(false);
    $client->getHttpClient()->addSubscriber($langPlugin);
    $client->getHttpClient()->addSubscriber($adultPlugin);
    return $client;
};

// Validation
$container['validator'] = function () {
    return new \App\Validation\Validator;
};

// Controllers
$container['AuthController'] = function ($container) {
    return new \App\Controllers\Auth\AuthController($container);
};
$container['PasswordController'] = function ($container) {
    return new \App\Controllers\Auth\PasswordController($container);
};
$container['HomeController'] = function ($container) {
    return new \App\Controllers\HomeController($container);
};
$container['SearchController'] = function ($container) {
    return new \App\Controllers\SearchController($container);
};
$container['MovieController'] = function ($container) {
    return new \WarezAddict\MovieDB\MovieController($container);
};

// CSRF Protection
$container['csrf'] = function () {
    return new \Slim\Csrf\Guard;
};

// Middleware
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));
$app->add($container['csrf']);
v::with('App\\Validation\\Rules\\');

// Routes
require_once __DIR__ . '/routes.php';
