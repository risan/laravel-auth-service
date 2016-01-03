<?php

namespace AuthService;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAuthEventListener();
        $this->registerAuthService();
    }

    /**
     * Register auth event listener.
     *
     * @return void
     */
    protected function registerAuthEventListener()
    {
        $this->app->bind(
            'AuthService\Contracts\AuthEventListener',
            'AuthService\AuthEventListener'
        );
    }

    /**
     * Register auth service.
     *
     * @return void
     */
    protected function registerAuthService()
    {
        $this->app->bind('AuthService\Contracts\AuthService', function($app) {
            $statefulGuard = $app['auth']->guard();
            $eventListener = $app->make('AuthService\Contracts\AuthEventListener');

            return new \AuthService\AuthService($statefulGuard, $eventListener);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'AuthService\Contracts\AuthEventListener',
            'AuthService\Contracts\AuthService'
        ];
    }
}
