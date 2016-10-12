<?php

namespace EXP;
    /**
     * Created by PhpStorm.
     * User: wind
     * Date: 11/10/2016
     * Time: 9:41 SA
     */

// File extension
define('EXT', '.php');

// Line break
define('CRLF', "\r\n");

// Blade files extension
define('BLADE_EXT', '.blade.php');

// Directory separator
if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);


use EXP\Core\Env\Parser;

class Config
{
    public static $plugin_name = [];
    public static $path_view_bootstrap = [];
    public static $path_view = [];
    public static $blade_storage_path = null;
    public static $BLADE_EXT = '.blade.php';
    public static $EXT = '.php';
    public static $CRLF = "\r\n";
    public static $path_cache = [];
    public static $path_assets = [];
    public static $file_bootsrap = null;
    public static $dir_bootsrap = null;
    public static $url_bootstrap = null;

    public static function load()
    {
//        static::reset();
        $data_exp = $GLOBALS['data_exp'];
        $plugin_path = $data_exp['plugin_path'];
        $arg = Parser::parse(file_get_contents($plugin_path . DIRECTORY_SEPARATOR . '.env'));
        $plugin_name = $data_exp['plugin_name'];;
        static::$plugin_name[] = $plugin_name;
        static::$path_view[$plugin_name] = $plugin_path . DS . $arg['path_view'];
        static::$path_cache[$plugin_name] = $plugin_path . DS . $arg['path_cache'];
        static::$path_assets[$plugin_name] = $plugin_path . DS . $arg['path_assets'];
        static::$file_bootsrap = __FILE__;
        static::$dir_bootsrap = dirname(static::$file_bootsrap);
        static::$url_bootstrap = plugin_dir_url(static::$file_bootsrap);
        static::$path_view_bootstrap = static::$dir_bootsrap.DS.'views';
    }

    public static function set_path_storega($plugin_name)
    {
        static::$blade_storage_path = static::$path_cache[$plugin_name].DS."views";

    }
}