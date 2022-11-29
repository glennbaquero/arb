<?php

namespace App\Http\Controllers\Admin\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Validation\ValidationException;

use App\Models\Documents\Document;

use App\Http\Controllers\Admin\Reports\ReportFetchController;
use App\Http\Controllers\Admin\Reports\StorageConsumedFetchController;
use App\Http\Controllers\Admin\Reports\UsageTimeFetchController;

use App\Exports\Documents\DocumentExport;
use App\Exports\Reports\StorageConsumedExport;
use App\Exports\Reports\TimeUsageExport;

use Excel;
use Carbon\Carbon;

class ReportController extends Controller
{

    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\Reports\ReportMiddleware', 
            ['only' => ['index', 'export']]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$types = Document::getTypes();
        $approvers = [];
        array_push($approvers, [
            'label' => 'Admin',
            'value' => 0,
        ]);
        array_push($approvers, [
            'label' => 'Supervisor',
            'value' => 1,
        ]);

        return view('admin.reports.index', compact('types', 'approvers'));
    }

    public function export(Request $request)
    {
        $controller = new ReportFetchController;

        $request = $request->merge(['nopagination' => 1]);
        $data = [];
        $data = $controller->fetch($request);
        $message = 'Exporting data, please wait...';

        if (!$data) {
            throw ValidationException::withMessages([
                'items' => 'No sample items found.',
            ]);
        }

        if (!$request->ajax()) {
            return Excel::download(new DocumentExport($data->original['items']),'Document-'.$request->start_date.'-to-'.$request->end_date.'.xls');
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => $message,
            ]);
        }
    }

    public function exportStorageConsumed(Request $request)
    {
        $controller = new StorageConsumedFetchController;
        $now = Carbon::now()->format('M d, Y');
        $request = $request->merge(['nopagination' => 1]);
        $data = [];
        $data = $controller->fetch($request);
        $message = 'Exporting data, please wait...';

        if (!$data) {
            throw ValidationException::withMessages([
                'items' => 'No sample items found.',
            ]);
        }

        if (!$request->ajax()) {
            return Excel::download(new StorageConsumedExport($data->original['items']),'Storage Consumed ('.$now.').xls');
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => $message,
            ]);
        }
    }
    public function exportTimeUsage(Request $request)
    {
        $controller = new UsageTimeFetchController;

        $request = $request->merge(['nopagination' => 1]);
        $data = [];
        $data = $controller->fetch($request);
        $message = 'Exporting data, please wait...';

        if (!$data) {
            throw ValidationException::withMessages([
                'items' => 'No sample items found.',
            ]);
        }

        if (!$request->ajax()) {
            return Excel::download(new TimeUsageExport($data->original['items']),'User time usage.xls');
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => $message,
            ]);
        }
    }
}
