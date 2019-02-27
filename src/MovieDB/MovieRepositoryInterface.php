<?php

// Namespace
namespace WarezAddict\MovieDB;

/**
 * Movie Repository
 */
interface MovieRepositoryInterface
{
    /**
     * Returns a movie entity with the given id.
     *
     * @param string $id The id of the movie to find.
     *
     * @return MovieEntity|null The movie entity or null if not found.
     */
    public function find($id);

    /**
     * Returns all movies matching the given criteria.
     *
     * @param MovieCriteria $criteria The criteria for the search.
     *
     * @return MovieEntity[] Array of movie entities.
     */
    public function findAll(array $criteria);

    /**
     * Creates a new movie entity with the given data.
     *
     * @param array $data The data for the new entity.
     *
     * @return string $id The id of the created entity.
     */
    public function create(array $data);

    /**
     * Updates an existing movie entity with the given data.
     *
     * @param string $id   The id of the entity to update.
     * @param array  $data The data to update for the entity.
     *
     * @return void
     */
    public function update($id, array $data);

    /**
     * Deletes an existing movie entity with the given id.
     *
     * @param string $id   The id of the entity to delete.
     *
     * @return void
     */
    public function delete($id);
}
