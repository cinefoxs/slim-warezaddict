<?php

// Namespace
namespace App\Controllers;

// Use Libs
use \App\Controllers\Controller;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class MovieController
 *
 * @package App\Controllers
 */
class MovieController extends \App\Controllers\Controller
{
    public function main(Request $request, Response $response)
    {
        // Get Page Number
        $pageAttrib = $request->getAttribute('page');

        if ($pageAttrib >= 2 && $pageAttrib <= 99) {
            $page = (int) $pageAttrib;
        } else {
            $page = 1;
        }

        // TMDB API Client
        $tmdb = $this->tmdb;
        $query = new \Tmdb\Model\Query\Discover\DiscoverMoviesQuery();

        $query
        ->page($page)
        ->language('en-US')
        ->includeAdult($allow = false)
        ->primaryReleaseDateLte('2019-02-01')
        ->primaryReleaseDateGte('2018-11-01')
        ->includeVideo($allow = true)
        ->sortBy($option = 'popularity.desc');

        $repo = new \Tmdb\Repository\DiscoverRepository($tmdb);
        $movData = $repo->discoverMovies($query);
        dump($movData);

        return $this->view->render($response, 'home.twig', [
            'current_page' => $page,
            'results' => $movData,
        ]);
    }
}
