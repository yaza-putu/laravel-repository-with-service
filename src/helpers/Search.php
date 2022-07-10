<?php


namespace LaravelEasyRepository\helpers;


use function League\Flysystem\Local\ensureDirectoryExists;
use Illuminate\Filesystem\Filesystem;

class Search
{
    /**
     * @param $folder
     * @param $pattern_array
     * @return array [SplFileInfo]
     */
    static function file($folder, $pattern_array) {
        // check directory exsist
       app()->make(Filesystem::class)->ensureDirectoryExists($folder);

        $return = array();
        $iti = new \RecursiveDirectoryIterator($folder);
        foreach(new \RecursiveIteratorIterator($iti) as $file){
            $arr = explode('.', $file);
            if (in_array(strtolower(array_pop($arr)), $pattern_array)){
                $return[] = $file;
            }
        }
        return $return;
    }
}
