<?php

/**
 * Created by PhpStorm.
 * User: wind
 * Date: 15/10/2016
 * Time: 3:17 SA
 */
namespace EXP\Core\Json;

class Read_JSON
{
    /*
     * Read File Json Default
     * @param $path as source file
     * @return $json as Array json
     */
    public static function Read_Default($path){
        $str = file_get_contents($path);
        $json = json_decode($str, true);
        return $json;
    }
}