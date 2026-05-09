<?php


namespace LaravelEasyRepository\Tests\Unit;


use LaravelEasyRepository\Tests\TestCase;
class FolderTest extends TestCase
{
    /**
     * @group folder_test
     */
    public function test_folder_repository()
    {
        $this->artisan('make:repository', ['name' => 'User'])->assertExitCode(0);
        $folder_exist = file_exists($this->app->basePath()."/".config("easy-repository.repository_directory"));

        $this->assertTrue($folder_exist);
    }
}
