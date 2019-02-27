<?php

// Namespace
namespace App\Models;

// Use Libs
use \Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class Favs extends Model
{
    /**
     * Database Table
     *
     * @var string
    **/
    protected $table = 'favs';

    /**
     * Fillable
     *
     * @var array
    **/
    protected $fillable = [
        'id',
        'movie_id',
        'created_at',
        'updated_at',
    ];

    /**
     * @param $user_id
     */
    public function setFav($id)
    {
        $this->id = $id;
    }
}
