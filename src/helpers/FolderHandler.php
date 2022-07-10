<?php


namespace LaravelEasyRepository\helpers;
use File;

class FolderHandler
{
    /**
     * ensure directory exist
     * @param $folder
     */
    static function createFolder($folder) {
        // check directory exist
        File::ensureDirectoryExists($folder);

    }
}
