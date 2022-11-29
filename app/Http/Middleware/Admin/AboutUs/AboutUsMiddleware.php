<?php

namespace App\Http\Middleware\Admin\AboutUs;

use App\Extenders\BaseMiddleware as Middleware;

class AboutUsMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.about-us.crud'];
    }
}
