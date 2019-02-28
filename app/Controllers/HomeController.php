<?php

// Namespace
namespace App\Controllers;

// Use Libs
use \App\Controllers\Controller;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \App\Models\Favs;

/**
 * HomeController Class
 *
 * @package App\Controllers
 *
 */
class HomeController extends \App\Controllers\Controller
{

    public function index(Request $request, Response $response, array $args)
    {

        // Page Number
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

        // Debug Mode
        if ($request->getAttribute('debug') == 'yes') {
            // Debug Mode Enabled
            $debugMode = true;
            // Flash Msg
            $this->flash->addMessageNow('success', 'Debug Mode Enabled!');
        } else {
            $debugMode = false;
        }

        // Data For Twig
        $data = [
            'debugMode' => $debugMode,
            'current_page' => $page,
            'total_pages' => $nowPlaying['total_pages'],
            'total_results' => $nowPlaying['total_results'],
            'results' => $nowPlaying['results'],
        ];

        // Render View
        return $this->view->render($response, 'home.twig', $data);
    }


/** **************************************************************************************
    public function someFunc(Request $request, Response $response, array $args = [])
    {
        // Debug Mode
        if ($request->getAttribute('debug') == 'yes') {
            $debugMode = true;
        } else {
            $debugMode = false;
        }

        // Get Something
        $input = $request->getAttribute('cat');
        // Clean It
        $cat = \WarezAddict\General::sanitize($input);

        // Render View
        return $this->view->render($response, 'something.twig', [
            'category' => $cat,
            'debugMode' => $debugMode,
        ]);

        // Get Dick Sucked...
        // echo 'Getting Dick Sucked....';
    }
****************************************************************************************** **/
}
