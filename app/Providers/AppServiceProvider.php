<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
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
        Validator::extend('identificacion', function($attribute, $value, $parameters, $validator){
            return preg_match('/^\d{8}-\d{1}$|^\d{4}-\d{6}-\d{3}-\d{1}$/', $value);
        }, "En el dui o nit debe tener un formato valido");
    }
}
