<?php

namespace LaravelEasyRepository\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelEasyRepository\LaravelEasyRepositoryServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'LaravelEasyRepository\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelEasyRepositoryServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        include_once __DIR__.'/../database/migrations/create_laravel-easy-repository_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
