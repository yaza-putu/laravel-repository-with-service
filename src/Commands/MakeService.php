<?php

namespace LaravelEasyRepository\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use LaravelEasyRepository\AssistCommand;
use LaravelEasyRepository\CreateFile;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    use AssistCommand;

    public $signature = 'make:service
        {name : The name of the service }
        {--repository : Create a repository along with the service}?
        {--api : Create a service with the api template}?';

    public $description = 'Create a new service class';

    public function handle()
    {
        $name = str_replace(config("easy-repository.service_interface_suffix"), "", $this->argument("name"));
        $className = Str::studly($name);

        $this->checkIfRequiredDirectoriesExist();

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
        $nameOfService = $this->getServiceName($className);
        $serviceName = $nameOfService . config("easy-repository.service_suffix");

        $namespace = $this->getNameSpace($className);
        $stubProperties = [
            "{namespace}" => $namespace,
            "{serviceName}" => $serviceName,
            "{serviceInterface}" => $nameOfService. config("easy-repository.service_interface_suffix"),
            "{repositoryInterfaceName}" => $this->getRepositoryInterfaceName($nameOfService),
            "{repositoryInterfaceNamespace}" => $this->getRepositoryInterfaceNamespace($nameOfService),
        ];
        if($this->needSeparateToClassDirectory()){
        // check folder exist
        $folder = str_replace('\\','/', $namespace);
        if (!file_exists($folder)) {
            File::makeDirectory($folder, 0775, true, true);
        }
        }
        // check command api
        if($this->option("api")) {
            $stubFileName = 'service-api.stub';
        } else {
            $stubFileName = 'service.stub';
        }

        // create file
        new CreateFile(
            $stubProperties,
            $this->getServicePath($className, $nameOfService),
            $stubFileName
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
        $nameOfService = $this->getServiceName($className);
        $serviceName = $nameOfService . config("easy-repository.service_interface_suffix");

        $namespace = $this->getNameSpace($className);
        $stubProperties = [
            "{namespace}" => $namespace,
            "{serviceInterface}" => $serviceName,
        ];

        if($this->needSeparateToClassDirectory()){
            // check folder exist
            $folder = str_replace('\\','/', $namespace);
            if (!file_exists($folder)) {
                File::makeDirectory($folder, 0775, true, true);
            }
        }
        // create file
        new CreateFile(
            $stubProperties,
            $this->getServiceInterfacePath($className,$serviceName),
             'service-interface.stub'
        );
        $this->line("<info>Created $className service interface:</info> {$serviceName}");
    }

    /**
     * Get service path
     *
     * @return string
     */
    private function getServicePath($className, $servicename)
    {
        return $this->appPath() . "/" .
            config("easy-repository.service_directory") .
            $this->getPathPrepend($className). "/$servicename" . config("easy-repository.service_suffix") .".php";
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
            $this->getPathPrepend($className). "/$servicename" .".php";
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
    private function checkIfRequiredDirectoriesExist()
    {
        $this->ensureDirectoryExists(config("easy-repository.service_directory"));
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
        $explode = explode('/', $className);
        if (count($explode) > 1) {
            $namespace = '';
            for($i=0; $i < count($explode)-1; $i++) {
                $namespace .= '\\'.$explode[$i];
            }
            return config("easy-repository.service_namespace").$namespace."\\".end($explode);
        } else {
            return config("easy-repository.service_namespace")."\\".$className;
        }
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
