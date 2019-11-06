<?php

namespace App\Providers;

use App\Entity\Page;
use App\Services\Banner\CostCalculator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

//        View::composer('layouts.app', function (\Illuminate\Contracts\View\View $view){
//            $view->with('menuPages', Page::whereIsRoot()->defaultOrder()->getModels());
//        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CostCalculator::class, function (Application $app) {
            $config = $app->make('config')->get('banner');
            return new CostCalculator($config['price']);
        });

        Passport::ignoreMigrations();
    }
}
