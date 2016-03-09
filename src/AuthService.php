<?php

namespace AuthService;

use AuthService\Contracts\AuthEventListenerInterface;
use AuthService\Contracts\AuthServiceInterface;
use Illuminate\Contracts\Auth\StatefulGuard as StatefulGuardContract;

class AuthService implements AuthServiceInterface
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
     * @var AuthService\Contracts\AuthEventListenerInterface
     */
    protected $eventListener;

    /**
     * Create a new instance of AuthService class.
     *
     * @param Illuminate\Contracts\Auth\StatefulGuard $statefulGuard
     * @param AuthService\Contracts\AuthEventListenerInterface $eventListener
     */
    public function __construct(StatefulGuardContract $statefulGuard, AuthEventListenerInterface $eventListener)
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
     * @return AuthService\Contracts\AuthEventListenerInterface
     */
    public function eventListener()
    {
        return $this->eventListener;
    }

    /**
     * Log the user in.
     *
     * @param  array   $credentials
     * @param  bool $remember
     *
     * @return Illuminate\Http\RedirectResponse
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
     * @return Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $this->statefulGuard()->logout();

        return $this->eventListener()->userHasLoggedOut();
    }
}
