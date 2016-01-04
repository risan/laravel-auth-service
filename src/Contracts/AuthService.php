<?php

namespace AuthService\Contracts;

interface AuthService
{
    /**
     * Get authentication's stateful guard instance.
     *
     * @return Illuminate\Contracts\Auth\StatefulGuard
     */
    public function statefulGuard();

    /**
     * Get authentication's event listener instance.
     *
     * @return AuthService\Contracts\AuthEventListener
     */
    public function eventListener();

    /**
     * Log the user in.
     *
     * @param  array   $credentials
     * @param  bool $remember
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function login(array $credentials, $remember = false);

    /**
     * Log the user out.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function logout();
}
