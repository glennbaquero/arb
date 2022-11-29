<?php

namespace App\Rules;

use App\Extenders\BaseRule as Rule;
use Illuminate\Validation\Rule as Rules;
use App\Helpers\ListHelper;

class Gender extends Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->rules = [ Rules::in(ListHelper::getGenderList()) ];
        $this->message = 'The selected :attribute is not available in the list.';
    }
}
