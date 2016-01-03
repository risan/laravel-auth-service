<?php

namespace AuthService;

use AuthService\Contracts\AuthService as AuthServiceContract;
use Illuminate\Contracts\Auth\StatefulGuard as StatefulGuardContrace;
use AuthService\Contracts\AuthEventListener as AuthEventListenerContract;

class AuthService implements AuthServiceContract
{
    /**
     * Authentication's stateful guard instance.
     *
     * @var Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $statefulGuard;

    /**
     * Authentication's event listener instance.
     *
     * @var AuthService\Contracts\AuthEventListener
     */
    protected $eventListener;

    public function __construct(StatefulGuardContrace $statefulGuard, AuthEventListenerContract $eventListener)
    {
        $this->statefulGuard = $statefulGuard;
        $this->eventListener = $eventListener;
    }

    /**
     * Get authentication's stateful guard instance.
     *
     * @return Illuminate\Contracts\Auth\StatefulGuard
     */
    public function statefulGuard()
    {
        return $this->statefulGuard;
    }

    /**
     * Get authentication's event listener instance.
     *
     * @return AuthService\Contracts\AuthEventListener
     */
    public function eventListener()
    {
        return $this->eventListener;
    }

    /**
     * Log the user in.
     *
     * @param  array   $credentials
     * @param  boolean $remember
     * @return Illuminate\Http\Response
     */
    public function login(array $credentials, $remember = false)
    {
        if (! $this->statefulGuard()->attempt($credentials, $remember)) {
            return $this->eventListener()->userHasFailedToLogIn();
        }

        return $this->eventListener()->userHasLoggedIn();
    }

    /**
     * Log the user out.
     *
     * @return Illuminate\Http\Response
     */
    public function logout()
    {
        $this->statefulGuard()->logout();

        return $this->eventListener()->userHasLoggedOut();
    }
}
