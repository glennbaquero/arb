<?php

namespace App\Traits;

trait ArrayFormatterTrait
{
    /**
     * Format Array of Objects
     * @param  collection or array of objects
     * @return array        formatted array of objects
     */
    public static function formatList($items) {
        $result = [];

        foreach ($items as $item) {
            $result[] = static::formatItem($item);
        }

        return $result;
    }

    /**
     * Format Object's Properties
     * @param  object
     * @return object
     */
    public static function formatItem($item) {
    	return [
    		//
    	];
    }
}