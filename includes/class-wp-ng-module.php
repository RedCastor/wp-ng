<?php

/**
 * Modules
 *
 * @link       http://redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */

/**
 * Modules
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Module {

  private $prefix;
  private $exclude_modules;

  private $scripts_src = array();
  private $styles_src = array();

  const HANDLE_NG_MODULE = 1;
  const HANDLE_NOT_NG_MODULE = 2;

  /**
   * @var Singleton
   * @access private
   * @static
   */
  private static $_instance = null;

  /**
   * Wp_Ng_Module constructor.
   */
  public function __construct() {

    $this->prefix = WP_NG_PLUGIN_NAME;
    $this->exclude_modules = $this->exclude_ng_modules();
  }

  /**
   *
   * @param string name
   * @return Singleton
   */
  public static function getInstance() {

    if(!self::$_instance) {
      self::$_instance = new Wp_Ng_Module();
    }

    return self::$_instance;
  }

  /**
   * Exclude modules
   *
   * @return mixed
   */
  public function exclude_ng_modules() {

    return apply_filters( 'wp_ng_exclude_handles_module', array(
      $this->prefix => true,
      $this->prefix . '_app' => true,
      wp_ng_get_app_name() => true,
    ));
  }

  /**
   * Add Default modules angular scripts
   *
   * @param $scripts
   */
  public function default_scripts ( &$scripts ) {

    $bower = new Wp_Ng_Bower();

    $scripts->add( 'wp-ng_bootstrap',     wp_ng_get_asset_path('scripts/bootstrap.js'), array( 'jquery' ), $bower->get_version('bootstrap'), 1 );
    $scripts->add( 'wp-ng_foundation',    wp_ng_get_asset_path('scripts/foundation.js'), array( 'jquery' ), $bower->get_version('foundation-sites'), 1 );

    $scripts->add( 'wp-ng_nemLogging', wp_ng_get_asset_path('scripts/angular-simple-logger.js'),  array( $this->prefix ), $bower->get_version('angular-simple-logger'),  1 );

    $scripts->add( 'wp-ng_ngResource',    wp_ng_get_asset_path('scripts/angular-resource.js'),  array( $this->prefix ), $bower->get_version('angular-resource'),  1 );

    $scripts->add( 'wp-ng_wpNgRest',      wp_ng_get_asset_path('scripts/wp-ng-rest.js'),        array( $this->prefix, 'wp-ng_ngResource' ), WP_NG_PLUGIN_VERSION,       1 );
    add_filter('wp_ng_wpNgRest_config', function ( $config ) {

      $defaults = array(
        'restUrl'     => get_rest_url(),
        'restPath'    => '/',
        'restNonceKey'=> 'X-Wp-Ng-Nonce',
        'restLangKey' => 'X-Wp-Ng-Lang',
        'restNonceVal'=> wp_create_nonce('wp_ng_rest'),
      );

      return array_merge($config, $defaults);
    });

    $scripts->add( 'wp-ng_ngAnimate',     wp_ng_get_asset_path('scripts/angular-animate.js'),   array( $this->prefix ), $bower->get_version('angular-animate'),   1 );
    $scripts->add( 'wp-ng_ngCookies',     wp_ng_get_asset_path('scripts/angular-cookies.js'),   array( $this->prefix ), $bower->get_version('angular-cookies'),   1 );
    $scripts->add( 'wp-ng_ngMessages',    wp_ng_get_asset_path('scripts/angular-messages.js'),  array( $this->prefix ), $bower->get_version('angular-messages'),  1 );
    $scripts->add( 'wp-ng_ngRoute',       wp_ng_get_asset_path('scripts/angular-route.js'),     array( $this->prefix ), $bower->get_version('angular-route'),     1 );
    $scripts->add( 'wp-ng_ngSanitize',    wp_ng_get_asset_path('scripts/angular-sanitize.js'),  array( $this->prefix ), $bower->get_version('angular-sanitize'),  1 );
    $scripts->add( 'wp-ng_ngTouch',       wp_ng_get_asset_path('scripts/angular-touch.js'),     array( $this->prefix ), $bower->get_version('angular-touch'),     1 );

    $scripts->add( 'wp-ng_mm.foundation', wp_ng_get_asset_path('scripts/angular-foundation-6.js'), array( $this->prefix ), $bower->get_version('angular-foundation-6'), 1 );

    $scripts->add( 'wp-ng_ui.bootstrap',  wp_ng_get_asset_path('scripts/angular-bootstrap.js'), array( $this->prefix ), $bower->get_version('angular-bootstrap'), 1 );
    $scripts->add( 'wp-ng_ui.router',     wp_ng_get_asset_path('scripts/angular-ui-router.js'), array( $this->prefix ), $bower->get_version('angular-ui-router'), 1 );
    $scripts->add( 'wp-ng_ui.grid',       wp_ng_get_asset_path('scripts/angular-ui-grid.js'),   array( $this->prefix, 'wp-ng_nemLogging' ), $bower->get_version('angular-ui-grid'), 1 );
    $scripts->add( 'wp-ng_ui.validate',       wp_ng_get_asset_path('scripts/angular-ui-validate.js'),   array( $this->prefix, 'wp-ng_nemLogging' ), $bower->get_version('angular-ui-validate'), 1 );

    $scripts->add( 'wp-ng_pascalprecht.translate', wp_ng_get_asset_path('scripts/angular-translate.js'), array( $this->prefix ), $bower->get_version('angular-translate'), 1 );
    $scripts->add( 'wp-ng_offClick',      wp_ng_get_asset_path('scripts/angular-off-click.js'), array( $this->prefix ), $bower->get_version('angular-off-click'), 1 );
    $scripts->add( 'wp-ng_nya.bootstrap.select', wp_ng_get_asset_path('scripts/nya-bootstrap-select.js'), array( $this->prefix ), $bower->get_version('nya-bootstrap-select'), 1 );
    $scripts->add( 'wp-ng_ngDialog',      wp_ng_get_asset_path('scripts/ng-dialog.js'),         array( $this->prefix ), $bower->get_version('ng-dialog'), 1 );
    $scripts->add( 'wp-ng_smoothScroll',  wp_ng_get_asset_path('scripts/ngSmoothScroll.js'),    array( $this->prefix ), $bower->get_version('ngSmoothScroll'), 1 );

    $scripts->add( 'wp-ng_ngScrollbars',  wp_ng_get_asset_path('scripts/ng-scrollbars.js'),     array( $this->prefix ), $bower->get_version('ng-scrollbars'), 1 );
    add_filter('wp_ng_ngScrollbars_config', function ( $config ) {

      $defaults = array(
        'defaults' => array(
          'scrollButtons' => array(
            'scrollAmount'  => 'auto',  // scroll amount when button pressed
            'enable'        => true,   // enable scrolling buttons by default
          ),
          'scrollInertia'     => 400,   // adjust however you want
          'axis'              => 'yx',  // enable 2 axis scrollbars by default,
          'theme'             => 'light',
          'autoHideScrollbar' => true,
        ),
      );

      return array_merge($config, $defaults);
    });

    $scripts->add( 'wp-ng_duScroll',      wp_ng_get_asset_path('scripts/angular-scroll.js'),    array( $this->prefix ), $bower->get_version('angular-scroll'), 1 );
    $scripts->add( 'wp-ng_slick',         wp_ng_get_asset_path('scripts/angular-slick.js'),     array( $this->prefix ), $bower->get_version('angular-slick'), 1 );
    $scripts->add( 'wp-ng_slickCarousel', wp_ng_get_asset_path('scripts/angular-slick-carousel.js'), array( $this->prefix ), $bower->get_version('angular-slick-carousel'), 1 );
    $scripts->add( 'wp-ng_ngInfiniteScroll', wp_ng_get_asset_path('scripts/ng-infinite-scroll.js'), array( $this->prefix ), $bower->get_version('ng-infinite-scroll'), 1 );
    $scripts->add( 'wp-ng_ui-leaflet',    wp_ng_get_asset_path('scripts/ui-leaflet.js'),        array( $this->prefix, 'wp-ng_nemLogging' ), $bower->get_version('ui-leaflet'), 1 );
    $scripts->add( 'wp-ng_pageslide-directive', wp_ng_get_asset_path('scripts/angular-pageslide-directive.js'), array( $this->prefix ), $bower->get_version('angular-pageslide-directive'), 1 );
    $scripts->add( 'wp-ng_ngGeonames',    wp_ng_get_asset_path('scripts/ng-geonames.js'),       array( $this->prefix ), $bower->get_version('ng-geonames'), 1 );
    $scripts->add( 'wp-ng_ngAntimoderate',wp_ng_get_asset_path('scripts/ng-antimoderate.js'),   array( $this->prefix ), $bower->get_version('ng-antimoderate'), 1 );

  }

  /**
   * Add Default modules angular styles
   *
   * @param $styles
   */
  public function default_styles ( &$styles ) {

    $bower = new Wp_Ng_Bower();

    $styles->add( 'wp-ng_ngAnimate.css', wp_ng_get_asset_path('styles/angular-animate-css.css'), array( $this->prefix ), $bower->get_version('angular-animate-css'), 'all' );

    $styles->add( 'wp-ng_bootstrap',    wp_ng_get_asset_path('styles/bootstrap.css'),           array(), $bower->get_version('bootstrap'), 'all' );
    $styles->add( 'wp-ng_foundation',   wp_ng_get_asset_path('styles/foundation.css'),          array(), $bower->get_version('foundation-sites'), 'all' );
    $styles->add( 'wp-ng_foundation-flex', wp_ng_get_asset_path('styles/foundation-flex.css'),  array(), $bower->get_version('foundation-sites'), 'all' );

    $styles->add( 'wp-ng_font-awesome', wp_ng_get_asset_path('styles/font-awesome.css'),        array(), $bower->get_version('font-awesome'), 'all' );
    $styles->add( 'wp-ng_nya.bootstrap.select', wp_ng_get_asset_path('styles/nya-bootstrap-select.css'), array( $this->prefix ), $bower->get_version('nya-bootstrap-select'), 'all' );
    $styles->add( 'wp-ng_ngDialog',     wp_ng_get_asset_path('styles/ng-dialog.css'),           array( $this->prefix ), $bower->get_version('ng-dialog'), 'all' );
    $styles->add( 'wp-ng_ngScrollbars', wp_ng_get_asset_path('styles/ng-scrollbars.css'), array( $this->prefix ), $bower->get_version('ng-scrollbars'), 'all' );
    $styles->add( 'wp-ng_slick',        wp_ng_get_asset_path('styles/slick-carousel.css'),      array( $this->prefix ), $bower->get_version('slick-carousel'), 'all' );
    $styles->add( 'wp-ng_slickCarousel', wp_ng_get_asset_path('styles/slick-carousel.css'),     array( $this->prefix ), $bower->get_version('slick-carousel'), 'all' );
    $styles->add( 'wp-ng_ui-leaflet',   wp_ng_get_asset_path('styles/leaflet.css'),             array( $this->prefix ), $bower->get_version('leaflet'), 'all' );
    $styles->add( 'wp-ng_pageslide-directive',   wp_ng_get_asset_path('styles/angular-pageslide-directive.css'),             array( $this->prefix ), $bower->get_version('angular-pageslide-directive'), 'all' );

  }

  /**
   * Get scripts src for all modules loaded
   * @return array
   */
  public function get_scripts_src() {
    return $this->scripts_src;
  }

  /**
   * Get styles src for all modules loaded
   * @return array
   */
  public function get_styles_src() {
    return $this->styles_src;
  }

  /**
   * Get the modules from enqueue script and deps and create scripts src array
   *
   * @return array
   */
  public function get_ng_module_from_handles_script() {
    global $wp_scripts;

    $wp_ng_handles = $this->get_ng_module_from_handles( $this->scripts_src, $wp_scripts );

    return apply_filters('wp_ng_register_handles_module', $wp_ng_handles);
  }

  /**
   * Get the modules from enqueue style and deps and create styles src array
   *
   * @return array
   */
  public function get_ng_module_from_handles_style() {
    global $wp_styles;

    $wp_ng_modules = $this->get_ng_module_from_handles( $this->styles_src, $wp_styles );

    return $wp_ng_modules;
  }

  /**
   * Get the modules from enqueue style and deps
   *
   * @param bool $style
   *
   * @return array
   */
  private function get_ng_module_from_handles( &$script_src, &$script ) {

    $ng_handles = array();
    $script_src = array();

    //Create an array with all handles
    foreach( $script->queue as $handle ) {
      $wp_ng_handles = $this->get_ng_module_from_handle( $handle, $script->registered, $script );
      foreach ( $wp_ng_handles as $wp_ng_handle => $type ) {

        if ( !isset($script_src[$wp_ng_handle]) && $type && isset($script->registered[$wp_ng_handle]) ) {
          $script_src[$wp_ng_handle] = $script->registered[$wp_ng_handle]->src;
        }

        $module_name = $this->get_ng_module_name($wp_ng_handle);
        if ( !in_array( $module_name, $ng_handles) && $type === self::HANDLE_NG_MODULE ) {
          $ng_modules = explode('+', $wp_ng_handle);

          foreach ( $ng_modules as $key => $ng_module ) {
            //Remove prefix handle for angular module name
            $ng_handles[] = $this->get_ng_module_name($ng_module );
          }
        }
      }
    }

    return $ng_handles;
  }


  public function get_ng_module_name ( $handle ) {
    return str_replace( $this->prefix . '_', '', $handle );
  }

  /**
   * Get modules from handle with recursive handle dependencies
   *
   * @param $handle
   * @param array $deps
   * @param bool $style
   *
   * @return array
   */
  public function get_ng_module_from_handle( $handle, $registered, &$script ) {

    $handles_ng_module = array();

    //Check deps
    foreach ($registered[ $handle ]->deps as $handle_dep) {
      if ( $this->is_handle_ng_module( $handle_dep, $script ) ) {
        $handles_ng_module = array_merge($handles_ng_module, $this->get_ng_module_from_handle( $handle_dep, $registered, $script) );
      }
    }

    $handles_ng_module[$handle] = $this->is_handle_ng_module( $handle, $script );

    return $handles_ng_module;
  }


  /**
   * Check if handle is a angular module
   *
   * @param $handle
   * @param bool $style
   *
   * @return bool
   */
  public function is_handle_ng_module ( $handle, &$script ) {

    //Check if style handle is registered
    if ( !isset($script->registered[$handle]) || (isset($this->exclude_modules[$handle]) && $this->exclude_modules[$handle] === true) ) {
      return 0;
    }

    if ( substr($handle, 0, strlen( $this->prefix )) === $this->prefix ) {
      if ( in_array($this->prefix, $script->registered[$handle]->deps) ) {
        return self::HANDLE_NG_MODULE;
      }

      return self::HANDLE_NOT_NG_MODULE;
    }

    return 0;
  }

}
