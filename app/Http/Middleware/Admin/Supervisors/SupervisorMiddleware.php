<?php

namespace App\Http\Middleware\Admin\Supervisors;

use App\Extenders\BaseMiddleware as Middleware;

class SupervisorMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.supervisors.crud'];
    }
}
