<?php

use AuthService\AuthServiceConfig;

class AuthServiceConfigTest extends PHPUnit_Framework_TestCase {
    protected $config;

    function setUp()
    {
        $this->config = new AuthServiceConfig(
            'FooEventListener',
            'foo',
            'bar',
            'baz'
        );
    }

    /** @test */
    function auth_service_config_has_auth_event_listener_class()
    {
        $this->assertEquals('FooEventListener', $this->config->authEventListenerClass());
    }

    /** @test */
    function auth_service_config_has_login_failed_message()
    {
        $this->assertEquals('foo', $this->config->loginFailedMessage());
    }

    /** @test */
    function auth_service_config_has_after_login_success_path()
    {
        $this->assertEquals('bar', $this->config->afterLoginSuccessPath());
    }

    /** @test */
    function auth_service_config_has_after_logout_success_path()
    {
        $this->assertEquals('baz', $this->config->afterLogoutSuccessPath());
    }

    /** @test */
    function auth_service_config_can_be_instantiated_from_array()
    {
        $params = [
            'auth_event_listener_class' => 'FooEventListener',
            'login_failed_message' => 'foo',
            'after_login_success_path' => 'bar',
            'after_logout_success_path' => 'baz'
        ];

        $config = AuthServiceConfig::fromArray($params);

        $this->assertInstanceOf(AuthServiceConfig::class, $config);
        $this->assertEquals('FooEventListener', $config->authEventListenerClass());
        $this->assertEquals('foo', $config->loginFailedMessage());
        $this->assertEquals('bar', $config->afterLoginSuccessPath());
        $this->assertEquals('baz', $config->afterLogoutSuccessPath());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    function auth_service_config_without_auth_event_listener_class_throws_exception()
    {
        AuthServiceConfig::fromArray([
            'login_failed_message' => 'foo',
            'after_login_success_path' => 'bar',
            'after_logout_success_path' => 'baz'
        ]);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    function auth_service_config_without_login_failed_message_throws_exception()
    {
        AuthServiceConfig::fromArray([
            'auth_event_listener_class' => 'FooEventListener',
            'after_login_success_path' => 'bar',
            'after_logout_success_path' => 'baz'
        ]);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    function auth_service_config_without_after_login_success_path_throws_exception()
    {
        AuthServiceConfig::fromArray([
            'auth_event_listener_class' => 'FooEventListener',
            'login_failed_message' => 'foo',
            'after_logout_success_path' => 'baz'
        ]);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    function auth_service_config_without_after_logout_success_path_throws_exception()
    {
        AuthServiceConfig::fromArray([
            'auth_event_listener_class' => 'FooEventListener',
            'login_failed_message' => 'foo',
            'after_login_success_path' => 'bar'
        ]);
    }
}
