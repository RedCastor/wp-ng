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
   * The new modules register.
   *
   * @since    1.1.0
   * @access   private
   */
  private $external_modules;

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

    //Init
    add_action( 'init', array( 'Wp_Ng_Public_Shortcodes', 'init' ) );

    /* Support for REST API  */
    add_action( 'init',                       array( 'Wp_Ng_Public_Rest_Api', 'remove_option_rewrite_rules' ), 10 );
    add_action( 'rest_api_init',              array( 'Wp_Ng_Public_Rest_Api', 'set_language'), 1 );
    add_filter( 'rest_authentication_errors', array( 'Wp_Ng_Public_Rest_Api', 'cookie_check_errors'), 90 );

    /* Add Remove WPAUTOP */
    add_action( 'acf/init', array($this, 'remove_wpautop') ); //Acf plugin
    add_action( 'init', array($this, 'remove_wpautop') );


    /* Custom Filter */
    add_filter( 'wp_ng_current_language', array( $this, 'wp_ng_get_current_language') );


    //Script and style
    add_action( 'wp_enqueue_scripts',  array( $this, 'enqueue_script_jquery'), 2 );
    add_action( 'wp_enqueue_scripts',  array( $this, 'enqueue_script_angular'), 2 );
    add_action( 'wp_enqueue_scripts',  array( $this, 'process_style_angular_modules'), 1000 );
    add_action( 'wp_enqueue_scripts',  array( $this, 'process_script_angular_modules'), 1000 );


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

    /**
     * Include Shortcodes class
     */
    require_once plugin_dir_path( __FILE__ ) . '/includes/class-wp-ng-public-shortcodes.php';
  }


  /**
   * Add Settings Modules Fields
   *
   * @since   1.1.0
   */
  private  function add_settings_module_fields( $name, $active = false, $desc = '', $sub_fields = null, $version = false ) {


    $sub_fields = array_merge(
      $sub_fields,
      array(
        array(
          'name'        => 'active',
          'label'       => 'Active',
          'default'     => ($active === true) ? 'on' : 'off',
          'type'        => 'checkbox',
        ),
        array(
          'name'        => 'conditions',
          'label'       => 'Conditions',
          'desc'        => __( 'Load on conditions.', 'wp-ng'),
          'default'     => 'off',
          'type'        => 'checkbox',
          'conditions'  => true,
        ),
      )
    );


    $module_fields = array(
      'name'  => $name,
      'label' => str_replace('+' , ', ', $name),
      'desc'  => wp_ng_settings_sections_desc_html( '', $desc, $version ),
      'type'        => 'sub_fields',
      'sub_fields'  => $sub_fields
    );

    return $module_fields;
  }

  /**
   * Register External Angular Module
   *
   * @since    1.1.0
   */
  public function external_modules() {

    //Register External modules
    foreach ($this->external_modules as $external_module) {
      $ng_module = Wp_Ng_Module::getInstance();
      $ng_module->register_module(
        $external_module['name'],
        $external_module['scripts_src'],
        $external_module['styles_src'],
        $external_module['version']
      );
    }
  }

 /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {

    $module_handles = wp_ng_get_active_modules();

    foreach ( $module_handles as $module_handle => $module_params ) {

      $module_styles = array_filter($module_params, function($value, $key) {
        return strpos($key, 'style') === 0;
      }, ARRAY_FILTER_USE_BOTH);

      foreach ( $module_styles as $module_style_name => $module_style ) {
        if ( !empty($module_style) ) {
          wp_enqueue_style( $module_style );
        }
      }
    }

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

    $module_handles = wp_ng_get_active_modules();

    foreach ( $module_handles as $module_handle => $module_params ) {
      wp_enqueue_script( $module_handle );

      $module_scripts = array_filter($module_params, function($value, $key) {
        return strpos($key, 'script') === 0;
      }, ARRAY_FILTER_USE_BOTH);

      foreach ( $module_scripts as $module_script_name => $module_script ) {
        if ( !empty($module_script) ) {
          wp_enqueue_script( $module_script );
        }
      }
    }

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
  public function after_setup_theme() {

    //Setup Ext Angular Modules
    $external_modules_fields = array();
    $external_modules = apply_filters( 'wp_ng_register_external_modules', array() );

    $this->external_modules = array();

    if ( is_array($external_modules) ) {
      foreach ( $external_modules as $external_module ) {

        if ( ! isset( $external_module['name'] ) ) {
          continue;
        }

        $name         = str_replace('.', '__dot__', $external_module['name']);
        $desc         = isset( $external_module['desc'] ) ? $external_module['desc'] : '';
        $active       = ( isset( $external_module['active'] ) && is_bool($external_module['active']) ) ? $external_module['active'] : false;
        $version      = ( isset( $external_module['version'] ) && !empty( $external_module['version'] ) ) ? $external_module['version'] : false;
        $scripts_src  = isset( $external_module['scripts_src'] ) ? $external_module['scripts_src'] : array();
        $styles_src   = isset( $external_module['styles_src'] ) ? $external_module['styles_src'] : array();
        $sub_fields   = isset( $external_module['fields'] ) ? $external_module['fields'] : array();

        if (!empty($styles_src)) {
          $sub_fields[] =  array_merge($sub_fields, array(
              'name'        => 'style',
              'label'       => 'Style',
              'desc'        => __( 'Load style.', 'wp-ng'),
              'default'     => 'on',
              'type'        => 'checkbox',
            )
          );
        }

        $this->external_modules[] = array(
          'name'        => $name,
          'desc'        => $desc,
          'active'      => $active,
          'version'     => $version,
          'scripts_src' => $scripts_src,
          'styles_src'  => $styles_src,
        );

        $external_modules_fields[] = $this->add_settings_module_fields( $name, $active, $desc, $sub_fields, $version);
      }

    }


    //Setup Settings Page
    $settings_page = Wp_Ng_Settings::getInstance( $this->plugin_name );

    $fields = apply_filters('wp_ng_settings_fields', array());

    //Register new modules settings fields.
    $fields['wp_ng_load_modules']['sections']['modules']['fields'] = array_merge(
      $fields['wp_ng_load_modules']['sections']['modules']['fields'],
      $external_modules_fields
    );

    $settings_page->register_fields( $fields );
  }

  /**
   * Register the JavaScript jquery.
   *
   * @since    1.0.0
   */
  public function enqueue_script_jquery() {

      //Register script jquery
      Wp_Ng_Public_Fallback::register_jquery_fallback();
  }

  /**
   * Register the JavaScript angular.
   *
   * @since    1.0.0
   */
  public function enqueue_script_angular() {

      //Register script angular
      Wp_Ng_Public_Fallback::register_angular_fallback( array('jquery') );
  }


  /**
   * Process Script Angular Modules
   */
  public function process_script_angular_modules() {
    global $wp_scripts;


    $ng_module = Wp_Ng_Module::getInstance();

    $ng_modules = $ng_module->get_ng_module_from_handles_script();
    $wp_ng_handles_src = $ng_module->get_scripts_src();

    //Add to ng handle source on top of array the script wp-ng
    $wp_ng_handles_src = array_merge(array($this->plugin_name => wp_ng_get_asset_path('scripts/' . $this->plugin_name . '.js')), $wp_ng_handles_src);

    //Filter unique array value and apply filter
    $ng_modules = apply_filters('wp_ng_register_ng_modules', $ng_modules);
    $ng_modules = array_unique($ng_modules);

    //Deregister duplicate source
    $duplicate_wp_ng_handles_src = array_diff_assoc($wp_ng_handles_src, array_unique($wp_ng_handles_src));
    foreach ( $duplicate_wp_ng_handles_src as $handle => $src) {
      wp_dequeue_script($handle);
      wp_deregister_script($handle);
    }

    //Filter unique source value
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

          //Deregister only if current request host is the same as source handle host
          $src_host = parse_url( $src, PHP_URL_HOST );
          $current_host = parse_url( get_site_url(), PHP_URL_HOST);
          if ( $src_host === $current_host ) {
            if ($handle !== $this->plugin_name) {
              wp_dequeue_script($handle);
            }
            wp_deregister_script($handle);
          }
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
   * Process Style Angular Modules
   */
  public function process_style_angular_modules() {

    $ng_module = Wp_Ng_Module::getInstance();
    $ng_modules = $ng_module->get_ng_module_from_handles_style();
    $wp_ng_handles_src = $ng_module->get_styles_src();

    //Add to ng handle source on top of array the style wp-ng
    $wp_ng_handles_src = array_merge(array($this->plugin_name => wp_ng_get_asset_path('styles/' . $this->plugin_name . '.css')), $wp_ng_handles_src);

    //Deregister duplicate source
    $duplicate_wp_ng_handles_src = array_diff_assoc($wp_ng_handles_src, array_unique($wp_ng_handles_src));
    foreach ( $duplicate_wp_ng_handles_src as $handle => $src) {
      wp_dequeue_style($handle);
      wp_deregister_style($handle);
    }

    //Filter unique source value
    $wp_ng_handles_src = array_unique($wp_ng_handles_src);

    //Combine Style
    if ( wp_ng_is_combine_modules() ) {

      $cache = new Wp_Ng_Cache( $this->plugin_name . '.css' , '.css', $this->plugin_name );
      $basename = $cache->combine( $wp_ng_handles_src, wp_ng_get_cache_hours() );

      if( $basename ) {
        $combine_url = $cache::cache_dir($this->plugin_name, $basename, true);

        foreach ($wp_ng_handles_src as $handle => $src) {

          //Deregister only if current request host is the same as source handle host
          $src_host = parse_url( $src, PHP_URL_HOST );
          $current_host = parse_url( get_site_url(), PHP_URL_HOST);

          if ( $src_host === $current_host ) {
            if ($handle !== $this->plugin_name) {
              wp_dequeue_style($handle);
            }
            wp_deregister_style($handle);
          }
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

    if ( wp_ng_is_ng_cloak() && wp_ng_get_app_element() === 'body' && !in_array( 'ng-cloak', $classes ) ) {
      $classes[] = 'ng-cloak';
    }

    if ( wp_ng_is_ng_preload() && wp_ng_get_app_element() === 'body' && !in_array( 'ng-preload', $classes ) ) {
      $classes[] = 'ng-preload';
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

    $_lang = apply_filters('wp_ng_get_language', null);

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
      'html5Mode'   => false,
      'hashPrefix'  => '',
      'errorOnUnhandledRejections' => false,
      'env'         => defined('WP_ENV') ? WP_ENV : 'production',
      'cloak'       => wp_ng_is_ng_cloak(),
      'preload'     => wp_ng_is_ng_preload(),
      'modules'     => $config_modules,
    ));

    //SET ENV PARAMS
    $env = apply_filters('wp_ng_app_env',
      array(
        'app'         => null,
        'appName'     => wp_ng_get_app_name(),
        'appElement'  => wp_ng_get_app_element(),
        'ngModules'   => array_values(apply_filters( 'wp_ng_ng_modules', $ng_modules)),
        'config'      => $config,
      )
    );


    $script = sprintf( 'window.wpNg = %s', json_encode( $env ) );
    wp_add_inline_script($this->plugin_name, $script, 'before');
  }


  /**
   * Remove WPAUTOP.
   */
  public function remove_wpautop() {
    if ( wp_ng_disable_wpautop() === true ) {
      remove_filter( 'acf_the_content', 'wpautop' );
      remove_filter( 'the_content', 'wpautop' );
      remove_filter( 'the_excerpt', 'wpautop' );
    }
  }
}
