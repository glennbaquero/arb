<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Users\DeviceToken;

class DeviceTokenController extends Controller
{
    public function store(Request $request) {

        $filters = [
            'user_type' => get_class($request->user()),
            'token' => $request->input('token'),
        ];

        $params = [
            'user_id' => $request->user()->id,
            'platform' => $request->input('platform'),
        ];

        $token = DeviceToken::where($filters)->first();

        if (!$token) {
            $token = DeviceToken::create(array_merge($filters, $params));
        } else {
            if ($token->user_id != $request->user()->id) {
                $token->update($params);
            }
        }

        return response()->json(true);
    }
}
