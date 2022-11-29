<?php

namespace App\Http\Middleware\Admin\Roles;

use App\Extenders\BaseMiddleware as Middleware;

class RoleMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.roles.crud'];
    }
}
