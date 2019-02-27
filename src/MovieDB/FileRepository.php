<?php

// Namespace
namespace WarezAddict\MovieDB;

// Use Libs
use \WarezAddict\Arrays;

/**
 * File storage implementation of a MovieRepository
 */
class FileRepository implements \WarezAddict\MovieDB\MovieRepositoryInterface
{
    /**
     * The file to which the movies are written.
     *
     * @var string
     */
    private $path;

    /**
     * Array of movie objects.
     *
     * @var array
     */
    private $movies = [];

    /**
     * Construct a new instance of FileRepository.
     *
     * @var string $path The file to which the movies are written.
     */
    public function __construct($path = '/GITHUB/slim-warezaddict/database/MovieDB.json')
    {
        $this->path = $path;
        if (!file_exists($this->path)) {
            return;
        }

        $array = (array)json_decode(file_get_contents($this->path), true);

        foreach ($array as $data) {
            $movie = self::make($data);
            $this->movies[$movie->getId()] = $movie;
            //echo "Movie Added!" . "\n";
        }
    }

    /**
     * Returns a movie entity with the given id.
     *
     * @param string $id The id of the movie to find.
     *
     * @return MovieEntity|null The movie entity or null if not found.
     */
    public function find($id)
    {
        return Arrays::get($this->movies, $id);
    }

    /**
     * Returns all movies matching the given criteria.
     *
     * @param movieCriteria $criteria The criteria for the search.
     *
     * @return MovieEntity[] Array of movie entities.
     */
    public function findAll(array $criteria)
    {
        $searchable = json_decode(json_encode($this->movies), true);
        $movies = [];
        foreach (Arrays::where($searchable, $criteria) as $movie) {
            $movies[] = self::make($movie);
        }

        return $movies;
    }

    /**
     * Creates a new movie entity with the given data.
     *
     * @param array $data The data for the new entity.
     *
     * @return string $id The id of the created entity.
     */
    public function create(array $data)
    {
        $id = uniqid();
        $this->movies[$id] = self::make(['id' => $id] + $data);
        return "{$id}";
    }

    /**
     * Updates an existing movie entity with the given data.
     *
     * @param string $id   The id of the entity to update.
     * @param array  $data The data to update for the entity.
     *
     * @return boolean
     */
    public function update($id, array $data)
    {
        $movie = Arrays::get($this->movies, $id);
        if ($movie === null) {
            return false;
        }

        $this->movies[$id] = self::make($data + $movie->jsonSerialize());
    }

    /**
     * Deletes an existing movie entity with the given id.
     *
     * @param string $id The id of the entity to delete.
     *
     * @return void
     */
    public function delete($id)
    {
        unset($this->movies[$id]);
    }

    /**
     * Persist the movies to the file path
     *
     * @return void
     */
    public function __destruct()
    {
        file_put_contents(
            $this->path,
            json_encode($this->movies)
        );
    }

    /**
     * Helper method to construct a MovieEntity.
     *
     * @param array $data The data for the entity.
     *
     * @return MovieEntity
     */
    private static function make(array $data)
    {
        $published = Arrays::get($data, 'published');
        if (!is_a($published, '\DateTimeImmutableInterface')) {
            if (ctype_digit($published)) {
                $published = "@{$published}";
            }

            $published = new \DateTimeImmutable($published);
        }

        return new \WarezAddict\MovieDB\MovieEntity(
            Arrays::get($data, 'id'),
            Arrays::get($data, 'author'),
            Arrays::get($data, 'title'),
            Arrays::get($data, 'genre'),
            (float)Arrays::get($data, 'price'),
            $published,
            Arrays::get($data, 'description')
        );
    }
}
