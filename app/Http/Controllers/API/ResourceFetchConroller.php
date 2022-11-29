<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Users\User;
use App\Models\Documents\Document;
use App\Models\Usages\TimeUsage;

use App\Jobs\Usage\TimeUsageJobs;

use Carbon\Carbon;

class ResourceFetchController extends Controller
{
    public function fetch(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'user' => $user,
        ]);
    }

    public function dashboard(Request $request)
    {
    	$user = $request->user();

    	if($user->user_type != User::USER) {
    		$user = User::find($request->user_id);
            $item['PDF'] = $user->documents->where('file_type', 'pdf')->count();
    		$item['XLXS'] = $user->documents->whereIn('file_type', ['xlxs', 'xls', 'csv', 'ods', 'xlsb', 'xlsm', 'xlsx', 'xml', 'xps'])->count();
    		$item['DOCX'] = $user->documents->whereIn('file_type', ['docx', 'doc', 'odt'])->count();
    		$item['POWERPOINT'] = $user->documents->whereIn('file_type', ['odp', 'potm', 'potx', 'ppa', 'ppam', 'pps', 'ppsm', 'ppt', 'pptx'])->count();
    		$item['IMAGES'] = $user->documents->whereIn('file_type', ['jpeg', 'jpg', 'png', 'heic'])->count();
    	} else {
            $item['PDF'] = $user->documents->where('file_type', 'pdf')->count();
            $item['XLXS'] = $user->documents->whereIn('file_type', ['xlxs', 'xls', 'csv', 'ods', 'xlsb', 'xlsm', 'xlsx', 'xml', 'xps'])->count();
            $item['DOCX'] = $user->documents->whereIn('file_type', ['docx', 'doc', 'odt'])->count();
            $item['POWERPOINT'] = $user->documents->whereIn('file_type', ['odp', 'potm', 'potx', 'ppa', 'ppam', 'pps', 'ppsm', 'ppt', 'pptx'])->count();
            $item['IMAGES'] = $user->documents->whereIn('file_type', ['jpeg', 'jpg', 'png', 'heic'])->count();
        }

        $item['bg_images']['PDF'] = url('mobile/pdf.svg');
        $item['bg_images']['XLXS'] = url('mobile/xlxs.svg'); 
        $item['bg_images']['DOCX'] = url('mobile/docs.svg');
        $item['bg_images']['POWERPOINT'] = url('mobile/powerpoint.svg');
        $item['bg_images']['IMAGES'] = url('mobile/images.svg'); 

    	$recents = $user->getFormattedDocument(true, 5);
        $check_unread_notifications = $request->user()->notifications()->whereNull('read_at')->count() ? true : false;
    	// $recents = $this->getFormatted()

    	return response()->json([
    		'item' => $item,
            'recents' => $recents,
            'total_document' => $user->documents()->withTrashed()->count(),
            'check_unread_notifications' => $check_unread_notifications
    	]);
    }

    public function saveUsage(Request $request) {
        $user = $request->user();
        
        TimeUsageJobs::dispatch($user);

        return response()->json([
            true
        ]);
    }
}
