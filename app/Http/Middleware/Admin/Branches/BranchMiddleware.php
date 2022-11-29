<?php

namespace App\Http\Middleware\Admin\Branches;

use App\Extenders\BaseMiddleware as Middleware;

class BranchMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.branches.crud'];
    }
}
