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
        $this->artisan('make:repository', ['name' => $this->surfix])->assertExitCode(0);
        $this->assertTrue(file_exists($this->appPath() . "/Repositories/{$this->surfix}/{$this->surfix}Repository.php"));
    }

    public function test_create_repository()
    {
        $this->artisan('make:repository', ['name' => $this->surfix])->assertExitCode(0);
        $this->assertTrue(file_exists($this->appPath() . "/Repositories/{$this->surfix}/{$this->surfix}RepositoryImplement.php"));
    }

    protected function appPath()
    {
        return $this->app->basePath('app');
    }
}
