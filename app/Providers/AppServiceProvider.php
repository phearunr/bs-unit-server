<?php

namespace App\Providers;

// use DB;
// use Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use App\Unit;
use App\Observers\UnitObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        Carbon::macro('toSystemDateString', function (){
            return $this->format(config('app.php_date_format'));
        });
        
        Carbon::macro('toSystemDateTimeString', function (){
            return $this->format(config('app.php_datetime_format'));
        });

        // Model Observation
        Unit::observe(UnitObserver::class);

        // Log Database Query Statement
        // DB::listen(function($query) {
        //     Log::info(
        //         $query->sql,
        //         $query->bindings,
        //         $query->time
        //     );
        // });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
