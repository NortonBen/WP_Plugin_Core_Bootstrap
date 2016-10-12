<?php
/**
 * This is the Bootstrapper that will bring all the essential function to build plugin core
 *
 * @author JAX
 */

namespace EXP;
use EXP\Core\View\Blade;
use EXP\Core\View\View;
use EXP\Core\Env\Parser;

class Bootstrap{
    public $slug_pages = [];
    public $file = null;
    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {
        $data_exp = $GLOBALS['data_exp'];
        $plugin_path = $data_exp['plugin_path'];
        $this->plugin_name = $data_exp['plugin_name'];
        $this->plugin_dir  = $plugin_path;
        $this->plugin_url = plugin_dir_url($data_exp['plugin_file']);
        $this->assets = trailingslashit($this->plugin_url . 'assets');
        Config::load();

    }


    /**
     *
     */
    public function hook()
    {

    }


    public function view($template, $data = array()){
        $path_view = Config::$path_view[$this->plugin_name];
        View::$path_view = $path_view;
        Config::set_path_storega($this->plugin_name);
        Blade::sharpen();
        return View::make($template, $data);
    }

    public function compiled_View($template, $data = array()){
        
        $path_view = Config::$path_view[$this->plugin_name];
        View::$path_view = $path_view;
        Config::set_path_storega($this->plugin_name);

        Blade::sharpen();
        $view  = View::make($template, $data);
        $pathToCompiled = Blade::compiled( $view->path );
        if ( ! file_exists( $pathToCompiled ) or Blade::expired( $view->view, $view->path ) )
            file_put_contents( $pathToCompiled,Blade::compile( $view ));
        $view->path = $pathToCompiled;
        return $pathToCompiled;
    }
    /**
     * @param $path
     */
    public function folder_class_calling_out($path)
    {
        $path = trim($path, '/');
        $full_path = $this->plugin_dir . '/' .  $this->switch_alias_dir($path);

        if (is_dir($full_path)) {

            $all_core_files = scandir($full_path, SCANDIR_SORT_DESCENDING);
            if (is_array($all_core_files)) {

                foreach ($all_core_files as $file_name) {
                    $path_file = $full_path . '/' . $file_name;

                    if (file_exists($path_file) && strpos($file_name, '.php') !== false) {
                        include($path_file);
                        $class_name = substr($file_name, 0, -4);
                        if (class_exists($class_name)) {
                            ${$class_name} = new $class_name($this);
                            ${$class_name}->init();
                        }
                    }
                }
            }
        } else {
            $path = explode('.', $path);
            echo 'The system lost file <b>' . $full_path . '</b>, Please re-install plugin <br>' . $path[0];
        }
    }

    /**
     * Render template file in template folder
     * ------------------------------------------
     * @param $alias_path
     * @param $form_data
     * @param $place : 1. Bootstrap place, 2. Main template place
     * @return string
     * @internal param $path
     */

    public function get_template_file__($alias_path, $form_data = null, $place = null)
    {
        if ($place == null) {
            $place = 'template/';
        } else {
            $place =  $this->switch_alias_dir($place);
        }

        $full_path = $this->plugin_dir . DIRECTORY_SEPARATOR . $place . DIRECTORY_SEPARATOR . $this->switch_alias_dir($alias_path);

        // Checking for variable assign
        if (!empty($form_data) && is_array($form_data)) {
            foreach ($form_data as $variable_name => $variable_value) {
                ${$variable_name} = $variable_value;
            }
        }

        $full_path_name = $full_path . '.temp.php';

        if (file_exists($full_path_name)) {
            ob_start();
            include $full_path_name;
            return ob_get_clean();
        }
        return '';
    }

    /**
     * @param $settings
     * @return string
     */
    public function generate_field( $field )
    {

        // Prevent the lack of attributes
        $field = array_merge(array(
            'type'        => 'text',
            'select_type' => '',
            'name'        => '',
            'class'       => '',
            'id'          => '',
            'attrs'       => [],
            'placeholder' => '',
            'default'     => '',
            'options'     => '',
            'default_option' => []
        ), $field);

        return $this->get_template_file__('fields.' . $field['type'], $field, 'bootstrap.template');
    }

    /**
     *
     */
    public function embed_flat_UI()
    {
        wp_enqueue_style('bootstrap.css', Config::$url_bootstrap . '/assets/plugins/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('style.css', Config::$url_bootstrap . '/assets/css/style.css');
        wp_enqueue_style('waves.css', Config::$url_bootstrap . '/assets/plugins/node-waves/waves.css');
        wp_enqueue_style('animate.css', Config::$url_bootstrap . '/assets/plugins/animate-css/animate.css');
        wp_enqueue_style('multi-select.css', Config::$url_bootstrap. '/assets/plugins/multi-select/css/multi-select.css');
        wp_enqueue_style('bootstrap-select.min.css', Config::$url_bootstrap. '/assets/plugins/bootstrap-select/css/bootstrap-select.min.css');

        // Google Front
        wp_enqueue_style('material.icons', 'https://fonts.googleapis.com/icon?family=Material+Icons');
        wp_enqueue_style('Roboto', 'https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext');


        wp_enqueue_script('jquery.js', Config::$url_bootstrap . '/assets/plugins/jquery/jquery.min.js', null, '1.0.0', TRUE);
        wp_enqueue_script('bootstrap.min.js', Config::$url_bootstrap . '/assets/plugins/bootstrap/js/bootstrap.min.js', null, '1.0.0', TRUE);
        wp_enqueue_script('waves.js', Config::$url_bootstrap . '/assets/plugins/node-waves/waves.js', null, '1.0.0', TRUE);
        wp_enqueue_script('jquery.multi-select.js', Config::$url_bootstrap . '/assets/plugins/multi-select/js/jquery.multi-select.js', null, '1.0.0', TRUE);
        wp_enqueue_script('admin.js', Config::$url_bootstrap . '/assets/js/admin.js', null, '1.0.0', TRUE);
        wp_enqueue_script('bootstrap-select.min.js', Config::$url_bootstrap . '/assets/plugins/bootstrap-select/js/bootstrap-select.min.js', null, '1.0.0', TRUE);
    }

    public function embed_admin_setting_page() {
        wp_enqueue_style('admin.bootstrap.css', Config::$url_bootstrap . '/assets/css/admin.bootstrap.css');
        wp_enqueue_script('tooltips-popovers.js', Config::$url_bootstrap . '/assets/js/tooltips-popovers.js', null, '1.0.0', TRUE);

    }


    public function string_to_url( $string ) {
        $explode = explode(' ', $string);
        return implode('+', $explode);
        return str_replace(' ', '+', $string);
    }

    /**
     * @param $path
     * @return mixed
     */
    public function switch_alias_url($path)
    {
        if (strpos($path, '.') !== false)
            return str_replace('.', '/', $path);

        return $path;
    }

    /**
     * @param $path
     * @return mixed
     */
    public function switch_alias_dir($path)
    {
        if (strpos($path, '.') !== false)
            return str_replace('.', DIRECTORY_SEPARATOR, $path);

        return $path;
    }


}
