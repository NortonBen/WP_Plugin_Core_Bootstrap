<?php

namespace EXP;
/**
 * Created by PhpStorm.
 * User: wind
 * Date: 11/10/2016
 * Time: 9:41 SA
 */

// File extension
define( 'EXT', '.php' );

// Line break
define('CRLF', "\r\n");

// Blade files extension
define('BLADE_EXT', '.blade.php');

// Directory separator
if ( ! defined( 'DS' ) )
    define( 'DS', DIRECTORY_SEPARATOR );


use EXP\Core\Env\Parser;
class Config{
    public static $path_view_bootstrap = null;
    public static $path_view = null;
    public static $blade_storage_path = null;
    public static $BLADE_EXT = '.blade.php';
    public static $EXT = '.php';
    public static $CRLF = "\r\n";
    public static $path_cache = null;
    public static $path_assets = null;
    public static $file_bootsrap = null;
    public static $dir_bootsrap = null;
    public static $url_bootstrap = null;

    public static function load(){
        $data_exp = $GLOBALS['data_exp'];
        $plugin_path = $data_exp['plugin_path'];
        $arg = Parser::parse(file_get_contents($plugin_path.DIRECTORY_SEPARATOR.'.env'));
        static::$path_view = $plugin_path.DS.$arg['path_view'];
        static::$path_cache = $plugin_path.DS.$arg['path_cache'];
        static::$path_assets = $plugin_path.DS.$arg['path_assets'];
        static::$path_view_bootstrap = $plugin_path.DS.$arg['path_view_bootstrap'];
        static::$blade_storage_path = static::$path_cache.DS."views";
        static::$file_bootsrap = __FILE__;
        static::$dir_bootsrap = dirname(static::$file_bootsrap);
        static::$url_bootstrap = plugin_dir_url(dirname(static::$file_bootsrap));
    }
}