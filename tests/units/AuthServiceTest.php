<?php

use Mockery as m;

use AuthService\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\StatefulGuard as StatefulGuardContract;
use AuthService\Contracts\AuthEventListener as AuthEventListenerContract;

class AuthServiceTest extends PHPUnit_Framework_TestCase {
    protected $statefulGuard;
    protected $eventListener;
    protected $redirectResponse;
    protected $authService;

    function setUp()
    {
        $this->statefulGuard = m::mock(StatefulGuardContract::class);
        $this->eventListener = m::mock(AuthEventListenerContract::class);
        $this->redirectResponse = m::mock(RedirectResponse::class);
        $this->authService = new AuthService($this->statefulGuard, $this->eventListener);
    }

    function tearDown()
    {
        m::close();
    }

    /** @test */
    function auth_service_has_stateful_guard()
    {
        $this->assertInstanceOf(StatefulGuardContract::class, $this->authService->statefulGuard());
    }

    /** @test */
    function auth_service_has_event_listener()
    {
        $this->assertInstanceOf(AuthEventListenerContract::class, $this->authService->eventListener());
    }

    /** @test */
    function auth_service_can_handle_invalid_login_credentials()
    {
        $credentials = ['email' => 'foo', 'password' => 'bar'];

        $this->statefulGuard->shouldReceive('attempt')
            ->with($credentials, false)
            ->times(1)
            ->andReturn(false);

        $this->eventListener->shouldReceive('userHasFailedToLogIn')
            ->times(1)
            ->andReturn($this->redirectResponse);

        $this->assertInstanceOf(RedirectResponse::class, $this->authService->login($credentials, false));
    }

    /** @test */
    function auth_service_can_handle_valid_login_credentials()
    {
        $credentials = ['email' => 'foo', 'password' => 'bar'];

        $this->statefulGuard->shouldReceive('attempt')
            ->with($credentials, false)
            ->times(1)
            ->andReturn(true);

        $this->eventListener->shouldReceive('userHasLoggedIn')
            ->times(1)
            ->andReturn($this->redirectResponse);

        $this->assertInstanceOf(RedirectResponse::class, $this->authService->login($credentials, false));
    }

    /** @test */
    function auth_service_can_handle_logout()
    {
        $this->statefulGuard->shouldReceive('logout')
            ->times(1)
            ->andReturnNull();

        $this->eventListener->shouldReceive('userHasLoggedOut')
            ->times(1)
            ->andReturn($this->redirectResponse);

        $this->assertInstanceOf(RedirectResponse::class, $this->authService->logout());
    }
}
