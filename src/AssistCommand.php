<?php

namespace LaravelEasyRepository;

use Illuminate\Filesystem\Filesystem;

trait AssistCommand
{
    /**
     * Get the app root path
     *
     * @return string|mixed
     */
    public function appPath()
    {
        return app()->basePath();
    }

    /**
     * Ensure a directory exists.
     *
     * @param  string  $path
     * @param  int  $mode
     * @param  bool  $recursive
     * @return void
     */
    public function ensureDirectoryExists($path)
    {
        app()->make(Filesystem::class)->ensureDirectoryExists($path);
    }

    /**
     * Get configured separate self directory to class
     *
     * @return boolean
     */
    private function needSeparateToClassDirectory()
    {
        $classPointer=strtolower(ltrim((new \ReflectionClass($this))->getShortName(),'Make'));
        return config('easy-repository.'.$classPointer.'_separate_to_class_directory',true);
    }

    /**
     * Get class path prepend if configured separate
     *
     * @return string
     */
    private function getPathPrepend($className)
    {
        $pathPrepend='';
        if($this->needSeparateToClassDirectory()){
            $pathPrepend= DIRECTORY_SEPARATOR . $className;
        }
        return $pathPrepend;
    }
}
