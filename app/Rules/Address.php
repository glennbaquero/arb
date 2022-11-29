<?php

namespace App\Rules;

use App\Extenders\BaseRule as Rule;

class Address extends Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->rules = 'max:150';
    }
}
