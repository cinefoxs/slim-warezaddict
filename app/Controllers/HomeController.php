<?php

// Namespace
namespace App\Controllers;

// Use Libs
use \App\Controllers\Controller;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \App\Models\Vote;

/**
 * Class HomeController
 *
 * @package App\Controllers
 */
class HomeController extends \App\Controllers\Controller
{
    public function index(Request $request, Response $response, array $args)
    {
        // Auth Check
        if ($this->auth->check()) {
            $this->auth->user()->updateLastTime();
        }

        // Get Page Number
        $pageAttrib = $request->getAttribute('page');
        if (filter_var($pageAttrib, FILTER_VALIDATE_INT) && $pageAttrib >= 2 && $pageAttrib <= 99) {
            $page = $pageAttrib;
        } else {
            $page = 1;
        }

        // The Movie Database API Client
        $tmdb = $this->tmdb;
        $configRepo = new \Tmdb\Repository\ConfigurationRepository($tmdb);
        $config = $configRepo->load();
        $imgHelper = new \Tmdb\Helper\ImageHelper($config);

        // Get Movies Now Playing
        $nowPlaying = $tmdb->getDiscoverApi()->discoverMovies([
            'page' => $page,
            'language' => 'en'
        ]);

        if ($request->getAttribute('debug') == 'yes') {
            $debugMode = true;
        } else {
            $debugMode = false;
        }

        $this->flash->addMessageNow('success', 'Welcome to WarezAddict.com! Enjoy your stay...');

        // Render View
        return $this->view->render($response, 'home.twig', [
            'debugMode' => $debugMode,
            'current_page' => $page,
            //'now_playing' => $nowPlaying,
            'now_playing' => '',
        ]);
    }
/**
    public function someFunc(Request $request, Response $response, array $args = [])
    {
        // Page
        $page = 1;

        // Get Query Params
        $input = $request->getAttribute('cat');

        // Clean that shit, ho
        $category = \TraderInteractive\Filter\Strings::stripTags($input);

        // Render View
        return $this->view->render($response, 'something.twig', [
            'current_page' => $page,
            'category' => $category
        ]);
        // Get Dick Sucked...
    }
**/
}
