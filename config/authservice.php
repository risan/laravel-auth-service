<?php

return [
    /**
     * Authentication event listener class.
     *
     * This is an event listener class that will be used by the
     * authentication service to firing up various authentication
     * event. Must implements AuthService\Contracts\AuthEventListener.
     */
    'auth_event_listener_class' => AuthService\AuthEventListener::class,

    /**
     * Login failed message.
     *
     * This is an error message that will be flashed out to the session
     * if user credentials are invalid.
     */
    'login_failed_message' => 'Credentials do not match.',

    /**
     * After login success path.
     *
     * This the default path where user will be redirected once he/she
     * successfully logged in.
     */
    'after_login_success_path' => 'protected',

     /**
     * After logout success path.
     *
     * This the path where user will be redirected once he/she logged out.
     */
    'after_logout_success_path' => 'login'
];
