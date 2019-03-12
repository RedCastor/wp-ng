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
    Wp_Ng_Public_Hooks::init();
    Wp_Ng_Public_Fix::init();
    Wp_Ng_Public_Rest_Api::init();

    //Wpml Init
    if (Wp_Ng_Dependencies::Wpml_active_check()) {
      require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng-public-wpml.php';
      Wp_Ng_Public_wpml::init();
    }

    //Elementor Init
    if (Wp_Ng_Dependencies::Elementor_active_check()) {
      require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng-public-elementor.php';
      Wp_Ng_Public_Elementor::init();
    }

    /* Init Shortcode */
    add_action( 'init', array( 'Wp_Ng_Public_Shortcodes', 'init' ) );


    /* Init Emails */
    add_action( 'init', array( 'Wp_Ng_Emails', 'init_transactional_emails' ), 100 );


    // Add Hook to call by actions
    add_action( 'wp_ng_enqueue_scripts', array( $this, 'enqueue_scripts') );
    add_action( 'wp_ng_enqueue_scripts', array( $this, 'enqueue_styles') );
    add_filter( 'wp_ng_bower_cdn_templates', array( $this, 'add_bower_cdn_templates'), 10, 3 );

  }


  private function load_dependencies() {

    /**
     * Include Hooks class
     */
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng-public-hooks.php';

    /**
     * Include Fix class
     */
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng-public-fix.php';


    /**
     * Include Fallback class
     */
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng-public-fallback.php';

    /**
     * Include support rest api class
     */
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng-public-rest-api.php';


    /**
     * Include modules class
     */
    require_once plugin_dir_path( __FILE__ ) . 'includes/modules/class-wp-ng-ngAntimoderate.php';
    require_once plugin_dir_path( __FILE__ ) . 'includes/modules/class-wp-ng-ui.router.php';


    /**
     * Include Shortcodes class
     */
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng-public-shortcodes.php';
  }


  /**
   * Load Pluggable Dep
   *
   * @since   1.6.4
   */
  public function load_pluggable_dependencies() {

    require_once plugin_dir_path( __FILE__ ) . 'includes/wp-ng-public-pluggable.php';
  }


  /**
   * Add Settings Modules Fields
   *
   * @since   1.1.0
   */
  private function add_settings_module_fields( $name, $active = false, $desc = '', $sub_fields = null, $version = false ) {


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
   * Add templates for cdn
   *
   * @param $templates
   * @return mixed
   */
  public function add_bower_cdn_templates( $templates, $dependency, $bower  ) {


    switch ($dependency['name']) {
      case 'webfont':
        $options = wp_ng_get_script_options( 'WebFont' );
        $cdn = $options['cdn_url'];
        break;
      case 'angular':
        $cdn = wp_ng_get_option( 'cdn_angular_url', 'advanced' );
        break;
      case 'jquery':
        $cdn = wp_ng_get_option( 'cdn_jquery_url', 'advanced' );
        break;
      case 'jquery-migrate':
        $cdn = wp_ng_get_option( 'cdn_jquery_migrate_url', 'advanced' );
        break;
    }

    if (!empty($cdn)){
      $templates[$dependency['cdn']] = $cdn;
    }

    return $templates;
  }

  /**
   * Register External Angular Module
   *
   * @since    1.1.0
   */
  public function external_modules() {

    //Register External modules
    foreach ($this->external_modules as $external_module) {
      $ng_module = wp_ng_modules();
      $ng_module->register_module(
        $external_module['name'],
        $external_module['scripts_src'],
        $external_module['styles_src'],
        $external_module['version']
      );
    }
  }



  public function print_footer_scripts() {

  }



 /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles( $active_module_handles = null ) {

    //Register Addon Scripts Styles
    $wp_ng_scripts = wp_ng_scripts();
    $wp_ng_scripts->register_styles();


    $module_handles = !$active_module_handles ? wp_ng_get_active_modules() : $active_module_handles;

    foreach ( $module_handles as $module_handle => $module_params ) {

      $module_styles = array_filter($module_params, function($value, $key) {
        return strpos($key, 'style') === 0;
      }, ARRAY_FILTER_USE_BOTH);

      foreach ( $module_styles as $module_style_name => $_style_handle ) {
        if ( !empty($_style_handle) ) {
          wp_enqueue_style( $_style_handle );
        }
      }
    }

    //Enqueue Addon Styles
    $script_handles = wp_ng_get_active_scripts();
    foreach ( $script_handles as $script_handle => $script_params ) {

      $script_styles = array_filter($script_params, function($value, $key) {
        return strpos($key, 'style') === 0;
      }, ARRAY_FILTER_USE_BOTH);

      foreach ( $script_styles as $style_name => $_style_handle ) {
        if ( !empty($_style_handle) ) {
          wp_enqueue_style( $_style_handle );
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
  public function enqueue_scripts( $active_module_handles = null ) {

    //Register Addon Scripts
    $wp_ng_scripts = wp_ng_scripts();
    $wp_ng_scripts->register_scripts();

    //Enqueue Angular Modules
    $module_handles = !$active_module_handles ? wp_ng_get_active_modules() : $active_module_handles;

    foreach ( $module_handles as $module_handle => $module_params ) {

      wp_enqueue_script( $module_handle );

      $module_scripts = array_filter($module_params, function($value, $key) {
        return strpos($key, 'script') === 0;
      }, ARRAY_FILTER_USE_BOTH);

      foreach ( $module_scripts as $module_script_name => $_script_handle ) {
        if ( !empty($_script_handle) ) {
          wp_enqueue_script( $_script_handle );
        }
      }
    }

    //Enqueue Addon Scripts
    $script_handles = wp_ng_get_active_scripts();
    foreach ( $script_handles as $script_handle => $script_params ) {

      wp_enqueue_script( $script_handle );

      $scripts = array_filter($script_params, function($value, $key) {
        return strpos($key, 'script') === 0;
      }, ARRAY_FILTER_USE_BOTH);

      foreach ( $scripts as $script_name => $_script_handle ) {
        if ( !empty($_script_handle) ) {
          wp_enqueue_script( $_script_handle );
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

    $wp_ng_scripts = wp_ng_scripts();
    $wp_ng_scripts->default_styles( $styles );

    $ng_module = wp_ng_modules();
    $ng_module->default_styles( $styles );
	}

	/**
	 * Register the default JavaScript angular modules for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function default_scripts( &$scripts ) {

    $wp_ng_scripts = wp_ng_scripts();
    $wp_ng_scripts->default_scripts( $scripts );

	  $ng_module = wp_ng_modules();
    $ng_module->default_scripts( $scripts );
	}

  /**
   * Initialize Modules
   */
  public function init_modules () {

    //Modules
    Wp_Ng_Public_NG_Antimoderate::init();
    Wp_Ng_Public_UI_Router::init();
  }

  /**
   * Initialize Logger
   */
  public function init_logging () {

    if (defined('WP_ENV')) {
      wp_ng_add_plugin_support( 'log_rollbar_env', WP_ENV);
    }

    $log_options = wp_ng_get_log_options();
    $logger = wp_ng_logger();

    //Init File logging
    if (isset($log_options['file']['enable']) && $log_options['file']['enable'] === 'on' ) {

      $track_level = wp_ng_logger()->get_log_level_int($log_options['file']['track_level']);

      $logger->init_log_file($track_level);
    }

    //Init Rollbar
    if (isset($log_options['rollbar']['enable']) && $log_options['rollbar']['enable'] === 'on' ) {

      $track_level = wp_ng_logger()->get_log_level_int($log_options['rollbar']['track_level']);
      $enable_php_debug = (isset($log_options['rollbar']['enable_debug']) && $log_options['rollbar']['enable_debug'] === 'on') ? true : false;
      $enable_track_php = (isset($log_options['rollbar']['enable_track_php']) && $log_options['rollbar']['enable_track_php'] === 'on') ? true : false;

      $logger->init_log_rollbar( $track_level, $log_options['rollbar']['access_token'], $log_options['rollbar']['env'], $enable_php_debug, $enable_track_php, $log_options['rollbar']['track_php_errno'] );
    }
  }


  /**
   * Initialize Options
   *
   * @since   1.0.0
   */
  public function init_options() {

    if ( ! function_exists( 'is_plugin_active' ) ) {
      include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

    //Setup Ext Angular Modules
    $external_modules_fields = array();
    $external_modules = apply_filters( 'wp_ng_register_external_modules', array() );

    $this->external_modules = array();

    if ( is_array($external_modules) ) {
      foreach ( $external_modules as $external_module ) {

        if ( ! isset( $external_module['name'] ) ) {
          continue;
        }

        $name         = wp_ng_sanitize_name('name', $external_module['name']);
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
   * Initialize emails
   *
   * @since 1.5.0
   */
  public function init_emails () {

    if ( wp_ng_plugin_supports('wp-ng_email') ) {

      //Create Instance Emails
      Wp_Ng_Emails::getInstance();
    }
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
   * Process Scripts
   */
  public function process_scripts() {

    $wp_scripts = wp_scripts();
    $ng_module = wp_ng_modules();

    $ng_modules = $ng_module->get_ng_module_from_handles_script();

    //Filter unique array value and apply filter
    $ng_modules = apply_filters('wp_ng_register_ng_modules', $ng_modules);
    $ng_modules = array_unique($ng_modules);

    $wp_ng_handles_src = $ng_module->get_scripts_src();

    //Add to ng handle source on top of array the script wp-ng
    $wp_ng_handles_src = array_merge(array($this->plugin_name => wp_ng_get_asset_path('scripts/' . $this->plugin_name . '.js')), $wp_ng_handles_src);

    $add_script_handles = array_merge( apply_filters('wp_ng_add_handles_process_scripts', array()), wp_ng_get_combine_handles_script());

    //Add handles from combine script option
    $wp_ng_handles_src = array_replace( $wp_ng_handles_src, wp_ng_get_script_handles_source( $add_script_handles ) );

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

              //Apply to_do and done for each handle.
              $wp_scripts = wp_scripts();
              $wp_scripts->done[] = $handle;
              $handle_key = array_search($handle, $wp_scripts->to_do);

              if ($handle_key) {
                unset( $wp_scripts->to_do[$handle_key] );
              }

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
   * Process Styles
   */
  public function process_styles() {

    $ng_module = wp_ng_modules();
    $ng_modules = $ng_module->get_ng_module_from_handles_style();
    $wp_ng_handles_src = $ng_module->get_styles_src();

    //Add to ng handle source on top of array the style wp-ng
    $wp_ng_handles_src = array_merge(array($this->plugin_name => wp_ng_get_asset_path('styles/' . $this->plugin_name . '.css')), $wp_ng_handles_src);

    $add_style_handles = array_merge( apply_filters('wp_ng_add_handles_process_styles', array()), wp_ng_get_combine_handles_style());

    //Add handles from combine script option
    $wp_ng_handles_src = array_replace( $wp_ng_handles_src, wp_ng_get_style_handles_source( $add_style_handles ) );

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

              //Apply to_do and done for each handle.
              $wp_styles = wp_styles();
              $wp_styles->done[] = $handle;
              $handle_key = array_search($handle, $wp_styles->to_do);

              if ($handle_key) {
                unset( $wp_styles->to_do[$handle_key] );
              }

              wp_dequeue_style($handle);
            }
            wp_deregister_style($handle);
          }
        }

        wp_register_style($this->plugin_name, $combine_url, array(), null, 'all');
      }
    }

    wp_add_inline_style( $this->plugin_name, file_get_contents(wp_ng_get_asset_path('styles/' . $this->plugin_name . '-inline.css'))  );
  }

  /**
   * Print template script
   * Todo Print ng-template
   */
  public function print_template ( $templates ) {

  }

  /**
   * Add class to body
   * @param $classes
   * @return mixed
   */
  public function body_class( $classes ) {

    //Cloak NG App
    if ( wp_ng_is_ng_cloak() && wp_ng_get_app_element() === 'body' && !in_array( 'ng-cloak', $classes ) ) {
      $classes[] = 'ng-cloak';
    }

    //Preload NG App
    if ( wp_ng_is_ng_preload() && wp_ng_get_app_element() === 'body' && !in_array( 'ng-preload', $classes ) ) {
      $classes[] = 'ng-preload';
    }

    return $classes;
  }


  /**
   * Add script inline Config
   *
   */
  private function add_wp_ng_env( $ng_modules = array() ) {

    $_lang = wp_ng_get_language();

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


    //Addon SCRIPT
    $config_script = array();
    foreach ( wp_ng_get_active_scripts() as $script_handle => $script_settings ) {

      if ( wp_script_is( $script_handle, 'queue') ) {

        $script = wp_ng_sanitize_name('handle', $script_handle);

        $_data = apply_filters( 'wp_ng_' . $script . '_config', array());

        if( !empty($_data) ) {
          $config_script[$script] = $_data;
        }
      }
    }

    //SET CONFIG PARAMS
    $config = apply_filters('wp_ng_app_config', array(
      'baseUrl'       => wp_ng_get_base_url(),
      'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
      'rest'          => array(
        'url'         => get_rest_url(),
        'namespace'   => 'wp/v2',
      ),
      'distUrl'       => trailingslashit( WP_NG_PLUGIN_URL . 'public/dist' ),
      'wpUrl'         => WP_NG_WP_URL,
      'githubUrl'     => WP_NG_GITHUB_URL,
      'local'         => get_locale(),
      'defaultLang'   => $_lang['default'],
      'currentLang'   => $_lang['current'],
      'themeName'     => $_theme->get('Name'),
      'themeVersion'  => $_theme->get('Version'),
      'wpVersion'     => get_bloginfo('version'),
      'wpCache'       => wp_ng_is_advanced_cache() ? true : false,
      'enableDebug'   => ((WP_DEBUG !== false) || wp_ng_is_enbale_ng_debug()) ? true : false,
      'html5Mode'     => false,
      'hashPrefix'    => '',
      'errorOnUnhandledRejections' => false,
      'env'           => defined('WP_ENV') ? WP_ENV : 'production',
      'cloak'         => wp_ng_is_ng_cloak(),
      'preload'       => wp_ng_is_ng_preload(),
      'modules'       => $config_modules,
      'scripts'       => $config_script,
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


    $script = sprintf( 'window.wpNg = %s', json_encode( $env, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP ) );
    wp_add_inline_script($this->plugin_name, $script, 'before');
  }



  /**
   *
   */
  public function template_redirect_outdated_browser()
  {

    /**
     * Detect browser under IE11 not supported
     *
     * MSIE = IE6 to IE10
     */
    if ( strrpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') && apply_filters('wp_ng_outdated_browser', true) ) {

      wp_ng_get_template( 'outdated-browser.php' );
      exit;
    }

  }


  /**
   * Action on login
   */
  public function init_update_cookie_config() {

    wp_ng_set_cookie_config();
  }


  /**
   * Action on logout config
   */
  public function logout_update_cookie_config() {

    $saved_cookie_logged_in = !empty($_COOKIE[LOGGED_IN_COOKIE]) ? $_COOKIE[LOGGED_IN_COOKIE] : false;
    $user = wp_get_current_user();

    //Unset Cookie "LOGGED_IN_COOKIE"
    if ($saved_cookie_logged_in) {
      unset($_COOKIE[LOGGED_IN_COOKIE]);
    }

    //Logged out current user
    if ($user->ID) {
      wp_set_current_user(0);
    }

    //Point to solved nonce on logout
    wp_ng_set_cookie_config();

    //Restore Cookie "LOGGED_IN_COOKIE"
    if ($saved_cookie_logged_in) {
      $_COOKIE[LOGGED_IN_COOKIE] = $saved_cookie_logged_in;
    }

    //Restore current user
    if ($user->ID) {
      wp_set_current_user($user->ID);
    }
  }


  /**
   * Hook at end of logout
   */
  public function logout_end () {


    $_SESSION = array();

    //PHP COOKIE SESSION DESTROY
    //Some plugin use php session this session is based on file and it locked
    //If multiple query on rest api this is a bottleneck for response time.
    //This prevent if not destroyed session
    if (ini_get("session.use_cookies")) {

      $params = session_get_cookie_params();

      //Expire cookie sesssion
      setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
      );
    }

    //Destroy Session if exist
    if(session_status() === PHP_SESSION_ACTIVE) {
      session_destroy();
    }
  }


  /**
   * Remove WPAUTOP.
   */
  public function remove_wpautop() {
    if ( wp_ng_disable_wpautop() === true || wp_ng_enable_wpngautop() === true ) {
      remove_filter( 'acf_the_content', 'wpautop' );
      remove_filter( 'the_content', 'wpautop' );
      remove_filter( 'the_excerpt', 'wpautop' );
    }
  }

  /**
   * Add WPNGAUTOP.
   */
  public function add_wpngautop() {
    if ( wp_ng_enable_wpngautop() === true ) {
      add_filter ( 'the_content',     'wpngautop' );
      add_filter ( 'the_excerpt',     'wpngautop' );
      add_filter ( 'acf_the_content', 'wpngautop' );
    }
  }


}
