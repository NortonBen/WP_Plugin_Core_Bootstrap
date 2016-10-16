<?php
/**
 * Created by PhpStorm.
 * User: wind
 * Date: 12/10/2016
 * Time: 8:46 CH
 */

namespace EXP\Core\Asset;

use EXP\Config;
use EXP\Core\Json\Read_JSON;

class IncludeAsset
{
    public static $path = null;
    public static $dir = null;
    public static $list_include_now = [];
    public static $assets = array(
        'bootstrap'           => [
            'include' => [
                'jquery'
            ],
            'script'  => [
                [
                    "name"    => "bootstrap",
                    'src'     => "/plugins/bootstrap/js/bootstrap.min.js",
                    "server"  => "",
                    'version' => "1.0.0"
                ]
            ],
            'style'   => [
                [
                    "name"    => "bootstrap",
                    'src'     => "/plugins/bootstrap/css/bootstrap.min.css",
                    "server"  => "",
                    'version' => "1.0.0"
                ]
            ]
        ],
        "admin"               => [
            'script' => [
                [
                    "name"    => "admin_AdminBSB",
                    'src'     => "/js/admin.js",
                    "server"  => "",
                    'version' => "1.0.0"
                ]
            ],
            'style' => [
                [
                    "name"    => "admin_AdminBSB",
                    'src'     => "/css/themes/all-themes.min.css",
                    "server"  => "",
                    'version' => "1.0.0"
                ]
            ]
        ],
        "jquery-datatable"    => [
            'include' => [
                'jquery'
            ],
            'script'  => [
                [
                    "name"    => "jquery-datatable",
                    'src'     => "/plugins/jquery-datatable/jquery.dataTable.js",
                    "server"  => "",
                    'version' => "1.0.0"
                ],
                [
                    "name"    => "skin",
                    'src'     => "/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.min.js",
                    "server"  => "",
                    'version' => "1.0.0"
                ]
            ],
            'style'   => [
                [
                    "name"    => "dropzone",
                    'src'     => "/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css",
                    "server"  => "",
                    'version' => "1.0.0"
                ]
            ]
        ],
        'style'               => [
            'style' => [
                [
                    "name"    => "style_AdminBSB",
                    'src'     => "/css/style.min.css",
                    "server"  => "",
                    'version' => "1.0.0"
                ]
            ]
        ]
    );

    public static function load_assets($lists = array())
    {

        foreach ($lists as $list) {
            if (!($data_list = static::load_data($list))) {
                if (!isset(static::$assets[$list])) {
                    echo "  <script>
                        alert('Not Fount Libery asset: $list');
                    </script>";
                    continue;
                }else{
                    $data_list =static::$assets[$list];
                }
            } else {
                static::$assets[$list] = $data_list;
            }
            if (!isset(static::$list_include_now[static::$path])) {
                static::$list_include_now[static::$path] = [];
            }
            static::$list_include_now[static::$path][] = $list;
            if (isset(static::$list_include_now[static::$path][$list])) {
                continue;
            }
            if (isset($data_list['include'])) {
                static::load_assets($data_list['include']);
            }
            if (isset($data_list['script'])) {
                static::load_script($data_list['script']);
            }
            if (isset($data_list['style'])) {
                static::load_style($data_list['style']);
            }
            if(isset($data_list['file'])){
                static::load_file($data_list['file']);
            }
        }
    }

    public static function load_data($name)
    {
        $file = Config::$dir_bootsrap . DS . 'data' . DS . 'assets' . DS . $name . '.json';
        if (!file_exists($file)) {
            return false;
        }
        $data = Read_JSON::Read_Default($file);

        return $data;
    }

    protected static function load_script($scripts = array())
    {
        foreach ($scripts as $script) {
            if (static::is_http($script['src'])) {
                wp_enqueue_script($script['name'] . '.script', $script['src']);
            } else {
                static::exist_assets($script);
                wp_enqueue_script($script['name'] . '.script', static::$path . $script['src']);
            }
        }
    }

    protected static function is_http($value)
    {
        preg_match('/^(https:\/\/).+/', trim($value), $matches);
        if (count($matches) > 0) {
            return true;
        }
        preg_match('/^(http:\/\/).+/', trim($value), $matches);
        if (count($matches) > 0) {
            return true;
        }

        return false;
    }

    public static function exist_assets($asset)
    {
        $file = static::$dir . DS . $asset['src'];
        if (isset($asset['server']) && $asset['server'] == '') {
            return;
        }
        if (!file_exists($file)) {
            $array_dir_meta = explode('/', $asset['src']);
            unset($array_dir_meta[count($array_dir_meta) - 1]);
            $dir = static::$dir . DS . implode('/', $array_dir_meta);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            static::download_file($asset['server'], $file);
        }
    }

    public static function download_file($url, $name_file, $path = false)
    {
        $path_save = null;
        if ($path) {
            $path_save = $path;
        } else {
            $path_save = $name_file;
        }
        file_put_contents($path_save, fopen($url, 'r'));
    }

    protected static function load_style($styles = array())
    {
        foreach ($styles as $list) {
            if (static::is_http($list['src'])) {
                wp_enqueue_style($list['name'] . '.css', $list['src']);
            } else {
                static::exist_assets($list);
                wp_enqueue_style($list['name'] . '.css', static::$path . $list['src']);
            }
        }
    }

    public static function load_assets_plugin($name, $url, $version, $type)
    {
        $asset = array(
            array(
                'name'    => $name,
                'src'     => $url,
                'version' => $version,
                'server'  => ''
            )
        );
        if ($type == 'script') {
            static::load_script($asset);
        }
        if ($type == 'style') {
            static::load_style($asset);
        }
    }

    protected static function load_file($files = array())
    {
        foreach ($files as $file) {
            static::exist_assets($file);
        }
    }

}