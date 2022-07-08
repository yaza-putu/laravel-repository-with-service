<?php


namespace LaravelEasyRepository\Tests\Unit;

use Illuminate\Support\Str;
use LaravelEasyRepository\Commands\MakeService;
use LaravelEasyRepository\Tests\TestCase;

/**
 * @group unit
 * Class ServiceTest
 * @package LaravelEasyRepository\Tests\Unit
 */
class ServiceTest extends TestCase
{
    private $surfix, $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->surfix = "User";
        $this->service = new MakeService();
    }



    public function test_create_service_interface()
    {
        $response = $this->service->createServiceInterface($this->surfix);
    }

    public function test_create_service()
    {
        $response = $this->service->createService($this->surfix, true);
    }

    /**
     * test simulation create generate name of service
     */
    public function test_class_name_generate()
    {
        $input = "Setting/OpenServiceImplement";
        $name = str_replace(config("easy-repository.service_suffix"), "",$input);
        $className = Str::studly($name);

        $this->assertEquals($name, $className);
    }

    /**
     * test create namespace on service
     */
    public function test_make_namespace() {

        $className = "Book/Category";
        $namespace = "";

        $explode = explode('/', $className);
        if (count($explode) > 1) {
            $namespace = '';
            for($i=0; $i < count($explode)-1; $i++) {
                $namespace .= '\\'.$explode[$i];
            }
           $namespace = config("easy-repository.service_namespace").$namespace."\\".end($explode);
        } else {
            $namespace = config("easy-repository.service_namespace")."\\".$className;
        }

        $this->assertStringEndsWith("Category", $namespace);
    }
}
