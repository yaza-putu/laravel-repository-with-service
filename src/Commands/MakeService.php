<?php

namespace LaravelEasyRepository\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use LaravelEasyRepository\AssistCommand;
use LaravelEasyRepository\CreateFile;

class MakeService extends Command
{
    use AssistCommand;

    public $signature = 'make:service
        {name : The name of the service }';

    public $description = 'Create a new service class';

    public function handle()
    {
        $name = str_replace(config("easy-repository.service_suffix"), "", $this->argument("name"));
        $className = Str::studly($name);

        $this->checkIfRequiredDirectoriesExist();

        $this->createService($className);
    }

    /**
     * Create the service
     *
     * @param string $className
     * @return void
     */
    public function createService(string $className)
    {
        $serviceName = $className . config("easy-repository.service_suffix");
        $stubProperties = [
            "{namespace}" => config("easy-repository.service_namespace"),
            "{serviceName}" => $serviceName,
            "{repositoryInterface}" => $this->getRepositoryInterfaceName($className),
            "{repositoryInterfaceNamespace}" => $this->getRepositoryInterfaceNamespace($className),
        ];

        new CreateFile(
            $stubProperties,
            $this->getServicePath($className),
            __DIR__ . "/stubs/service.stub"
        );


        $this->line("<info>Created service:</info> {$serviceName}");
    }

    /**
     * Get service path
     *
     * @return string
     */
    private function getServicePath($className)
    {
        return $this->appPath() . "/" .
            config("easy-repository.service_directory") .
            "/$className" . "Service.php";
    }

    /**
     * Get repository interface namespace
     *
     * @return string
     */
    private function getRepositoryInterfaceNamespace(string $className)
    {
        return config("easy-repository.repository_namespace") . "\Interfaces";
    }

    /**
     * Get repository interface name
     *
     * @return string
     */
    private function getRepositoryInterfaceName(string $className)
    {
        return $className . "RepositoryInterface";
    }

    /**
     * Check to make sure if all required directories are available
     *
     * @return void
     */
    private function checkIfRequiredDirectoriesExist()
    {
        $this->ensureDirectoryExists(config("easy-repository.service_directory"));
    }
}
