<?php

use Mockery as m;
use AuthService\AuthEventListener;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use AuthService\Contracts\AuthServiceConfigInterface;

class AuthEventListenerTest extends PHPUnit_Framework_TestCase {
    protected $redirector;
    protected $config;
    protected $redirectResponse;
    protected $eventListener;

    function setUp()
    {
        $this->redirector = m::mock(Redirector::class);
        $this->config = m::mock(AuthServiceConfigInterface::class);
        $this->redirectResponse = m::mock(RedirectResponse::class);
        $this->eventListener = new AuthEventListener($this->redirector, $this->config);
    }

    function tearDown()
    {
        m::close();
    }

    /** @test */
    function auth_event_listener_has_redirector()
    {
        $this->assertInstanceOf(Redirector::class, $this->eventListener->redirector());
    }

    /** @test */
    function auth_event_listener_has_config()
    {
        $this->assertInstanceOf(AuthServiceConfigInterface::class, $this->eventListener->config());
    }

    /** @test */
    function auth_event_listener_can_handle_successfull_login()
    {
        $this->redirector->shouldReceive('intended')
            ->times(1)
            ->andReturn($this->redirectResponse);

        $this->config->shouldReceive('afterLoginSuccessPath')
            ->times(1);

        $this->assertInstanceOf(RedirectResponse::class, $this->eventListener->userHasLoggedIn());
    }

    /** @test */
    function auth_event_listener_can_handle_failed_login()
    {
        $this->redirector->shouldReceive('back')
            ->times(1)
            ->andReturn($this->redirectResponse);

        $this->redirectResponse->shouldReceive('exceptInput', 'withErrors')
            ->times(1)
            ->andReturn($this->redirectResponse);

        $this->config->shouldReceive('loginFailedMessage')
            ->times(1);

        $this->assertInstanceOf(RedirectResponse::class, $this->eventListener->userHasFailedToLogIn());
    }

    /** @test */
    function auth_event_listener_can_handle_successfull_logout()
    {
        $this->redirector->shouldReceive('to')
            ->times(1)
            ->andReturn($this->redirectResponse);

        $this->config->shouldReceive('afterLogoutSuccessPath')
            ->times(1);

        $this->assertInstanceOf(RedirectResponse::class, $this->eventListener->userHasLoggedOut());
    }
}
