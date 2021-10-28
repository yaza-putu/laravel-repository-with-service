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
}
