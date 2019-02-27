<?php

// Namespace
namespace App\Controllers;

// Use Libs
use \App\Controllers\Controller;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \WarezAddict\General;

class SearchController extends \App\Controllers\Controller
{

    public function index(Request $request, Response $response)
    {
        // Search Query
        $getQuery = $request->getParam('q');

        // Get Page Number - TODO: Fix this hack
        $page = (!isset($_GET['page'])) ? 1 : General::onlyNum($_GET['page']);

        $cleanQuery = General::cleanData($getQuery);

        $searchData = $this->tmdb->getSearchApi()->searchMulti($cleanQuery, ['page' => 1]);

        if ($page >= 2 && $page <= $searchData['total_pages']) {
            $searchData = $this->tmdb->getSearchApi()->searchMulti($cleanQuery, ['page' => $page]);
        }

        // Pagination
        /**
        $pagination = new \WarezAddict\Pagination();
        $pagination->setCurrent($page);
        $pagination->setCrumbs(5);
        $pagination->alwaysShowPagination();
        $pagination->setRPP(20);
        $pagination->setKey('page');
        $pagination->setTotal($searchData['total_results']);
        $pager = $pagination->parse();

        $searchResults = [
            'pagination' => $pager,
            'currentPage' => $page,
            'results' => $searchData['results'],
        ];
        **/

        // Log It
        $query = [
            'query' => $cleanQuery,
        ];
        $this->logger->warning('SEARCH', $query);

        return $this->container->view->render($response, 'results.twig', ['results' => '']);
    }
}
