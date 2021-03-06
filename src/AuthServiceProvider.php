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
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/authservice.php' => config_path('authservice.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAuthServiceConfig();
        $this->registerAuthEventListener();
        $this->registerAuthService();
    }

    /**
     * Register auth service configuration.
     *
     * @return void
     */
    protected function registerAuthServiceConfig()
    {
        $this->app->singleton('AuthService\Contracts\AuthServiceConfigInterface', function ($app) {
            return \AuthService\AuthServiceConfig::fromArray($app['config']->get('authservice'));
        });
    }

    /**
     * Register auth event listener.
     *
     * @return void
     */
    protected function registerAuthEventListener()
    {
        $this->app->singleton('AuthService\Contracts\AuthEventListenerInterface', function ($app) {
            $redirector = $app['redirect'];
            $config = $app->make('AuthService\Contracts\AuthServiceConfigInterface');
            $eventListenerClass = $config->authEventListenerClass();

            return new $eventListenerClass($redirector, $config);
        });
    }

    /**
     * Register auth service.
     *
     * @return void
     */
    protected function registerAuthService()
    {
        $this->app->singleton('AuthService\Contracts\AuthServiceInterface', function ($app) {
            $statefulGuard = $app['auth']->guard();
            $eventListener = $app->make('AuthService\Contracts\AuthEventListenerInterface');

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
            'AuthService\Contracts\AuthServiceConfigInterface',
            'AuthService\Contracts\AuthEventListenerInterface',
            'AuthService\Contracts\AuthServiceInterface',
        ];
    }
}
