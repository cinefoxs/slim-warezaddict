<?php

// Namespace
namespace App\Auth;

// Use Libs
use \App\Models\User;

/**
 * Auth Class
 */
class Auth
{

    public function user()
    {
        return User::find($_SESSION['user']);
    }

    public function allUsers()
    {
        return User::all();
    }

    public function updateLoginTime()
    {
        $user = User::find($_SESSION['user']);
        $user->updateLastTime();
    }

    public function check()
    {
        return isset($_SESSION['user']);
    }

    public function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->id;
            return true;
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }

    public function verifyAdmin($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return false;
        }

        if ($user->is_admin === "1" && password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->id;
            return true;
        }
        return false;
    }

    public function checkAdmin()
    {
        if (isset($_SESSION['user'])) {
            $user = User::find($_SESSION['user']);
            if ($user->is_admin === "1") {
                return true;
            }
        }
        return false;
    }
}
