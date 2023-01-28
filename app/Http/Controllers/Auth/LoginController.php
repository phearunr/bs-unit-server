<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    protected $username = "phone_number";
    protected $allow_roles;

    public function __construct()
    {
        $this->allow_roles = [
            UserRole::ADMINISTRATOR,
            UserRole::CONTRACT_CONTROLLER,
            UserRole::ACCOUNTANT,
            UserRole::UNIT_CONTROLLER,
            UserRole::SALE_MANAGER,
            UserRole::SITE_MANAGER,
            UserRole::SITE_ENGINEER,
            UserRole::CUSTOMER_SERVICE,
            UserRole::SALE_TEAM_LEADER,
            UserRole::AGENT,
            UserRole::PROJECT_COORDINATOR,
            UserRole::USER,
            UserRole::HANDOVER_OFFICER,
        ];
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole($this->allow_roles)) {
                return redirect()->route('home');
            } else {
                Auth::logout();
            }
        }

        return view('auth.login');
    }

    public function authenticate(Request $request) 
    {

        $credentials = $request->only($this->username(), 'password');

        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);


        if (Auth::attempt($credentials, $request->filled('remember'))) {            
            // Authentication passed...
            if ( Auth::user()->hasRole(UserRole::ADMINISTRATOR.'|'.UserRole::CONTRACT_CONTROLLER) ) {
                return redirect()->route('home');
            }          
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    public function username() {
        return $this->username;
    }
}
