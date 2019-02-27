<?php

// Namespace
namespace WarezAddict\MovieDB;

/**
 * MovieEntity Class
 */
class MovieEntity implements \JsonSerializable
{
    /**
     * The id of the movie.
     *
     * @var string
     */
    private $id;

    /**
     * The author of the movie.
     *
     * @var string
     */
    private $author;

    /**
     * The title of the movie.
     *
     * @var string
     */
    private $title;

    /**
     * The genre of the movie.
     *
     * @var string
     */
    private $genre;

    /**
     * The price of the movie.
     *
     * @var float
     */
    private $price;

    /**
     * The published of the movie.
     *
     * @var \DateTimeImmutable
     */
    private $published;

    /**
     * The description of the movie.
     *
     * @var string
     */
    private $description;

    /**
     * Construct a new Movie instance.
     *
     * @param string             $id          The id of the movie.
     * @param string             $author      The author of the movie.
     * @param string             $title       The title of the movie.
     * @param string             $genre       The genre of the movie.
     * @param float              $price       The price of the movie.
     * @param \DateTimeImmutable $published   The published date of the movie.
     * @param string             $description The description of the movie.
     */
    public function __construct(
        string $id,
        string $author,
        string $title,
        string $genre,
        float $price,
        \DateTimeImmutable $published,
        string $description
    ) {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->genre = $genre;
        $this->price = $price;
        $this->published = $published;
        $this->description = $description;
    }

    /**
     * Returns the id of the movie.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the author of the movie.
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Returns the title of the movie.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the genre of the movie.
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Returns the price of the movie.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Returns the published of the movie.
     *
     * @return \DateTimeImmutable
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Returns the description of the movie.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the data for this object which can be serialized to JSON.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'title' => $this->title,
            'genre' => $this->genre,
            'price' => $this->price,
            'published' => $this->published->getTimestamp(),
            'description' => $this->description,
        ];
    }
}
