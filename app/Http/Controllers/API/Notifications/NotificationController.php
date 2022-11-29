<?php

namespace App\Http\Controllers\API\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Notifications\UserNotification;

use Carbon\Carbon;
use DB;

class NotificationController extends Controller
{
    /**
     * Fetch paginated notifications
     * 
     * @return 
     */
    public function notifications()
    {
        $user = request()->user();
        $today = now();
        $yesterday = Carbon::now()->subDays(1);
        // $new = $user->notifications()->whereDate('created_at', '<=', $today)->whereDate('created_at', '>=', $five_days_from_now)->get();
        // $earlier = $user->notifications()->whereDate('created_at', '<=', $five_days_from_now)->get();
        $new = $user->notifications()->whereDate('created_at', $today)->get();
        $earlier = $user->notifications()->whereDate('created_at', $yesterday)->get();
        $past = $user->notifications()->whereDate('created_at', '<', $yesterday)->orderby('created_at', 'desc')->get();
        $new_formatted = $this->formatNotification($new);
        $earlier_formatted = $this->formatNotification($earlier, false, true);
        $past_formatted = $this->formatNotification($past, false, false, true);

        return response()->json([
            'new' => $new_formatted,
            'earlier' => $earlier_formatted,
            'past' => $past_formatted,
        ]);
    }

    /**
     * Read Notificationn
     * 
     * @return 
     */
    public function readNotification(Request $request)
    {
        DB::beginTransaction();
            UserNotification::find($request->id)->update(['read_at' => Carbon::now()]);
        DB::commit();

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function formatNotification($notifications, $new=true, $earlier=false, $date=false) {
        $notification_arr = [];
        foreach ($notifications as $key => $notification) {
            if($new) {
                $display_date = 'Today';
            } elseif($earlier) {
                $display_date = 'Yesterday';
            } elseif($date) {
                $display_date = Carbon::parse($notification->created_at)->format('d F Y');
            }

            array_push($notification_arr, [
                'message' => $notification->data['message'],
                'title' => $notification->data['title'],
                'date' => $display_date,
                'id' => $notification->id,
                'read_at' => $notification->read_at ? true : false,
            ]);
        }
        return $notification_arr;
    }
}
