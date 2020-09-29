<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EPPMSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('eppmshelper', function(){
            return new \App\Helpers\EPPMSHelper;
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
