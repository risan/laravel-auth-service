<?php

namespace AuthService\Contracts;

interface AuthEventListener
{
    /**
     * Get redirector instance.
     *
     * @return Illuminate\Routing\Redirector
     */
    public function redirector();

    /**
     * Get AuthServiceConfig instance.
     *
     * @return AuthService\Contracts\AuthServiceConfig
     */
    public function config();

    /**
     * User has logged in successfully.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function userHasLoggedIn();

    /**
     * User has failed to login.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function userHasFailedToLogIn();

    /**
     * User has logged out successfully.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function userHasLoggedOut();
}
