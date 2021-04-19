<?php

namespace App\Providers;


use Carbon\Carbon;
use App\Mixins\JsonApiBuilder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
 
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
        
        // Creao un mixin para agupar funcionalidades, en este caso del laravel builder. Extiende las funcionalidades del builder
        //JsonApiBuilder  Es una classe creada en cualquier sitio de nuestra aplicación. Para el caso, App\Mixins. y allí creo la clase.
        Builder::mixin( new JsonApiBuilder); 
        //Schema::defaultStringLength(191);
    }
}
