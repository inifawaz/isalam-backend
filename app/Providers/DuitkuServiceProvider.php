<?php

namespace App\Providers;

use App\Helpers\Duitku;
use Illuminate\Support\ServiceProvider;

class DuitkuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('OnaizaDuitku', function ($app) {
            return new Duitku;
        });
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
