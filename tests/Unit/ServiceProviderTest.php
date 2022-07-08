<?php


namespace LaravelEasyRepository\Tests\Unit;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use LaravelEasyRepository\Tests\TestCase;
use LaravelEasyRepository\helpers\Search;
use SplFileInfo;

/**
 * @group serviceprovider
 * Class ServiceProviderTest
 * @package LaravelEasyRepository\Tests\Unit
 */
class ServiceProviderTest extends TestCase
{

    private Filesystem $files;
    public function setUp(): void
    {
        parent::setUp();
        $this->files = $this->app->make(Filesystem::class);
    }

    /**
     * test schema bind service
     * @group bindrepo
     */
    public function test_schema_bind_repository()
    {
            $dirs = File::directories($this->app->basePath() .
                "/" . config("easy-repository.repository_directory"));
            $folders = [];
            foreach ($dirs as $dir) {
                $arr = explode("/", $dir);

                $folders[] = end($arr);
            }

        $repositoryInterfaces = $folders;

        $repositoryServiceProvider = [];
        foreach ($repositoryInterfaces as $key => $repositoryInterface) {
            $repositoryInterfaceClass =  config("easy-repository.repository_namespace"). "\\"
                                                . $repositoryInterface. "\\"
                                                .$repositoryInterface
                                                .config("easy-repository.repository_interface_suffix");

            $repositoryImplementClass = config("easy-repository.repository_namespace"). "\\"
                                                . $repositoryInterface. "\\"
                                                .$repositoryInterface
                                                .config("easy-repository.repository_suffix");

            $repositoryServiceProvider[] = [$repositoryInterfaceClass, $repositoryImplementClass];
        }
            $this->assertArrayHasKey(0, $repositoryServiceProvider);
    }

    /**
     * test schema bind service
     * @group binservice
     */
    public function test_schema_bind_service()
    {
        $dirs = File::directories($this->app->basePath() .
            "/" . config("easy-repository.service_directory"));
        $folders = [];
        foreach ($dirs as $dir) {
            $arr = explode("/", $dir);
            $folders[] = end($arr);
        }

        $root = $this->app->basePath() .
            "/" . config("easy-repository.service_directory");

        $path = Search::file($root, ["php"]);

        $servicePath = [];
        foreach ($path as $file) {
            $servicePath[] = str_replace("Services/","",strstr($file->getPath(), "Services"));
        }

        $servicePath = array_unique($servicePath);

        $serviceProvider = [];

        foreach ($servicePath as $serviceName) {
            $splitname = explode("/", $serviceName);
            $className = end($splitname);

            $pathService = str_replace("/", "\\", $serviceName);

            $serviceInterfaceClass =  config("easy-repository.service_namespace"). "\\"
                . $pathService. "\\"
                .$className
                .config("easy-repository.service_interface_suffix");

            $serviceImplementClass = config("easy-repository.repository_namespace"). "\\"
                . $pathService. "\\"
                .$className
                .config("easy-repository.service_suffix");

            $serviceProvider[] = [$serviceInterfaceClass, $serviceImplementClass];
        }


        $this->assertArrayHasKey(0, $serviceProvider);
    }
}
