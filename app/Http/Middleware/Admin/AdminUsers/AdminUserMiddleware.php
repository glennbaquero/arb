<?php

namespace App\Http\Middleware\Admin\AdminUsers;

use App\Extenders\BaseMiddleware as Middleware;

class AdminUserMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.admin-users.crud'];
    }
}
