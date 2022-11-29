<?php

namespace App\Rules;

use App\Extenders\BaseRule as Rule;

class Username extends Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table = 'users', $except = '')
    {
        $this->rules = 'alpha_dash|max:255|unique:' . $table . ',username' . ($except ? ',' . $except : '');
    }
}
