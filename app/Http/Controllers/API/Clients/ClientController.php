<?php

namespace App\Http\Controllers\API\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Users\User;

class ClientController extends Controller
{
    public function clients(Request $request) 
    {
    	$user = $request->user();
    	$clients = [];

    	if($user->user_type != User::USER) {
    		$users = User::where('user_type', User::USER);

    		if($request->filled('search')) {
    			$users = $users->where('first_name', 'like', '%'.$request->search.'%')->orWhere('last_name', 'like', '%'.$request->search.'%');
    		}

            if($request->filled('sort')) {
                $users = $users->orderby('first_name', $request->sort);
            }

    		$clients = $this->getUsers($users->get());
    	}

    	return response()->json([
    		'clients' => $clients
    	]);
    }

    public function getUsers($users)
    {
    	$arr = [];

    	foreach ($users as $user) {
    		$document_count = $user->documents()->count();
    		array_push($arr, [
    			'full_name' => $user->renderName(),
    			'document_count' => $document_count <= 1 ? $document_count.' Document' : $document_count.' Documents',
                'id' => $user->id
    		]);
    	}

    	return $arr;
    }
}
