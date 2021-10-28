<?php

namespace LaravelEasyRepository;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LaravelEasyRepository\LaravelEasyRepository
 */
class LaravelEasyRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-easy-repository';
    }
}
