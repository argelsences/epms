<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class EPPMSFacade extends Facade{

    /**
     * The return for the getFacadeAccessor is the name of the bind in Service provider
     */
    protected static function getFacadeAccessor() { return 'eppmshelper'; }
    /*protected static function getFacadeAccessor() { 
        return App\Providers\EPOMARSServiceProvider.php::class;
    }*/

}