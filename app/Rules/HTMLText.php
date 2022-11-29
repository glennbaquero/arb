<?php

namespace App\Rules;

use App\Extenders\BaseRule as Rule;

class HTMLText extends Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->rules = 'max:16777215';
        $this->message = 'The :attribute is too long';
    }
}
