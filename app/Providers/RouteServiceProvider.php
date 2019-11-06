<?php

namespace App\Providers;

use App\Entity\Region;
use App\Http\Router\AdvertsPath;
use App\Http\Router\PagePath;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {

//        Route::bind('region_path', function ($value){
//            if (!$region = Region::where('slug', $value)->first()){
//                abort(404);
//            }
//            return $region;  // return $region in web/route and in controller->action(Region $region)
//        });

        parent::boot();

        Route::model('adverts_path', AdvertsPath::class);
        Route::model('page_path', PagePath::class);
    }


    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }


    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }


    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
