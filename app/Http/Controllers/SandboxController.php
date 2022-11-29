<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\EnvHelper;
use Illuminate\Http\UploadedFile;

class SandboxController extends Controller
{
    public function __contruct() {
    	if (!EnvHelper::isDev()) {
    		abort(404);
    	}
    }

    public function index() {
    	return view('sandbox.index');
    }
}
