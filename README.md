# Laravel Authentication Service

[![Build Status](https://img.shields.io/travis/risan/laravel-auth-service.svg?style=flat-square)](https://travis-ci.org/risan/laravel-auth-service)
[![HHVM Tested](https://img.shields.io/hhvm/risan/laravel-auth-service.svg?style=flat-square)](https://travis-ci.org/risan/laravel-auth-service)
[![StyleCI](https://styleci.io/repos/48929918/shield?style=flat-square)](https://styleci.io/repos/48929918)
[![Latest Stable Version](https://img.shields.io/packagist/v/risan/laravel-auth-service.svg?style=flat-square)](https://packagist.org/packages/risan/laravel-auth-service)
[![License](https://img.shields.io/packagist/l/risan/laravel-auth-service.svg?style=flat-square)](https://packagist.org/packages/risan/laravel-auth-service)

Stateful authentication service provider for the latest Laravel 5.2 version.

Laravel already offers a handy way to provide user authentication functionality. Laravel framework ships with `AuthenticatesUsers` trait which can be injected to your authentication controller. And actually, by default the provided `AuthController` class are using this handy trait.

This package's intention is to replace the `AuthenticatesUsers` trait from your authentication controller. By extracting the authentication logic into a seperate service provider, your authentication controller will be a lot more clean and readable.

This package is only for the latest Laravel 5.2 version and only supports the `StatefulGuard` implementation.

## Table of Contents

* [Dependencies](#dependencies)
* [Installation](#installation)
  * [Package Installation](#package-installation)
  * [Service Provider Registration](#service-provider-registration)
  * [Facade Registration](#facade-registration)
  * [Publish Configuration File](#publish-configuration-file)
* [Configuration](#configuration)
* [Available Methods](#available-methods)
  * [Login](#login)
  * [Logout](#logout)
* [Basic Usage](#basic-usage)
* [Implementation in AuthController](#implementation-in-authcontroller)
  * [Using Facade](#using-facade)
  * [Without Facade](#without-facade)

## Dependencies

This package relies on the following libraries:

* [Illuminate/Routing](https://github.com/illuminate/routing)
* [Illuminate/Contracts](https://github.com/illuminate/contracts)

## Installation

### Package Installation

To install this library using [Composer](https://getcomposer.org/), simply run the following command inside your Laravel project directory:

```bash
composer require risan/laravel-auth-service
```

Or you may also add `risan/laravel-auth-service` package into your `composer.json` file:

```bash
"require": {
  "risan/laravel-auth-service": "~1.0"
}
```

Once the dependency is added, run the install command:

```bash
composer install
```

### Service Provider Registration

Once the package has been installed, you need to register package's service provider. Open your `config/app.php` file, and add `AuthService\AuthServiceProvider::class` into your `providers` list like so:

```php
'providers' => [
    ...
    AuthService\AuthServiceProvider::class,

],
```

### Facade Registration

If you would like to use facade to access this package, you need to register the `AuthService\Facades\AuthService::class` in `aliases` directive. Open up your `config/app.php` file, and update the `aliases` directive like so:

```php
'aliases' => [
    ...
    'AuthService' => AuthService\Facades\AuthService::class,

],
```

This way, you may access the package functionality using `AuthService` facade.

### Publish Configuration File

The last step to setup this package is to publish the configuration file. On your command prompt, run the following artisan command:

```php
php artisan vendor:publish --provider="AuthService\AuthServiceProvider"
```

This command will copy a default package's configuration file in `config/authservice.php`.

## Configuration

Once the package's configuration file is published, you may locate the file in `config\authservice.php`. The default configuration file will look like this:

```php
return [
    'auth_event_listener_class' => AuthService\AuthEventListener::class,
    'login_failed_message' => 'Credentials do not match.',
    'after_login_success_path' => 'protected',
    'after_logout_success_path' => 'login'
];
```

* **auth_event_listener_class**

  This configuration tells the service provider which authentication event listener class to use. By default it will use the provided `AuthService\AuthEventListener` class. However you may also override it with your own event listener implementation as long as it confronts the `AuthService\Contracts\AuthEventListener` interface.

* **login_failed_message**

  This is the error message that will be used when user's credentials is invalid. By default this error message will be flashed out to the session if login is failed.

* **after_login_success_path**

  This is the path where user will be redirected to if he/she successfully logged in.

* **after_logout_success_path**

  This is the path where user will be redirected to if he/she logged out from application.

## Available Methods

### Login

To log the user in, simply call the `login()` method:

```php
AuthService::login(array $credentials, $remember = false);
```

This method will attempt to log the user in and will return an instance of `Illuminate\Http\RedirectResponse`.

### Logout

To log the user out, we may use the `logout()` method:

```php
AuthService::logout();
```

This method will also return an instance of `Illuminate\Http\RedirectResponse`.

## Basic Usage

Here is some basic example to perform login and logout functionality, assuming that we are using the facade.

```php
use AuthService;

// Log the user in.
$credentials = ['email' => 'john@example.com', 'password' => 'secret'];
AuthService::login($credentials);

// Log the user out.
AuthService::logout();
```

## Implementation in AuthController

For a complete implementation, we will create a simple authentication controller that handles the login and logout request.

### Using Facade

```php
namespace App\Http\Controllers\Auth;

use AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Show the login page.
     *
     * @return Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     *
     * @param  App\Http\Requests\Auth\LoginRequest $request
     * @return Illuminate\Http\Response
     */
    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        return AuthService::login($credentials, $request->has('remember'));
    }

    /**
     * Log the user out.
     *
     * @return Illuminate\Http\Response
     */
    public function getLogout()
    {
        return AuthService::logout();
    }
}
```

### Without Facade

```php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use AuthService\Contracts\AuthService as AuthServiceContract;

class AuthController extends Controller
{
    protected $authService;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(AuthServiceContract $authService)
    {
        $this->middleware('guest', ['except' => 'getLogout']);

        $this->authService = $authService;
    }

    /**
     * Show the login page.
     *
     * @return Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     *
     * @param  App\Http\Requests\Auth\LoginRequest $request
     * @return Illuminate\Http\Response
     */
    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        return $this->authService->login($credentials, $request->has('remember'));
    }

    /**
     * Log the user out.
     *
     * @return Illuminate\Http\Response
     */
    public function getLogout()
    {
        return $this->authService->logout();
    }
}
```
