<?php

namespace App\Traits;

use App\Helpers\ObjectHelper;

trait HelperTrait
{
    public function renderName() {
        return;
    }

    public function renderShowUrl() {
        return;
    }

    /**
     * @Helpers
     */
    public static function renderConstants($array, $value, $column = 'label', $compare_column = 'value') {

        /* Loop through the array */
        foreach ($array as $obj) {
            
            if($obj[$compare_column] == $value) {

                /* Fetch columm if specified */
                if($column && isset($obj[$column]))
                    return $obj[$column];

                return $obj;
            }
        }
    }

    public function renderClassName() {
        return ObjectHelper::getShortClassName($this);
    }

    public function renderLogName() {
        return "{$this->renderClassName()} #{$this->id}";
    }
}