<?php

namespace App\Helpers;

class GlobalChecker
{
    public $route;

    public function __construct($user = null)
    {
        /* Create the version checker */
        $this->route = new RouteChecker();
    }    
}