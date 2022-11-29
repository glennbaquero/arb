<?php

namespace App\Rules;

use App\Extenders\BaseRule as Rule;

class Email extends Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table = 'users', $except = '')
    {
        $this->rules = 'max:255|email|unique:' . $table . ',email' . ($except ? ',' . $except : '');
    }
}
