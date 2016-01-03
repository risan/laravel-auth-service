<?php

namespace AuthService;

use Illuminate\Routing\Redirector;
use AuthService\Contracts\AuthServiceConfig;
use AuthService\Contracts\AuthEventListener as AuthEventListenerContract;

class AuthEventListener implements AuthEventListenerContract
{
    /**
     * Redirector instance.
     *
     * @var Illuminate\Routing\Redirector
     */
    protected $redirector;

    /**
     * AuthServiceConfig instance.
     *
     * @var AuthService\Contracts\AuthServiceConfig
     */
    protected $config;

    /**
     * Create a new instance of AuthEventListener class.
     *
     * @param Illuminate\Routing\Redirector $redirector
     * @param array $config
     */
    public function __construct(Redirector $redirector, array $config)
    {
        $this->redirector = $redirector;
        $this->config = AuthServiceConfig::fromArray($config);
    }

    /**
     * Get redirector instance.
     *
     * @return Illuminate\Routing\Redirector
     */
    public function redirector()
    {
        return $this->redirector;
    }

    /**
     * Get AuthServiceConfig instance.
     *
     * @return AuthService\Contracts\AuthServiceConfig
     */
    public function config()
    {
        return $this->config;
    }

    /**
     * User has logged in successfully.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function userHasLoggedIn()
    {
        return $this->redirector()
            ->intended($this->config()->afterLoginSuccessPath());
    }

    /**
     * User has failed to login.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function userHasFailedToLogIn()
    {
        return $this->redirector()
            ->back()
            ->exceptInput('password')
            ->withErrors([$this->config()->loginFailedMessage()]);
    }

    /**
     * User has logged out successfully.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function userHasLoggedOut()
    {
        return $this->redirector()
            ->to($this->config()->afterLogoutSuccessPath());
    }
}
