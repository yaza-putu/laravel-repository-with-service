<?php


namespace LaravelEasyRepository\Tests\Unit;


use LaravelEasyRepository\Commands\MakeRepository;
use LaravelEasyRepository\Tests\TestCase;

/**
 * @group unit
 * Class RepositoryTest
 * @package LaravelEasyRepository\Tests\Unit
 */
class RepositoryTest extends TestCase
{
    private $surfix, $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->surfix = "User";
        $this->repository = new MakeRepository();
    }

    public function test_create_repository_interface()
    {
        $response = $this->repository->createRepositoryInterface($this->surfix);
        $this->assertEquals(config("easy-repository.repository_namespace") . "\${$this->surfix}", $response);
    }

    public function test_create_repository()
    {
        $response = $this->repository->createRepository($this->surfix, true);
        $this->assertEquals(config("easy-repository.repository_namespace") . "\\".$this->surfix, $response);
    }
}
