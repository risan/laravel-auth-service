<?php

namespace AuthService;

use AuthService\Contracts\AuthServiceConfig as AuthServiceConfigContract;
use InvalidArgumentException;

class AuthServiceConfig implements AuthServiceConfigContract
{
    /**
     * Authentication event listener class.
     *
     * @var string
     */
    protected $authEventListenerClass;

    /**
     * Login failed message.
     *
     * @var string
     */
    protected $loginFailedMessage;

    /**
     * After login success path.
     *
     * @var string
     */
    protected $afterLoginSuccessPath;

    /**
     * After logout success path.
     *
     * @var string
     */
    protected $afterLogoutSuccessPath;

    /**
     * Create a new instance of AuthServiceConfig class.
     *
     * @param string $authEventListenerClass
     * @param string $loginFailedMessage
     * @param string $afterLoginSuccessPath
     * @param string $afterLogoutSuccessPath
     */
    public function __construct($authEventListenerClass, $loginFailedMessage, $afterLoginSuccessPath, $afterLogoutSuccessPath)
    {
        $this->authEventListenerClass = $authEventListenerClass;
        $this->loginFailedMessage = $loginFailedMessage;
        $this->afterLoginSuccessPath = $afterLoginSuccessPath;
        $this->afterLogoutSuccessPath = $afterLogoutSuccessPath;
    }

    /**
     * Get authentication event listener class.
     *
     * @return string
     */
    public function authEventListenerClass()
    {
        return $this->authEventListenerClass;
    }

    /**
     * Get login failed message.
     *
     * @return string
     */
    public function loginFailedMessage()
    {
        return $this->loginFailedMessage;
    }

    /**
     * Get after login success path.
     *
     * @return string
     */
    public function afterLoginSuccessPath()
    {
        return $this->afterLoginSuccessPath;
    }

    /**
     * Get after logout success path.
     *
     * @return string
     */
    public function afterLogoutSuccessPath()
    {
        return $this->afterLogoutSuccessPath;
    }

    /**
     * Create an instance of AuthServiceConfig from array.
     *
     * @param  array $config
     *
     * @return AuthService\Contracts\AuthServiceConfig
     */
    public static function fromArray(array $config)
    {
        $requiredParams = [
            'auth_event_listener_class',
            'login_failed_message',
            'after_login_success_path',
            'after_logout_success_path',
        ];

        foreach ($requiredParams as $param) {
            if (!isset($config[$param])) {
                throw new InvalidArgumentException("Missing auth service configuration: $param.");
            }
        }

        return new static(
            $config['auth_event_listener_class'],
            $config['login_failed_message'],
            $config['after_login_success_path'],
            $config['after_logout_success_path']
        );
    }
}
