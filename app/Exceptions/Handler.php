<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {   

        if ($request->wantsJson()) {
            // Return reasonable response if trying to, for instance, delete nonexistent resource id.
            if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {            
                return response()->json([ 
                   'error' => [ 
                        'code' => 403, 
                        'message' => __("You don't have permission to process your request")
                    ]
                ], 403);
            }
            
            if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {            
                return response()->json([ 
                   'error' => [ 
                        'code' => 404, 
                        'message' => __("Resource not found.")
                    ]
                ], 404);
            }

            if($exception instanceof \Illuminate\Auth\AuthenticationException ){
                return response()->json([ 
                   'error' => [ 
                        'code' => 401, 
                        'message' => __("Unauthorized.")
                    ]
                ], 401);
            }

            if($exception instanceof \Illuminate\Database\Eloquent\RelationNotFoundException ){
                return response()->json([ 
                   'error' => [ 
                        'code' => 500, 
                        'message' => __("Requested Relationships are not found.")
                    ]
                ], 500);
            }
        }
        return parent::render($request, $exception);
    }
}
