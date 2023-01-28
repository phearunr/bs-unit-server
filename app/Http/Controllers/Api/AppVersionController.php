<?php

namespace App\Http\Controllers\Api;

use App\AppVersion;
use App\Http\Resources\AppVersion as AppVersionResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppVersionController extends Controller
{
    public function getLastestBuild(Request $request, $platform)
    {
    	try {
    		$app_version = AppVersion::latestBuild($platform)->first();
			if ( $request->input("embed") ) {			
				$relationships = explode(',', trim($request->input('embed')) );
				$app_version->load($relationships);
			}
			return new AppVersionResource( $app_version );
    	} catch (\Exception $e) {
    		return $this->sendErrorJsonResponse($e->getMessage(), 400);
    	}
    
    }
}
