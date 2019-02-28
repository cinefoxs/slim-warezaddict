<?php

// Namespace
namespace App\Models;

// Use Libs
use \Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class Favs extends \Illuminate\Database\Eloquent\Model
{

    /**
     * Table Name
     *
     * @var string
     *
     */
    protected $table = 'favs';

    /**
     * Fillable
     *
     * @var array
     *
     */
    protected $fillable = [
        'movie_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Protected
     *
     * @var  string
     *
     */
    protected $movieId;
    protected $userId;

    /**
     * getAll
     *
     * @return array All Records In Database
     *
     */
    public function getAll()
    {
        return $this->all();
    }

    public function update()
    {
        $this->update([
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Save As Favorite
     *
     * @param array
     *
     */
    public function saveFavMovie($favInfo)
    {
        $userId = $favInfo['userId'];
        $movieId = $favInfo['movieId'];

        $this->logger->info('FAVORITE', [
            'Added' => $movieId,
            'User' => $userId,
            'Timestamp' => Carbon::now(),
        ]);

        $this->update([
            'user_id' => $userId,
            'movie_id' => $movieId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
