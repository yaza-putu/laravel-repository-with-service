<?php


namespace LaravelEasyRepository\Tests\Integrations;


use LaravelEasyRepository\Commands\MakeRepository;
use LaravelEasyRepository\Tests\TestCase;
use Illuminate\Console\Command;
use Mockery\MockInterface;

class CreateRepositoryTest extends TestCase
{

    /**
     * test create repository
     * @group integration
     */
    public function test_create_repository() {
        $this->artisan("make:repository User");
    }
}
