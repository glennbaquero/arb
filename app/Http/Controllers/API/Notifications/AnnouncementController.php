<?php

namespace App\Http\Controllers\API\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Announcements\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Fetch paginated announcements
     * 
     * @return 
     */
    public function announcements()
    {
        $user = request()->user();

        $data = Announcement::orderby('id', 'desc')->get();

        return response()->json([
            'data' => $data,
        ]);
    }
}
