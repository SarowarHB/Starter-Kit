<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Vite::macro('image', fn ($asset) => $this->asset("resources/images/{$asset}"));
        Validator::extend('phone_number', function($attribute, $value, $parameters)
        {
            $has_plus = substr($value, 0, 1) == '+';
            $mobile_arr = explode('-', $value);
            return $has_plus && count($mobile_arr) == 2 && is_numeric($mobile_arr[1]);
        });
    }
}
