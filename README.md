# Simple repository pattern for laravel, with services!

With easy repository, you can have the power of the repository pattern, without having to write too much code altogether. The package automatically binds the interfaces to the implementations, all you have to do is change in the configuration which implementation is being used at the moment!

## Requirement

- Laravel 9 need PHP ^8.*
- Laravel 8 need PHP ~7.4||^8.*

## Installation

You can install the package via composer
- For Laravel 9
```bash
$ composer require yaza/laravel-repository-service
```
- For Laravel 8
```bash
$ composer require yaza/laravel-repository-service:^1.5
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

## How it works
This package support for generate Service & Repository pattern with artisan command : <br>
- On service you can write bussines logic <br>
- On Repository you can write a query logic for database

if you use command php artisan make:service or repository, this command will generate 2 file: <br>
- interface 
- implement class

interface auto bind to class implement with container laravel, for detail you can read [read docs bind interface with implement](https://laravel.com/docs/9.x/container#binding-interfaces-to-implementations)
you can call method on interface to access method in class implement.

if you need to change or modification bind interface to new implement class you can add this config to AppServiceProvider :
```php
    $this->app->extend(Interface::class, function ($service, $app) {
        return new NewImplement($service);
    });
```

class implement extend with service or Elequent for handel basic method CRUD like, create, update, delete, findOrFail <br>
you can override basic method crud for re-write code logic


## Example code
1. Repository
2. Service
3. Service Api
```
- output or response like this if service implement extend ServiceApi class
```json
{
    "success": true,
    "code": 200,
    "message": 'Your message',
    "data": [
        {
            "id": 1,
            "name": "tes",
            "email": "sales@scootcruise.com",
            "email_verified_at": null,
            "created_at": null,
            "updated_at": null
        }
    ]
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
