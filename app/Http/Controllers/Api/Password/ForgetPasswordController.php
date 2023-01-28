<?php

namespace App\Http\Controllers\Api\Password;

use Validator;
use App\User;
use App\SmsPasswordReset;
use App\Helpers\DigitGenerator;
use App\Notifications\ResetPasswordSms;
use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForgetPasswordController extends Controller
{
    protected $verification_digit = 6;
    protected $phone_number_field = 'phone_number';
    protected $max_attempt = 3;
    protected $decay_miniute = 10;
    protected $rate_limiter;

    public function __construct(Cache $cache) 
    {
        $this->rate_limiter = new RateLimiter($cache);       
    }

    public function sendSmsCode(Request $request)
    {        
        $user = User::where($this->phone_number_field, $request->phone_number)->firstOrFail();

        try {
            if ( $this->rate_limiter->tooManyAttempts($request->phone_number, $this->max_attempt) ) {
                return $this->sendErrorJsonResponse( 
                    __("Too many attempts. You can try again in next")." "
                    .ceil($this->rate_limiter->availableIn($request->phone_number) / 60)
                    ." ".__('minutes.')
                , 429);
            }

            SmsPasswordReset::where($this->phone_number_field, $request->phone_number)->delete();
            $sms_password_reset = SmsPasswordReset::create([
                'phone_number' => $request->phone_number,
                'verification_code' => DigitGenerator::create($this->verification_digit),
                'created_at' => now()
            ]);

            if ( config('app.env') != 'local') {
                $user->notify((new ResetPasswordSms($sms_password_reset)));
            }

            $this->rate_limiter->hit($request->phone_number, $this->decay_miniute);

            return $this->sendSuccessResponse( __('Success'), 200, [] );

        } catch (\Exception $e) {        
            return $this->sendErrorJsonResponse( __("Internal Server Error!"), 500);
        }
    }

    public function getResetToken(Request $request)
    {
        $sms_password_reset = SmsPasswordReset::where($this->phone_number_field, $request->phone_number)
                                              ->where('verification_code', $request->verification_code)->first();

        if ( !$sms_password_reset ) {
            return $this->sendErrorJsonResponse(__('Incorrect verification code.'), 422);
        }

        if ( !is_null($sms_password_reset->token) ) {
            return $this->sendErrorJsonResponse(__('Verificaton code is already validated. Please try to reset again.'), 422);   
        }

        $sms_password_reset->token = md5($sms_password_reset->phone_number.time().$sms_password_reset->verification_code);
        try {
            $sms_password_reset->save();
            return $this->sendSuccessResponse( __('Success'), 200, $sms_password_reset->makeVisible(['token']) );           
        } catch (\Exception $e) {
            return $this->sendErrorJsonResponse( __("Internal Server Error!"), 500);   
        }
    }
}
