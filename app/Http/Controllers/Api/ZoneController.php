<?php

namespace App\Http\Controllers\Api;

use App\Zone;
use App\Http\Resources\UserCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZoneController extends Controller
{
    public function getSiteEngineers($id)
    {
        $zone = Zone::findOrFail($id);
        $users = $zone->managedUsers()->get();
        return new UserCollection($users); 
    }
}
