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
1. Controller <br>
you can call interface of service with automatic injection depedency [read more detail](https://laravel.com/docs/9.x/container#automatic-injection) 
![sample controller](https://res.cloudinary.com/dk0053zbe/image/upload/v1657282450/easy-repository/user-controller_vykrwc.png)
controller only call interface of service not class implement of service
2. Service <br>
sample in interface of service, the interface bind to class implementation
![sample interface service](https://res.cloudinary.com/dk0053zbe/image/upload/v1657282435/easy-repository/user-interface_hicrrc.png)
sample code in class implementation
![sample class implement service](https://res.cloudinary.com/dk0053zbe/image/upload/v1657282457/easy-repository/user-service_dmudfs.png)
class implement service only call interface of repository with automatic injection depedency
, service not recommended direct call method on class implement of repository
3. Repository <br>
sample interface of repository
![sample interface repository](https://res.cloudinary.com/dk0053zbe/image/upload/v1657282449/easy-repository/interface-repository_wqxhp6.png)
sample code implement of repository, implement repository extend with basic CRUD query logic
![sample implement repository](https://res.cloudinary.com/dk0053zbe/image/upload/v1657282450/easy-repository/class-implement_fsa36d.png)

4. implement class of service api
diferent implement service with implement service api only on extend class
![implement class api](https://res.cloudinary.com/dk0053zbe/image/upload/v1657282469/easy-repository/class-service-api_dcxrop.png)

manual make set result data in service
```php
    public function methodName($id)
    {
        try {
            $result = $this->mainRepository->find($id);
            return $this->setResult($result)
                        ->setMessage('message')
                        ->setCode(200)
                        ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
```

5. on your controller need call ->toJson() end of method service to auto generate response json from ServiceApi extends class
```php
public function methodNameOnController() {
    return $this->nameOfService->methodOfService()->toJson();
}

```
output or response with extend ServiceApi, more detail you can read code on ServiceApi
```
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
