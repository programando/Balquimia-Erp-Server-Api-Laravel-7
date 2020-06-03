<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind( '/Helpers/NumbersHelper.php' );
        \App::bind( '/Helpers/StringsHelper.php' );
        \App::bind( '/Librarys/GuzzleHttp.php' );

        
 
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
