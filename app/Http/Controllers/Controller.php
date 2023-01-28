<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function sendErrorJsonResponse($message, $code = 500) 
    {    	
        return response()->json([ 
            'error' => [ 
                'code' => $code , 'message' => $message
            ]
        ], $code);
    }

    public function sendSuccessResponse( $message, $code, $data = [] ) 
    {
    	return response()->json([ 
    		'data' => $data,
    		'code' => $code,
    		'message' => $message
        ], $code);
    }

    public function covertToStandardDateFormat($data, $date_key_array)
    {        
        foreach( $date_key_array as $key ) {
            if ( ! isset($data[$key]) ) {
                continue;
            }
            $format = config('app.php_date_format');
            $data[$key] = \Carbon\Carbon::createFromFormat($format, $data[$key])->startOfDay()->format('Y-m-d');
        }
        return $data;
    }
}
