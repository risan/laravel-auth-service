# Laravel Authentication Service

[![Build Status](https://img.shields.io/travis/risan/laravel-auth-service.svg?style=flat-square)](https://travis-ci.org/risan/laravel-auth-service)
[![HHVM Tested](https://img.shields.io/hhvm/risan/laravel-auth-service.svg?style=flat-square)](https://travis-ci.org/risan/laravel-auth-service)
[![Latest Stable Version](https://img.shields.io/packagist/v/risan/laravel-auth-service.svg?style=flat-square)](https://packagist.org/packages/risan/laravel-auth-service)
[![License](https://img.shields.io/packagist/l/risan/laravel-auth-service.svg?style=flat-square)](https://packagist.org/packages/risan/laravel-auth-service)

Stateful authentication service provider for the latest Laravel 5.2 version.

Laravel already offers a handy way to provide user authentication functionality. Laravel framework ships with `AuthenticatesUsers` trait which can be injected to your authentication controller. And actually, by default the provided `AuthController` class are using this handy trait.

This package's intention is to replace the `AuthenticatesUsers` trait from your authentication controller. By extracting the authentication logic into a seperate service provider, your authentication controller will be a lot more clean and readable.

This package is only for the latest Laravel 5.2 version and only support the `StatefulGuard` implementation.

## Table of Contents

* [Dependencies](#dependencies)
* [Installation](#installation)
  * [Package Installation](#package-installation)
  * [Service Provider Registration](#service-provider-registration)
  * [Facade Registration](#facade-registration)
  * [Publish Configuration File](#publish-configuration-file)
* [Configuration](#configuration)

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

With this way, you can access this package using `AuthService` facade.

### Publish Configuration File

The last step to setup this package is to publish the configuration file. On your command prompt, run the following artisan command:

```php
php artisan vendor:publish --provider="AuthService\AuthServiceProvider"
```

This command will copy a default package's configuration file in `config/authservice.php`.
