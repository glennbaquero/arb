<?php

namespace App\Rules;

use App\Extenders\BaseRule as Rule;

class Text extends Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->rules = 'max:65535';
    }
}
