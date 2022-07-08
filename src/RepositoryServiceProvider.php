<?php

namespace LaravelEasyRepository;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use LaravelEasyRepository\helpers\Search;
use SplFileInfo;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * File
     *
     * @property $files
     */
    private Filesystem $files;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->files = $this->app->make(Filesystem::class);
        if ($this->isConfigPublished()) {
            $this->bindAllRepositories();
            $this->bindAllServices();
        } else {
            throw new \Exception("Config esay repository not found");
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Loop through the repository interfaces and bind each interface to its
     * Repository inside the implementations
     *
     * @return void
     */
    private function bindAllRepositories()
    {
        $repositoryInterfaces = $this->getRepositoryPath();

        foreach ($repositoryInterfaces as $key => $repositoryInterface) {
            $repositoryInterfaceClass =  config("easy-repository.repository_namespace"). "\\"
                                        . $repositoryInterface. "\\"
                                        . $repositoryInterface
                                        . config("easy-repository.repository_interface_suffix");

            $repositoryImplementClass = config("easy-repository.repository_namespace"). "\\"
                                        . $repositoryInterface. "\\"
                                        . $repositoryInterface
                                        . config("easy-repository.repository_suffix");

            $this->app->bind($repositoryInterfaceClass, $repositoryImplementClass);
        }

        // call extend repository container
        $this->extendRepositoryBind();
    }

    /**
     * bind all service
     */
    private function bindAllServices() {
        $servicePath = $this->getServicePath();

        foreach ($servicePath as $serviceName) {
            $splitname = explode("/", $serviceName);
            $className = end($splitname);

            $pathService = str_replace("/", "\\", $serviceName);

            $serviceInterfaceClass =  config("easy-repository.service_namespace"). "\\"
                . $pathService. "\\"
                .$className
                .config("easy-repository.service_interface_suffix");

            $serviceImplementClass = config("easy-repository.service_namespace"). "\\"
                . $pathService. "\\"
                .$className
                .config("easy-repository.service_suffix");

            $this->app->bind($serviceInterfaceClass, $serviceImplementClass);
        }
        // call extend service
        $this->extendServiceBind();
    }

    /**
     * Check inside the repositories interfaces directory and get all interfaces
     *
     * @return Collection
     */
    public function getRepository()
    {
        $interfaces = collect([]);
        $directory = $this->getRepositoryPath();
        $files = $this->files->files($directory);
        if (is_array($files)) {
            $interfaces = collect($files)->map(function (SplFileInfo $file) {
                return str_replace(".php", "", $file->getFilename());
            });
        }

        return $interfaces;
    }

    /**
     * Get repositories path
     *
     * @return array
     */
    private function getRepositoryPath()
    {
        $dirs = File::directories($this->app->basePath() .
            "/" . config("easy-repository.repository_directory"));
        $folders = [];

        foreach ($dirs as $dir) {
            $arr = explode("/", $dir);

            $folders[] = end($arr);
        }

        return $folders;
    }

    /**
     * Get repository interface namespace
     *
     * @return string
     */
    private function getRepositoryInterfaceNamespace(string $className)
    {
        return config("easy-repository.repository_namespace") . "\\".$className."\\";
    }

    /**
     * Get repository namespace
     *
     * @return string
     */
    private function getRepositoryNamespace(string $className)
    {
        return config("easy-repository.repository_namespace") .
            "\\" . $className;
    }

    /**
     * Get repository file name
     *
     * @return string
     */
    private function getRepositoryFileName($className)
    {
        return $className . config("easy-repository.repository_suffix");
    }

    /**
     * Get repository names
     *
     * @return Collection
     */
    private function getRepositoryFiles()
    {
        $repositories = collect([]);
        $repositoryDirectory = $this->getRepositoryPath();
        $files = $this->files->files($repositoryDirectory);
        if (is_array($files)) {
            $repositories = collect($files)->map(function (SplFileInfo $file) {
                return str_replace(".php", "", $file->getFilename());
            });
        }

        return $repositories;
    }

    /**
     * get service path
     * @return array
     */
    private function getServicePath() {
        $root = $this->app->basePath() .
            "/" . config("easy-repository.service_directory");

        $path = Search::file($root, ["php"]);

        $servicePath = [];
        foreach ($path as $file) {
            $servicePath[] = str_replace("Services/","",strstr($file->getPath(), "Services"));
        }
        return array_unique($servicePath);
    }

    private function extendServiceBind() {
        $configs = config("easy-repository.extend_bind_services");
        if($this->count($configs) > 0) {
            foreach ($configs as $interface => $implement) {
                $this->app->extend($interface, function ($service, $app) use ($implement){
                    return new $implement($service);
                });
            }
        }
    }

    private function extendRepositoryBind() {
        $configs = config("easy-repository.extend_bind_repositories");
        if($this->count($configs) > 0) {
            foreach ($configs as $interface => $implement) {
                $this->app->extend($interface, function ($service, $app) use ($implement){
                    return new $implement($service);
                });
            }
        }
    }

    /**
     * Check if config is published
     *
     * @return bool
     */
    private function isConfigPublished()
    {
        $path = config_path("easy-repository.php");
        $exists = file_exists($path);

        return $exists;
    }
}
