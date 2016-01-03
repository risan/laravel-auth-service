<?php

namespace AuthService;

use InvalidArgumentException;
use AuthService\Contracts\AuthServiceConfig as AuthServiceConfigContract;

class AuthServiceConfig implements AuthServiceConfigContract
{
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
     * @param string $loginFailedMessage
     * @param string $afterLoginSuccessPath
     * @param string $afterLogoutSuccessPath
     */
    public function __construct($loginFailedMessage, $afterLoginSuccessPath, $afterLogoutSuccessPath)
    {
        $this->loginFailedMessage = $loginFailedMessage;
        $this->afterLoginSuccessPath = $afterLoginSuccessPath;
        $this->afterLogoutSuccessPath = $afterLogoutSuccessPath;
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
     * @return AuthService\Contracts\AuthServiceConfig
     */
    public static function fromArray(array $config)
    {
        $requiredParams = [
            'login_failed_message',
            'after_login_success_path',
            'after_logout_success_path'
        ];

        foreach ($requiredParams as $param) {
            if (! isset($config[$param])) {
                throw new InvalidArgumentException("Missing auth service configuration: $param.");
            }
        }

        return new static(
            $config['login_failed_message'],
            $config['after_login_success_path'],
            $config['after_logout_success_path']
        );
    }
}
