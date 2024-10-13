<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

use App\Extensions\CategoryRouteService;

class CategoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CategoryRouteService::class, function (Application $app) {
            return new CategoryRouteService;
        });
    }
}
