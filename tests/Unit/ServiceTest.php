<?php


namespace LaravelEasyRepository\Tests\Unit;

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
}
