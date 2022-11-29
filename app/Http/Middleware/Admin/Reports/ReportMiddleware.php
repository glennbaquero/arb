<?php

namespace App\Http\Middleware\Admin\Reports;

use App\Extenders\BaseMiddleware as Middleware;

class ReportMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.reports.crud'];
    }
}
