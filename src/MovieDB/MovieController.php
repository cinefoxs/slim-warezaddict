<?php

// Namespace
namespace WarezAddict\MovieDB;

// Use Libs
use \App\Controllers\Controller;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \WarezAddict\Arrays;
use \WarezAddict\MovieDB\movieCriteria;
use \Zend\Diactoros\Stream;

/**
 * Class MovieController
 *
 * @package App\Controllers
 */
class MovieController extends \App\Controllers\Controller
{
    private $repository;

    /**
     * Handle GET /movies requests.
     *
     * @param ServerRequestInterface $request   Represents the current HTTP request.
     * @param ResponseInterface      $response  Represents the current HTTP response.
     * @param array                  $arguments Values for the current route’s named placeholders.
     *
     * @return ResponseInterface
     */
    public function index(Request $request, Response $response, array $args = [])
    {
        // Get Repo
        $repository = new \WarezAddict\MovieDB\FileRepository;

        // Get Query Params
        $queryParams = $request->getQueryParams();
        
        $limit = Arrays::get($queryParams, 'limit', 5);
        $offset = Arrays::get($queryParams, 'offset', 0);

        $movies = $repository->findAll($args);
        $total = count($movies);

        $result = [
            'offset' => $offset,
            'limit' => min($limit, $total),
            'total' => $total,
            'movies' => array_slice($movies, $offset, $limit),
        ];

        $stream = fopen('php://temp', 'r+');
        fwrite($stream, json_encode($result));
        rewind($stream);

        if ($queryParams['type'] == "json") {
            //return $response->withHeader('Content-Type', 'application/json')->withBody(new Stream($stream));
            $jData = \WarezAddict\General::prettyJson($result['movies']);
            return $response->withJson($result['movies'], 201, 480);
            //return $response->withHeader('Content-Type', 'application/json')->write($jData);
        } else {
            return $this->view->render($response, 'home.twig', $result);
        }

        // Render View
        // return $this->view->render($response, 'home.twig', $result);
    }

    /**
     * Handle GET /movies/:id requests.
     *
     * @param ServerRequestInterface $request   Represents the current HTTP request.
     * @param ResponseInterface      $response  Represents the current HTTP response.
     * @param array                  $arguments Values for the current route’s named placeholders.
     *
     * @return ResponseInterface
     */
    public function get(Request $request, Response $response, array $args = [])
    {
        $id = Arrays::get($args, 'id');

        $movie = $this->repository->find($id);
        if ($movie === null) {
            return $response->withStatus(404);
        }

        $stream = fopen('php://temp', 'r+');
        fwrite($stream, json_encode($movie));
        rewind($stream);

        return $response->withHeader('Content-Type', 'application/json')->withBody(new Stream($stream));
    }

    /**
     * Handle POST /movies requests.
     *
     * @param ServerRequestInterface $request   Represents the current HTTP request.
     * @param ResponseInterface      $response  Represents the current HTTP response.
     * @param array                  $arguments Values for the current route’s named placeholders.
     *
     * @return ResponseInterface
     */
    public function post(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $movie = json_decode((string)$request->getBody(), true);
        $id = $this->repository->create($movie);
        return $response->withStatus(201)->withHeader('Location', "/movies/{$id}");
    }

    /**
     * Handle PUT /movies/:id requests.
     *
     * @param ServerRequestInterface $request   Represents the current HTTP request.
     * @param ResponseInterface      $response  Represents the current HTTP response.
     * @param array                  $arguments Values for the current route’s named placeholders.
     *
     * @return ResponseInterface
     */
    public function put(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $id = Arrays::get($args, 'id');
        $movie = json_decode((string)$request->getBody(), true);
        $this->repository->update($id, $movie);
        return $response;
    }

    /**
     * Handle DELETE /movies/:id requests.
     *
     * @param ServerRequestInterface $request   Represents the current HTTP request.
     * @param ResponseInterface      $response  Represents the current HTTP response.
     * @param array                  $arguments Values for the current route’s named placeholders.
     *
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $id = Arrays::get($args, 'id');
        $this->repository->delete($id);
        return $response->withStatus(204);
    }
}
