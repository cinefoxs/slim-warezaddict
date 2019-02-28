<?php

namespace App\Validation\Rules;

use \App\Models\User;
use \Respect\Validation\Rules\AbstractRule;

/**
 * EmailAvailable
 *
 * @package App\Validation\Rules
 *
 */
class EmailAvailable extends AbstractRule
{
    /**
     * validate
     *
     * @param $input string - E-mail address to validate
     * @return bool
     *
     */
    public function validate($input)
    {
        return User::where('email', $input)->count() === 0;
    }
}
