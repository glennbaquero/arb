<?php

namespace App\Http\Middleware\Admin\Inquiries;

use App\Extenders\BaseMiddleware as Middleware;

class InquiryMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.inquiries.crud'];
    }
}
