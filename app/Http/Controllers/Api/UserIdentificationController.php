<?php

namespace App\Http\Controllers\Api;

use App\UserIdentification;
use App\Http\Resources\UserIdentificationCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserIdentificationController extends Controller
{
    public function all() {
    	return new UserIdentificationCollection( UserIdentification::all() );
    }
}
