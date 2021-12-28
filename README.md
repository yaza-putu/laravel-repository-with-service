# Simple repository pattern for laravel, with services!

With easy repository, you can have the power of the repository pattern, without having to write too much code altogether. The package automatically binds the interfaces to the implementations, all you have to do is change in the configuration which implementation is being used at the moment!

## Requirement

- Laravel 8
- PHP 7.4||8.*

## Installation

You can install the package via composer:

```bash
$ composer require yaza/laravel-repository-service
```

Publish the config file with (Important):

```bash
php artisan vendor:publish --provider="LaravelEasyRepository\LaravelEasyRepositoryServiceProvider" --tag="easy-repository-config"
```

The configurations in the config file are standard, and can be extended with/depending on further requirements. No need to change any of the contents, unless you are very aware of what you are doing :)
This is the contents of the published config file:

```php

return [
    /**
     * The directory for all the repositories
     */
    "repository_directory" => "app/Repositories",

    /**
     * Default repository namespace
     */
    "repository_namespace" => "App\Repositories",

    /**
     * The directory for all the services
     */
    "service_directory" => "app/Services",

    /**
     * Default service namespace
     */
    "service_namespace" => "App\Services",

    /**
     * Default repository implementation
     */
    "default_repository_implementation" => "Eloquent",

    /**
     * Current repository implementation
     */
    "current_repository_implementation" => "Eloquent",
];

```

## Quick usage

This package overrides the default laravel `php artisan make:model User` command, and adds a few flags that can help you set up repository and service quickly.

```bash
// will genearate controller, factory, service, seeder, repository, resource and migration
php artisan make:model User --all

// use the service and repository flag to generate the class
php artisan make:model User --service --repository

// use the short form to generate model with service and repository
php artisan make:model User -sr -rt
```

You can also create only the repository, or service, or both:

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

```

The `php artisan make:repository User` will generate two files. One for the interface, and one for the repository class. The interface is bound to it's counter part class automatically depending on the current implementation being used. If the implementation for an interface is not provided, you can provide one manually or otherwise, attempting to use the service will bring up an error.

Eloquent is the default implementation. Other implementations will be added in the future. This is because the package was mainly to simplify usage of the repository pattern in laravel. The classes created are:

```php
// app/Repositories/Interfaces/UserRepository.php

<?php

namespace App\Repositories\Interfaces;

use LaravelEasyRepository\Repository;

class UserRepositoryInterface extends Repository{

    // Write something awesome :)
}

```

and,

```php
// app/Repositories/Eloquent/UserRepository.php

<?php

namespace App\Repositories\Eloquent;

use LaravelEasyRepository\Repository;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends Eloquent implements UserRepositoryInterface{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change variable $model or $this->model
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}

```

also if you included the services flag, or created one by running a command, the service file generated, the service only call interfaces and automatically bind to repository.

```php
// app/Services/UserService

<?php

namespace App\Services;

use {repositoryInterfaceNamespace}\{repositoryInterface};
class UserService {

   /**
   * don't change $this->mainRepository variable name
   * because used in service class
   */
   protected $mainRepository;

  public function __construct({repositoryInterface} $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

   // Define your custom methods :)
}

```
In your controller you can use like

```php
<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(UserService $mainService)
    {
        $this->mainService = $mainService;
    }
    
    public function all () {
      return $this->mainService->all();
    }

}

```

The repository and service also comes in built with 5 common CRUD methods

```php

interface Repository
{
    /**
     * Fin an item by id
     * @param int $id
     * @return Model|null
     */
    public function find(int $id);

    /**
     * Find or fail an item by id
     * @param int $id
     * @return Model|null
     */
    public function findOrFail(int $id);

    /**
     * Return all items
     * @return Collection|null
     */
    public function all();

    /**
     * Return query builder instance to perform more manouvers
     * @return Builder|null
     */
    public function query();

    /**
     * Create an item
     * @param array|mixed $data
     * @return Model|null
     */
    public function create($data);

    /**
     * Update a model
     * @param int|mixed $id
     * @param array|mixed $data
     * @return bool|mixed
     */
    public function update($id, array $data);

    /**
     * Delete a model
     * @param int|Model $id
     */
    public function delete($id);

    /**
     * multiple delete
     * @param array $id
     * @return mixed
     */
    public function destroy(array $id);

}

```

## Addons for build rest api with Response, Result Service like
- in service
```php
<?php

namespace App\Services;

use LaravelEasyRepository\Traits\ResultService;
use {repositoryInterfaceNamespace}\{repositoryInterface};

class UserService {
 use ResultService;

  /**
    * don't change $this->mainRepository variable name
    * because used in service class
    */
    protected $mainRepository;

   public function __construct({repositoryInterface} $mainRepository)
   {
     $this->mainRepository = $mainRepository;
   }

    // Define your custom methods :)
    
    public function all () {
        try {
            $result = $this->mainRepository->all();
            return $this->setStatus(true)
                        ->setResult($result)
                        ->setCode(200)
                        ->setMessage('your message');
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }            
    }    
}
```
- in controller
```php
<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use LaravelEasyRepository\Traits\Response;

class UserController extends Controller
{
   use Response;
    public function __construct(UserService $mainService)
    {
        $this->mainService = $mainService;
    }
    
    public function all () {
      $result = $this->mainService->all();
      return $result->toJson();
    }

}
```
- output or response like
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
