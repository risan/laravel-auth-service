<?php

use Mockery as m;
use AuthService\AuthServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class AuthServiceProviderTest extends PHPUnit_Framework_TestCase {
    protected $app;
    protected $authServiceProvider;

    function setUp()
    {
        $this->app = m::mock(Application::class);

        $this->authServiceProvider = new AuthServiceProvider($this->app);
    }

    function tearDown()
    {
        m::close();
    }

    /** @test */
    function auth_service_provider_can_be_booted()
    {
        if (! function_exists('config_path')) {
            function config_path($path = '') {
                return 'foo';
            }
        }

        $this->assertNull($this->authServiceProvider->boot());
    }

    /** @test */
    function auth_service_provider_can_register_services()
    {
        $this->app->shouldReceive('singleton')->times(3)->withAnyArgs();

        $this->assertNull($this->authServiceProvider->register());
    }

    /** @test */
    function auth_service_provider_can_retrieve_provided_services()
    {
        $this->assertCount(3, $this->authServiceProvider->provides());
    }
}
