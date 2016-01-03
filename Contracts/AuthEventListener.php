<?php

namespace AuthService\Contracts;

interface AuthEventListener
{
    /**
     * Get response factory instance.
     *
     * @return Illuminate\Contracts\Routing\ResponseFactory
     */
    public function response();

    /**
     * User has logged in successfully.
     *
     * @return Illuminate\Http\Response
     */
    public function userHasLoggedIn();

    /**
     * User has failed to login.
     *
     * @return Illuminate\Http\Response
     */
    public function userHasFailedToLogIn();

    /**
     * User has logged out successfully.
     *
     * @return Illuminate\Http\Response
     */
    public function userHasLoggedOut();
}
