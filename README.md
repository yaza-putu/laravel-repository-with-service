# Simple repository pattern for laravel, with services!

With easy repository, you can have the power of the repository pattern, without having to write too much code altogether. The package automatically binds the interfaces to the implementations, all you have to do is change in the configuration which implementation is being used at the moment!

## Requirement

- Minimum PHP ^8.2

## Installation

You can install the package via composer for latest version
```bash
$ composer require yaza/laravel-repository-service
```

Specific Version :

| Laravel Version |  Package Version   |
|:---------------:|:------------------:|
|       11        |        5.x         |
|       10        |        4.0         |
  | 9              | 3.2                |
```bash
# for laravel 10
$ composer require yaza/laravel-repository-service:"^4.0"
# for laravel 9
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

// create service with blank template
php artisan make:service UserService --blank

```

## How to change bind interface to new class implementation
Add this config to AppServiceProvider :
```php
$this->app->extend(Interface::class, function ($service, $app) {
    return new NewImplement($service);
});
```

# Documentation
**Docs for version 5 (comming soon)**

Note : When you create service the default used api template,in api template use setter getter data inside service for how to use you can look in file Service Api (extend) inside service file, if you need blank template when create service, you need add argument --blank, ex : php artisan make:service User --blank.

example setter getter service with api template
```php
// getter (on service called)
$serviceName->getData()
$serviceName->getCode()
$serviceName->getMessage()
$serviceName->getError()
// setter (in service)
$this->setCode()
$this->setData()
$this->setError()
$this->setMessage()
```
More details will be explained in docs version 5.

Go to guide [Click Here](https://yaza-putu.github.io)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
