<?php

namespace LaravelEasyRepository;

use LaravelEasyRepository\Commands\MakeRepository;
use LaravelEasyRepository\Commands\MakeService;
use LaravelEasyRepository\Commands\ModelMakeCommand;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Support\Facades\File;

class LaravelEasyRepositoryServiceProvider extends PackageServiceProvider
{
    public function register()
    {
        $this->registeringPackage();

        $this->package = new Package();

        $this->package->setBasePath($this->getPackageBaseDir());

        $this->configurePackage($this->package);

        if (empty($this->package->name)) {
            throw InvalidPackage::nameIsRequired();
        }

        $this->configureCustomStubs();

        foreach ($this->package->configFileNames as $configFileName) {
            $this->mergeConfigFrom($this->package->basePath("/../config/{$configFileName}.php"), $configFileName);
        }

        $this->mergeConfigFrom(__DIR__ . "/../config/easy-repository-sys.php", "easy-repository");

        $this->packageRegistered();

        $this->overrideCommands();

        return $this;
    }

    public function configureCustomStubs(): void
    {
        $soruceStubDirectory=__DIR__.DIRECTORY_SEPARATOR.'Commands'.DIRECTORY_SEPARATOR.'stubs';
        $destinatonStubDirectory=base_path('stubs'.DIRECTORY_SEPARATOR.$this->package->name);
        $files=File::files($soruceStubDirectory);
        foreach ($files as $file){
            $this->publishes([
                $soruceStubDirectory.DIRECTORY_SEPARATOR.$file->getRelativePathname()=> $destinatonStubDirectory.DIRECTORY_SEPARATOR.$file->getRelativePathname()
            ], 'stubs');
        }
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-easy-repository')
            ->hasConfigFile()
            ->hasCommand(MakeRepository::class)
            ->hasCommand(MakeService::class);
    }

    public function overrideCommands()
    {
        $this->app->extend('command.model.make', function () {
            return app()->make(ModelMakeCommand::class);
        });
    }
}
