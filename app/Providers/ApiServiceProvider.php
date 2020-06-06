<?php

namespace App\Providers;


use Carbon\Carbon;
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
        \App::bind( '/Helpers/DatesHelper.php' );
        \App::bind( '/Helpers/FilesHelper.php' );
        \App::bind( '/Helpers/FoldersHelper.php' );
        \App::bind( '/Helpers/GeneralHelper.php' );
        \App::bind( '/Helpers/NumbersHelper.php' );
        \App::bind( '/Helpers/StringsHelper.php' );
        \App::bind( '/Helpers/UsersHelper.php' );

        \App::bind( '/Librarys/GuzzleHttp.php' );
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()  {
       Carbon::setLocale( app()->getLocale());
    }
}
