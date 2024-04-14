<?php

namespace LaravelEasyRepository\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use LaravelEasyRepository\AssistCommand;
use LaravelEasyRepository\CreateFile;
use File;

class MakeService extends Command
{
    use AssistCommand;

    public $signature = 'make:service
        {name : The name of the service }
        {--repository : Create a repository along with the service}?
        {--blank : Create a service with blank template}?';

    public $description = 'Create a new service class';

    public function handle()
    {
        $name = str_replace(config("easy-repository.service_interface_suffix"), "", $this->argument("name"));
        $className = Str::studly($name);

        $this->checkIfRequiredDirectoriesExist($className);

        $this->createServiceInterface($className);

        $this->createService($className);

        if ($this->option('repository')) {
            $this->createRepository();
        }
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

        $namespace = $this->getNameSpace($className);
        $stubProperties = [
            "{namespace}" => $namespace,
            "{serviceName}" => $serviceName,
            "{serviceInterface}" => $className. config("easy-repository.service_interface_suffix"),
            "{repositoryInterfaceName}" => $this->getRepositoryInterfaceName($className),
            "{repositoryInterfaceNamespace}" => $this->getRepositoryInterfaceNamespace($className),
        ];
        // check file exist
        $filePath = $this->getServicePath($className);
        if (file_exists($filePath)) {
            $this->error("file $className service already exist");
            return ;
        }

        // check command blank
        if($this->option("blank")) {
            $stubPath = __DIR__ . "/stubs/service.stub";
        } else {
            $stubPath = __DIR__ . "/stubs/service-api.stub";
        }

        // create file
        new CreateFile(
            $stubProperties,
            $filePath,
            $stubPath
        );
        $this->line("<info>Created $className service implement:</info> {$serviceName}");
    }

    /**
     * Create the service interface
     *
     * @param string $className
     * @return void
     */
    public function createServiceInterface(string $className)
    {
        $serviceName = $className . config("easy-repository.service_interface_suffix");

        $namespace = $this->getNameSpace($className);
        $stubProperties = [
            "{namespace}" => $namespace,
            "{serviceInterface}" => $serviceName,
        ];
        // check folder exist
        $interfacePath = $this->getServiceInterfacePath($className,$serviceName);
        if (file_exists($interfacePath)) {
            $this->error("file $className service interface already exist");
            return ;
        }
        // create file
        new CreateFile(
            $stubProperties,
            $interfacePath,
            __DIR__ . "/stubs/service-interface.stub"
        );
        $this->line("<info>Created $className service interface:</info> {$serviceName}");
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
            "/$className". "/$className" . config("easy-repository.service_suffix") .".php";
    }

    /**
     * Get service interface path
     *
     * @return string
     */
    private function getServiceInterfacePath($className, $servicename)
    {
        return $this->appPath() . "/" .
            config("easy-repository.service_directory") .
            "/$className". "/$servicename" .".php";
    }

    /**
     * Get repository interface namespace
     *
     * @return string
     */
    private function getRepositoryInterfaceNamespace(string $className)
    {
        return config("easy-repository.repository_namespace") . "\\".$className;
    }

    /**
     * Get repository interface namespace
     *
     * @return string
     */
    private function getRepositoryNamespace(string $className)
    {
        return config("easy-repository.repository_namespace") . "\Eloquent";
    }

    /**
     * Get repository interface name
     *
     * @return string
     */
    private function getRepositoryInterfaceName(string $className)
    {
        return $className . config("easy-repository.repository_interface_suffix");
    }

    /**
     * get repository name
     * @param string $className
     * @return string
     */
    private function getRepositoryName(string $className) {
        return $className. config("easy-repository.repository_suffix");
    }

    /**
     * Check to make sure if all required directories are available
     *
     * @return void
     */
    private function checkIfRequiredDirectoriesExist(string $className)
    {
        $this->ensureDirectoryExists(config("easy-repository.service_directory"));
        $this->ensureDirectoryExists(config("easy-repository.service_directory"). "/". $className);
    }

    /**
     * get service name
     * @param $className
     * @return string
     */
    private function getServiceName($className):string {
        $explode = explode('/', $className);
        return $explode[array_key_last($explode)];
    }

    /**
     * get namespace
     * @param $className
     * @return string
     */
    private function getNameSpace($className):string {
        return config("easy-repository.service_namespace")."\\".$className;
    }

    /**
     * Create repository for the service
     *
     * @return void
     */
    private function createRepository()
    {
        $name = str_replace(config("easy-repository.service_interface_suffix"), "", $this->argument("name"));
        $name = Str::studly($name);

        $this->call("make:repository", [
            "name" => $name,
        ]);
    }
}
