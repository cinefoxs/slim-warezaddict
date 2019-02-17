<?php

// Namespace
namespace App\Controllers;

// Use Libs
use \App\Controllers\Controller;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class HomeController
 *
 * @package App\Controllers
 */
class HomeController extends \App\Controllers\Controller
{

    public function index(Request $request, Response $response, array $args)
    {
        // Get Page Number
        $pageAttrib = $request->getAttribute('page');

        if ($pageAttrib >= 2 && $pageAttrib <= 99) {
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

        // Render View
        return $this->view->render($response, 'home.twig', [
            'current_page' => $page,
            'now_playing' => $nowPlaying
        ]);
    }

    public function main(Request $request, Response $response)
    {
        // Render View
        return $this->view->render($response, 'home.twig', ['current_page' => $page]);
    }

}
