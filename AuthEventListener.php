<?php

namespace AuthService;

use AuthService\Contracts\AuthEventListener as AuthEventListenerContract;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;

class AuthEventListener implements AuthEventListenerContract
{
    /**
     * Response factory instance.
     *
     * @var Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * Create a new instance of AuthEventListener class.
     *
     * @param Illuminate\Contracts\Routing\ResponseFactory $response
     */
    public function __construct(ResponseFactoryContract $response)
    {
        $this->response = $response;
    }

    /**
     * Get response factory instance.
     *
     * @return Illuminate\Contracts\Routing\ResponseFactory
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * User has logged in successfully.
     *
     * @return Illuminate\Http\Response
     */
    public function userHasLoggedIn()
    {
        return $this->response()->redirectTo('protected');
    }

    /**
     * User has failed to login.
     *
     * @return Illuminate\Http\Response
     */
    public function userHasFailedToLogIn()
    {
        return $this->response()->redirectTo('login')
            ->exceptInput('password')
            ->withErrors('Credentials do not match.');
    }

    /**
     * User has logged out successfully.
     *
     * @return Illuminate\Http\Response
     */
    public function userHasLoggedOut()
    {
        return $this->response()->redirectTo('login');
    }
}
