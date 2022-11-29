<?php

namespace App\Http\Middleware\Admin\Documents;

use App\Extenders\BaseMiddleware as Middleware;

class DocumentMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.documents.crud'];
    }
}
