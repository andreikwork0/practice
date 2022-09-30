<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
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
        Paginator::useBootstrap();

        Blade::if('roleis', function (...$roles) {

            $role =  request()->user()->role ?? false;

            if ($role){
                $rn = $role->name;
                if ($rn  == 'admin') return  true;



                if ($rn == 'kaf' && !(request()->user()->pulpit_id)) return false;


                if (! in_array($rn, $roles))    return false;
                else                            return true;

            }
            return false;




        });
    }
}
