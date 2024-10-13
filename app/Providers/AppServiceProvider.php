<?php

namespace App\Providers;

use App\Rules\ReCaptchaRule;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('captcha', function ($attribute, $value, $fail) {
            return new ReCaptchaRule();
        });
        Paginator::defaultView('modules.paginator');
    }
}
