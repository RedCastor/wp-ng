<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public
 */


/**
 * The public-facing functionality of the plugin.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Public {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;


  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of the plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct( $plugin_name, $version ) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

    $this->load_dependencies();

    /* Support for REST API  */
    add_action( 'init',                       array( 'Wp_Ng_Public_Rest_Api', 'remove_option_rewrite_rules' ), 10 );
    add_action( 'rest_api_init',              array( 'Wp_Ng_Public_Rest_Api', 'set_language'), 1 );
    add_filter( 'rest_authentication_errors', array( 'Wp_Ng_Public_Rest_Api', 'cookie_check_errors'), 90 );

    /* Custom Filter */
    add_filter( 'wp_ng_current_language', array( $this, 'wp_ng_get_current_language') );


    //Script and style
    add_action( 'wp_enqueue_scripts',  array( $this, 'enqueue_script_jquery'), 2 );
    add_action( 'wp_enqueue_scripts',  array( $this, 'enqueue_script_angular'), 2 );
    add_action( 'wp_enqueue_scripts',  array( $this, 'enqueue_style_angular_modules'), 1000 );
    add_action( 'wp_enqueue_scripts',  array( $this, 'enqueue_script_angular_modules'), 1000 );


    add_filter( 'body_class', array( $this, 'body_class') );

  }


  private function load_dependencies() {

    /**
     * Include Fallback class
     */
    require_once plugin_dir_path( __FILE__ ) . '/includes/class-wp-ng-public-fallback.php';

    /**
     * Include support rest api class
     */
    require_once plugin_dir_path( __FILE__ ) . '/includes/class-wp-ng-public-rest-api.php';

  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {

    //Register style wp-ng
    wp_register_style($this->plugin_name, wp_ng_get_asset_path('styles/' . $this->plugin_name . '.css'), array(), $this->version, 'all');
    wp_enqueue_style($this->plugin_name);
  }

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {

    //Register script wp-ng
    wp_register_script($this->plugin_name, wp_ng_get_asset_path('scripts/' . $this->plugin_name . '.js'), array('angular'), $this->version, true);
    wp_enqueue_script($this->plugin_name);
  }

	/**
	 * Register the default stylesheets angular modules for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function default_styles( &$styles ) {

    $ng_module = Wp_Ng_Module::getInstance();
    $ng_module->default_styles( $styles );
	}

	/**
	 * Register the default JavaScript angular modules for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function default_scripts( &$scripts ) {

	  $ng_module = Wp_Ng_Module::getInstance();
    $ng_module->default_scripts( $scripts );
	}



  /**
   * After theme support
   *
   * @since   1.0.0
   */
  public  function after_setup_theme() {
    $settings_page = Wp_Ng_Settings::getInstance( $this->plugin_name );
    $settings_page->register_fields( apply_filters('wp_ng_settings_fields', array()) );
  }

  /**
   * Register the JavaScript jquery.
   *
   * @since    1.0.0
   */
  public function enqueue_script_jquery() {

    //Register script jquery Todo add option fallback or not fallback
    Wp_Ng_Public_Fallback::register_jquery_fallback();
  }

  /**
   * Register the JavaScript angular.
   *
   * @since    1.0.0
   */
  public function enqueue_script_angular() {

    //Register script angular Todo add option fallback or not fallback
    Wp_Ng_Public_Fallback::register_angular_fallback( array('jquery') );
  }


  /**
   * Enqueue Script Angular Modules
   */
  public function enqueue_script_angular_modules() {
    global $wp_scripts;

    $ng_module = Wp_Ng_Module::getInstance();
    $ng_modules = $ng_module->get_ng_module_from_handles_script();
    $wp_ng_handles_src = $ng_module->get_scripts_src();

    //Add to ng handle source on top of array the script wp-ng
    $wp_ng_handles_src = array_merge(array($this->plugin_name => wp_ng_get_asset_path('scripts/' . $this->plugin_name . '.js')), $wp_ng_handles_src);

    //Filter unique array value and apply filter
    $ng_modules = apply_filters('wp_ng_register_ng_modules', $ng_modules);
    $ng_modules = array_unique($ng_modules);
    $wp_ng_handles_src = array_unique($wp_ng_handles_src);

    //Add Environement variable json
    $this->add_wp_ng_env( $ng_modules );

    //Combine Script
    if ( wp_ng_is_combine_modules() ) {

      $cache = new Wp_Ng_Cache( $this->plugin_name . '.js' , '.js', $this->plugin_name );
      $basename = $cache->combine( $wp_ng_handles_src, wp_ng_get_cache_hours() );

      if( $basename ) {
        $combine_url = $cache::cache_dir($this->plugin_name, $basename, true);

        $extra = array(
          'data' => '',
        );
        foreach ($wp_ng_handles_src as $handle => $src) {

          $extra['before'][] = $wp_scripts->print_inline_script($handle, 'before', false);
          $extra['after'][] = $wp_scripts->print_inline_script($handle, 'after', false);

          $_extra_data = $wp_scripts->print_extra_script($handle, false);

          $extra['data'] .= ($_extra_data) ? $_extra_data . PHP_EOL : '';

          wp_deregister_script($handle);
        }

        wp_register_script($this->plugin_name, $combine_url, array('angular'), null, true);

        if ( !empty($extra['data']) ) {
          $wp_scripts->add_data( $this->plugin_name, 'data', $extra['data'] );
        }

        if ( isset($extra['before']) ) {
          foreach ($extra['before'] as $key => $data) {
            if($data) {
              wp_add_inline_script($this->plugin_name, $data, 'before' );
            }
          }
        }

        if( isset($extra['after']) ) {
          foreach ($extra['after'] as $key => $data) {
            if($data) {
              wp_add_inline_script($this->plugin_name, $data, 'after');
            }
          }
        }

      }
    }

  }

  /**
   * Enqueue Style Angular Modules
   */
  public function enqueue_style_angular_modules() {
    global $wp_styles;

    $ng_module = Wp_Ng_Module::getInstance();
    $ng_modules = $ng_module->get_ng_module_from_handles_style();
    $wp_ng_handles_src = $ng_module->get_styles_src();

    //Add to ng handle source on top of array the style wp-ng
    $wp_ng_handles_src = array_merge(array($this->plugin_name => wp_ng_get_asset_path('styles/' . $this->plugin_name . '.css')), $wp_ng_handles_src);

    //Filter unique array value
    $wp_ng_handles_src = array_unique($wp_ng_handles_src);

    //Combine Style
    if ( wp_ng_is_combine_modules() ) {

      $cache = new Wp_Ng_Cache( $this->plugin_name . '.css' , '.css', $this->plugin_name );
      $basename = $cache->combine( $wp_ng_handles_src, wp_ng_get_cache_hours() );

      if( $basename ) {
        $combine_url = $cache::cache_dir($this->plugin_name, $basename, true);

        foreach ($wp_ng_handles_src as $handle => $src) {
          wp_deregister_style($handle);
        }

        wp_register_style($this->plugin_name, $combine_url, array(), null, 'all');
      }
    }
  }

  /**
   * Add class to body
   * @param $classes
   * @return mixed
   */
  public function body_class( $classes ) {

    if ( wp_ng_is_ng_cloak() && !in_array( 'ng-cloak', $classes ) ) {
      $classes[] = 'ng-cloak';
    }

    return $classes;
  }

  /**
   * Get Current Language
   */
  function wp_ng_get_current_language( $lang = '' ) {
    $lang = (function_exists('icl_object_id')) ? ICL_LANGUAGE_CODE : explode("_", get_locale())[0];

    return $lang;
  }

  /**
   * Add script inline Config
   *
   */
  private function add_wp_ng_env( $ng_modules = array() ) {

    $_lang = apply_filters('wp_ng_get_langguage', null);

    //Theme
    $_theme = wp_get_theme();


    //SET NG Modules Config
    $config_modules = array();
    foreach ($ng_modules as $ng_module) {
      $_data = apply_filters( 'wp_ng_' . $ng_module . '_config', array());
      if( !empty($_data) ) {
        $config_modules[$ng_module] = $_data;
      }
    }


    //SET CONFIG PARAMS
    $config = apply_filters('wp_ng_app_config', array(
      'baseUrl'     => trailingslashit( get_home_url() ),
      'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
      'local'       => get_locale(),
      'defaultLang' => $_lang['default'],
      'currentLang' => $_lang['current'],
      'themeName'   => $_theme->get('Name'),
      'themeVersion'=> $_theme->get('Version'),
      'wpVersion'   => get_bloginfo('version'),
      'enableDebug' => (WP_DEBUG !== false) ? true : false,
      'env'         => defined('WP_ENV') ? WP_ENV : 'production',
      'modules'     => $config_modules,
    ));

    //SET ENV PARAMS
    $env = apply_filters('wp_ng_app_env',
      array(
        'app'         => null,
        'appName'     => wp_ng_get_app_name(),
        'appElement'  => apply_filters('wp_ng_app_element', 'body'),
        'ngModules'   => array_values(apply_filters( 'wp_ng_ng_modules', $ng_modules)),
        'config'      => $config,
      )
    );


    $script = sprintf( 'window.wpNg = %s', json_encode( $env ) );
    wp_add_inline_script($this->plugin_name, $script, 'before');
  }

}
