# Simple repository pattern for laravel, with services!

With easy repository, you can have the power of the repository pattern, without having to write too much code altogether. The package automatically binds the interfaces to the implementations, all you have to do is change in the configuration which implementation is being used at the moment!

## Requirement

- Minimum PHP ^8.1

## Installation

You can install the package via composer for latest version
```bash
$ composer require yaza/laravel-repository-service
```

Specific Version :

| Laravel Version |  Package Version   |
|:---------------:|:------------------:|
|       10        |        4.x         |
  | 9              | 3.2                |
```bash
$ composer require yaza/laravel-repository-service:"^3.2"
```

Publish the config file with (Important):

```bash
php artisan vendor:publish --provider="LaravelEasyRepository\LaravelEasyRepositoryServiceProvider" --tag="easy-repository-config"
```

## Quick usage

You can also create only the repository, or service, or both with artisan:

```bash
php artisan make:repository User
// or
php artisan make:repository UserRepository

// or create together with a service
php artisan make:repository User --service
// or
php artisan make:repository UserRepository --service

// or create a service separately
php artisan make:service User
// or
php artisan make:service UserService
// or
php artisan make:service UserService --repository

// create service for api template
php artisan make:service UserService --api

```

## How to change bind interface to new class implementation
Add this config to AppServiceProvider :
```php
$this->app->extend(Interface::class, function ($service, $app) {
    return new NewImplement($service);
});
```

# Documentation
Go to guide [Click Here](https://yaza-putu.github.io)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
