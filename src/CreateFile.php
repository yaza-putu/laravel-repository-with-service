<?php


namespace LaravelEasyRepository;

use Exception;
use Illuminate\Filesystem\Filesystem;

class CreateFile
{

    /**
     * The path to create file at
     * @property string $path
     */
    private $path;

    /**
     * The stubProperties to replace
     * @property array $stubProperties
     */
    private array $stubProperties;

    /**
     * Path to the stub file
     *
     * @property string $stubPath
     */
    private string $stubPath;

    /**
     * The filesystem instance.
     *
     * @property \Illuminate\Filesystem\Filesystem
     */
    protected FileSystem $files;

    public function __construct(array $stubProperties, string $path, string $stubPath)
    {
        $this->stubPath = $stubPath;
        $this->stubProperties = $stubProperties;
        $this->path = $path;
        $this->files = app()->make(Filesystem::class);
        $this->fileExists();
        $this->createStub();
    }

    /**
     * Check if file already exists
     *
     * @return bool
     */
    private function fileExists()
    {
        return $this->files->exists($this->path) ? new Exception("The class exists!") : false;
    }

    /**
     * Create the stub file by replacing all the keys
     *
     * @return void
     */
    private function createStub()
    {
        $stub = $this->getStub();
        $populatedStub = $this->populateStub($stub);
        $this->writeFile($populatedStub);
    }

    /**
     * Populate stub with the provided array data, the key is dummy value on stub,
     * the value is the value to replace
     *
     * @param string $stub
     * @return mixed|string
     */
    private function populateStub(string $stub)
    {
        foreach ($this->stubProperties as $replacer => $replaceBy) {
            $stub = str_replace($replacer, $replaceBy, $stub);
        }

        return $stub;
    }

    /**
     * Get stub from the provided path
     *
     * @return mixed|string
     */
    private function getStub()
    {
        return $this->files->get($this->stubPath);
    }

    /**
     * Write to the file specified in the path
     *
     * @param string|mixed $stub
     * @return void
     */
    private function writeFile($stub)
    {
        $this->files->put($this->path, $stub);
    }
}
