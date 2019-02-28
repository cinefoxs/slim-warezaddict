<?php

namespace App\Validation\Exceptions;

use \Respect\Validation\Exceptions\ValidationException;

/**
 * EmailAvailableException
 *
 * @package App\Validation\Exceptions
 *
 */
class EmailAvailableException extends ValidationException
{
    /**
     * Default Template
     *
     * @var array
     *
     */
    public static $defaultTemplates = [
        self::MODE_DEFAULT  => [
            self::STANDARD => 'Sorry, {{name}} is NOT available!',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => '{{name}} is NOT taken!',
        ]
    ];
}
