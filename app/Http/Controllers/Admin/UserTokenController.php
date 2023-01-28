<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserTokenController extends Controller
{
   	public function show($id)
   	{
   		$user = User::findOrFail($id);
   		$tokens = $user->tokens;

   		return view('admin.user.token.show', compact('user','tokens'));
   	}

   	public function destroy($id)
   	{
   		$result = Token::destroy($id);

        if ( $result == 0 ) {
            return response()->json([
                "message" => __("Invalid object!"),
            ], 404); 
        } else {
            return response()->json([
                "message" => __("Resource has been successfully removed.")
            ], 200);
        }
   	}
}
