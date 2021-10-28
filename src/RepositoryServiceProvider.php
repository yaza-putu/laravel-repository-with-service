<?php

namespace LaravelEasyRepository;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
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
        $repositoryInterfaces = $this->getRepositoryInterfaces();
        foreach ($repositoryInterfaces as $key => $repositoryInterface) {
            $className = str_replace(config("easy-repository.repository_interface_suffix"), "", $repositoryInterface);
            $repositoryName = $this->getRepositoryFileName($className);
            $repositories = $this->getRepositoryFiles();
            if ($repositories->contains($repositoryName)) {
                $repositoryInterface = $this->getRepositoryInterfaceNamespace() . $repositoryInterface;
                $repository = $this->getRepositoryNamespace() . "\\" . $repositoryName;
                $this->app->bind($repositoryInterface, $repository);
            }
        }
    }

    /**
     * Check inside the repositories interfaces directory and get all interfaces
     *
     * @return Collection
     */
    private function getRepositoryInterfaces()
    {
        $interfaces = collect([]);
        if (! $this->files->isDirectory($directory = $this->getRepositoryInterfacesPath())) {
            return $interfaces;
        }
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
     * @return string
     */
    private function getRepositoryInterfacesPath()
    {
        return $this->app->basePath() .
            "/" . config("easy-repository.repository_directory") .
            "/Interfaces";
    }

    /**
     * Get current repository implementation path
     *
     * @return string
     */
    private function getRepositoryCurrentImplementationPath()
    {
        return $this->app->basePath() .
            "/" . config("easy-repository.repository_directory") .
            "/" . config("easy-repository.current_repository_implementation");
    }

    /**
     * Get repository interface namespace
     *
     * @return string
     */
    private function getRepositoryInterfaceNamespace()
    {
        return config("easy-repository.repository_namespace") . "\Interfaces\\";
    }

    /**
     * Get repository namespace
     *
     * @return string
     */
    private function getRepositoryNamespace()
    {
        return config("easy-repository.repository_namespace") .
            "\\" . config("easy-repository.current_repository_implementation");
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
        if (! $this->files->isDirectory($repositoryDirectory = $this->getRepositoryCurrentImplementationPath())) {
            return $repositories;
        }
        $files = $this->files->files($repositoryDirectory);
        if (is_array($files)) {
            $repositories = collect($files)->map(function (SplFileInfo $file) {
                return str_replace(".php", "", $file->getFilename());
            });
        }

        return $repositories;
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
