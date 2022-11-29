<?php

namespace App\Http\Middleware\Admin\Announcements;

use App\Extenders\BaseMiddleware as Middleware;

class AnnouncementMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.announcements.crud'];
    }
}
