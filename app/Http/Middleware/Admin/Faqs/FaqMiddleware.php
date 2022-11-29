<?php

namespace App\Http\Middleware\Admin\Faqs;

use App\Extenders\BaseMiddleware as Middleware;

class FaqMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.faqs.crud'];
    }
}
