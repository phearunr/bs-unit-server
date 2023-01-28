<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {	
        return view('auth.passwords.change');
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password'  => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('id', Auth::id())->first();

        if ( !(Hash::check($request->input('current_password'), $user->password)) ) {
            return back()->withErrors(['current_password' => __("Current Password is incorrect.")]);
        }

        try {          
            $user->password = bcrypt($request->input('password'));
            $user->save();
            $user->tokens()->delete();
            return back()->with('status', __("Your password has been changed successfully."));
        } catch (\Exception $e) {
            return back()->withErrors([ 'change_password' =>  $e->getMessage()]);
        }        
    }
}
