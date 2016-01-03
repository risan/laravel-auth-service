<?php

namespace AuthService\Facades;

use Illuminate\Support\Facades\Facade;

class AuthService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'AuthService\Contracts\AuthService';
    }
}
