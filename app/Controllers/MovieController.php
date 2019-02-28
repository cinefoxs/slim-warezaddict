<?php

// Namespace
namespace App\Controllers;

// Use Libs
use \App\Controllers\Controller;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

class MovieController extends \App\Controllers\Controller
{

    public function getDetails(Request $request, Response $response, array $args)
    {
        $movieID = $request->getAttribute('id');

        $client = $this->tmdb;
        $repo = new \Tmdb\Repository\MovieRepository($client);
        $mData = $repo->load($movieID);

        $data = [
            'movieID' => $movieID,
            'results' => $mData,
        ];

        return $this->container->view->render($response, 'details.twig', $data);
    }

    /**
     * OmdbMovieSearch
     *
     * Get detailed info from OMDB API
     *
     * @param Request  $request  Request
     * @param Response $response Response
     * @param array    $args     args
     *
     */
    public function readMore(Request $request, Response $response, array $args = [])
    {
        // Get Name
        $movieName = $request->getAttribute('name');

        // Un-Slugify Name
        $unslug = str_replace('-', ' ', $movieName);

        // Clean It
        $cleanName = filter_var($unslug, FILTER_SANITIZE_STRING);

        if ($cleanName) {
            // Log It
            $this->logger->info('OMDB Query', [
                'name' => $cleanName,
            ]);

            // Search It
            $res = $this->omdb->get_by_title($cleanName);

            // View It
            return $this->container->view->render($response, 'results.twig', [
                'results' => $res,
            ]);
        } else {
            // No Search Query
            return $this->container->view->render($response, 'home.twig', [
                'results' => '',
            ]);
        }
    }

    public function topRated(Request $request, Response $response, array $args)
    {
        $pageNum = $request->getAttribute('pageNum');

        $client = $this->tmdb;
        $repo = new \Tmdb\Repository\MovieRepository($client);

        $topRated = $repo->getTopRated(array('page' => $pageNum));
        //$popular = $repo->getPopular();

        return $this->container->view->render($response, 'details.twig', $topRated);
    }
}
