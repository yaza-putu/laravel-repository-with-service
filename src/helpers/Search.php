<?php


namespace LaravelEasyRepository\helpers;


class Search
{
    /**
     * @param $folder
     * @param $pattern_array
     * @return array [SplFileInfo]
     */
    static function file($folder, $pattern_array) {
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
