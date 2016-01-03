<?php

namespace AuthService\Contracts;

interface AuthServiceConfig
{
    /**
     * Get login failed message.
     *
     * @return string
     */
    public function loginFailedMessage();

    /**
     * Get after login success path.
     *
     * @return string
     */
    public function afterLoginSuccessPath();

    /**
     * Get after logout success path.
     *
     * @return string
     */
    public function afterLogoutSuccessPath();

    /**
     * Create an instance of AuthServiceConfig from array.
     *
     * @param  array $config
     * @return AuthService\Contracts\AuthServiceConfig
     */
    public static function fromArray(array $config);
}
