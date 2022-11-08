<?php

namespace App\Providers;

use App\Http\Controllers\Convention\ConventionInterface;
use App\Http\Controllers\Convention\ConvFactory;
use App\Models\Convention;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
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

        $this->app->bind(ConventionInterface::class, function ($app) {
            $id =  Route::current()->parameter('convention');
            $conv=  Convention::find($id);
            return  ConvFactory::create($conv->type->slug);
        });


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
