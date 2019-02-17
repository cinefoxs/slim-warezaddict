<?php

// Namespace
namespace App\Models;

// Use Libs
use \Carbon\Carbon;
use \Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @package App\Models
 */
class User extends Model
{
    /**
     * @var string
     */
    protected $table = 'users';

    public $name;
    public $email;
    public $created_at;
    public $updated_at;
    public $is_admin;
    public $avatar_url;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'created_at',
        'updated_at',
        'is_admin',
        'avatar_url',
    ];

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->update([
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public function setAdmin()
    {
        $this->update([
            'is_admin' => "1",
        ]);
    }

    public function getUserId()
    {
        return $this->getKey();
    }

    public function getAll()
    {
        return $this->all();
    }

    public function setName($name)
    {
        $this->name = trim($name);
    }

    public function getName()
    {
        return $this->name;
    }

    public function gravatar($email = '', $size = '')
    {
        $default = '/images/default_avatar.jpg';
        $size = 65;
        /**
         *
         * $email = md5(strtolower(trim($email)));
         * $gravurl = "http://www.gravatar.com/avatar/" . $email . "?s=" . $size . "&d=identicon&r=PG";
         * return '<img src="' . $gravurl . '" width="' . $size . '" height="' . $size . '" border="0" alt="Avatar">';
         *
         */
        return '<img src="' . $default . '" width="' . $size . '" height="' . $size . '" border="0" alt="Avatar">';
    }

    public function updateLastTime()
    {
        $this->update([
            'updated_at' => Carbon::now(),
        ]);
    }
}
