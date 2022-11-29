<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\UpdatePasswordRequest;

use Illuminate\Validation\ValidationException;

use App\Models\Users\User;

use DB;
use Hash;

class UserController extends Controller
{

	/**
	 * Update user password when he is a first time user in app
	 *
	 * @return array
	 */
   	public function firstLoginUpdatePassword(UpdatePasswordRequest $request)
   	{
   		$user = $request->user();

   		DB::beginTransaction();
   			// if($user->is_first_time) {
   				$user->update([
   					'password' => Hash::make($request->password),
   					'is_first_time' => false
   				]);
   			// } else {
   				// throw ValidationException::withMessages([
   				//     'first_time' => "This user is not applicable for this method.",
   				// ]);
   			// }
   		DB::commit();

   		return response()->json([
            'user' => $user
        ]);
   	}

      /**
       * Update user password 
       *
       * @return array
       */
      
      public function update(Request $request) 
      {
         $user = $request->user();
         $user->changePassword($request->current_password, $request->password, $request->user());

         return response()->json([
            'user' => $user,
            'message' => 'You have successfully update your password.'
         ]);
      }

      /**
       * Logout user 
       *
       * @return array
       */
      
      public function logout(Request $request) 
      {

         auth()->guard('api')->logout();

         return response()->json([
            'message' => 'User logged out'
         ]);
      }
      

}
