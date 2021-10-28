<?php

namespace LaravelEasyRepository\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand as ConsoleModelMakeCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ModelMakeCommand extends ConsoleModelMakeCommand
{

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model class';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        if ($this->option('all')) {
            $this->input->setOption('service', true);
            $this->input->setOption('repository', true);
        }


        if ($this->option('service')) {
            $this->createService();
        }

        if ($this->option('repository')) {
            $this->createRepository();
        }
    }

    /**
     * Create service for the model
     *
     * @return void
     */
    private function createService()
    {
        $name = Str::studly($this->argument('name'));

        $this->call("make:service", [
            "name" => $name,
        ]);
    }

    /**
     * Create a repository
     *
     * @return void
     */
    private function createRepository()
    {
        $name = Str::studly($this->argument('name'));

        $this->call("make:repository", [
            "name" => $name,
        ]);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a migration, seeder, factory, and resource controller for the model'],
            ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the model'],
            ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the model'],
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model'],
            ['service', 'sr', InputOption::VALUE_NONE, 'Create a new service file for the model'],
            ['repository', 'rt', InputOption::VALUE_NONE, 'Create a new repository file for the model'],
            ['seed', 's', InputOption::VALUE_NONE, 'Create a new seeder file for the model'],
            ['pivot', 'p', InputOption::VALUE_NONE, 'Indicates if the generated model should be a custom intermediate table model'],
            ['resource', 'r', InputOption::VALUE_NONE, 'Indicates if the generated controller should be a resource controller'],
            ['api', null, InputOption::VALUE_NONE, 'Indicates if the generated controller should be an API controller'],
            ['policy', null, InputOption::VALUE_NONE, 'Create a new policy for the model'],
        ];
    }
}
