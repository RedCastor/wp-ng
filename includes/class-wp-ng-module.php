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


  public $prefix;

  private $exclude_handles_module = array();

  private $scripts_src = array();
  private $styles_src = array();

  const HANDLE_NOT_REGISTERED = 0;
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

  }

  /**
   *
   * @param string name
   * @return Singleton
   */
  public static function getInstance() {

    if(is_null(self::$_instance)) {
      self::$_instance = new Wp_Ng_Module();
    }

    return self::$_instance;
  }


  /**
   * Exclude modules
   *
   * @return mixed
   */
  public function exclude_handles_module() {

    return apply_filters( 'wp_ng_exclude_handles_module', array(
      $this->prefix => true,
      $this->prefix . '_app' => true,
      wp_ng_get_app_name() => true,
    ));
  }

  /**
   * Register new modules
   *
   * @since   1.1.0
   */
  public function register_module( $name, $scripts_src, $styles_src, $version = false ) {

    $handle_primary = $this->prefix . '_' . $name;

    if ( !is_array($scripts_src) ) {
      $scripts_src = array($scripts_src);
    }

    if ( !is_array($styles_src) ) {
      $styles_src = array($styles_src);
    }

    foreach ( $scripts_src as $script_src_key => $script_src ) {
      $handle_name = $handle_primary . (( !empty($script_src_key) ) ? '-' . $script_src_key : '');
      $deps = ($handle_name !== $handle_primary) ? array( $this->prefix, $handle_primary ) : array( $this->prefix );

      wp_register_script( $handle_name, $script_src, $deps, $version, true );
    }

    foreach ( $styles_src as $style_src_key => $style_src ) {
      $handle_name = $handle_primary . (( !empty($style_src_key) ) ? '-' . $style_src_key : '');
      $deps = ($handle_name !== $handle_primary) ? array( $this->prefix, $handle_primary ) : array( $this->prefix );

      wp_register_style( $handle_name, $style_src, $deps, $version, 'all' );
    }

  }

  /**
   * Add Default modules angular scripts
   *
   * @param $scripts
   */
  public function default_scripts ( &$scripts ) {

    $bower = new Wp_Ng_Bower();

    $scripts->add( 'wp-ng_bootstrap',     wp_ng_get_asset_path('scripts/bootstrap.js'),  array( 'jquery' ), $bower->get_version('bootstrap'), 1 );
    $scripts->add( 'wp-ng_foundation',    wp_ng_get_asset_path('scripts/foundation.js'), array( 'jquery' ), $bower->get_version('foundation-sites'), 1 );
    $scripts->add( 'wp-ng_mm.foundation-motion-ui',     wp_ng_get_asset_path('scripts/motion-ui.js'), array( 'jquery' ), $bower->get_version('motion-ui'), 1 );
    $scripts->add( 'wp-ng_slick-carousel',wp_ng_get_asset_path('scripts/slick-carousel.js'), array( 'jquery' ), $bower->get_version('slick-carousel'), 1 );
    $scripts->add( 'wp-ng_es6-shim',      wp_ng_get_asset_path('scripts/es6-shim.js'),  array(), $bower->get_version('es6-shim'), 1 );

    $scripts->add( 'wp-ng_pascalprecht.translate-static', wp_ng_get_asset_path('scripts/angular-translate-loader-static-files.js'), array( 'wp-ng_pascalprecht.translate' ), $bower->get_version('angular-translate-loader-static-files'), 1 );
    $scripts->add( 'wp-ng_pascalprecht.translate-cookie', wp_ng_get_asset_path('scripts/angular-translate-storage-cookie.js'),      array( 'wp-ng_pascalprecht.translate' ), $bower->get_version('angular-translate-storage-cookie'), 1 );

    //Leaflet Addons
    $scripts->add( 'wp-ng_ui-leaflet-layers', wp_ng_get_asset_path('scripts/ui-leaflet-layers.js'), array( 'wp-ng_ui-leaflet' ), $bower->get_version('ui-leaflet-layers'), 1 );
    $google_map_url = add_query_arg( apply_filters( 'wp_ng_ui-leaflet-layer-google_params', array('v' => '3')), 'http://maps.google.com/maps/api/js' );
    $scripts->add( 'wp-ng_ui-leaflet-layer-google', $google_map_url, array(), null, 1 );
    $scripts->add( 'wp-ng_ui-leaflet-awesome-markers', wp_ng_get_asset_path('scripts/leaflet-awesome-markers.js'), array( 'wp-ng_ui-leaflet' ), $bower->get_version('Leaflet.awesome-markers'), 1 );
    $scripts->add( 'wp-ng_ui-leaflet-vector-markers',  wp_ng_get_asset_path('scripts/leaflet-vector-markers.js'),  array( 'wp-ng_ui-leaflet' ), $bower->get_version('Leaflet.vector-markers'), 1 );


    $scripts->add( 'wp-ng_oc.lazyLoad',wp_ng_get_asset_path('scripts/oclazyload.js'),           array( $this->prefix ), $bower->get_version('oclazyload'), 1 );

    $scripts->add( 'wp-ng_nemLogging', wp_ng_get_asset_path('scripts/angular-simple-logger.js'),array( $this->prefix ), $bower->get_version('angular-simple-logger'), 1 );

    $scripts->add( 'wp-ng_ngResource', wp_ng_get_asset_path('scripts/angular-resource.js'),     array( $this->prefix ), $bower->get_version('angular-resource'), 1 );

    $scripts->add( 'wp-ng_wpNgRest',   wp_ng_get_asset_path('scripts/wp-ng-rest.js'),           array( $this->prefix, 'wp-ng_ngResource' ), WP_NG_PLUGIN_VERSION, 1 );
    add_filter('wp_ng_wpNgRest_config', function ( $config ) {

      $_lang = apply_filters('wp_ng_get_language', null);

      $defaults = array(
        'restUrl'     => get_rest_url(),
        'restPath'    => '/',
        'restNonceKey'=> 'X-WP-NG-Nonce',
        'restLangKey' => 'X-WP-NG-Lang',
        'restNonceVal'=> wp_create_nonce('wp_ng_rest'),
        'restLangVal' => $_lang['current'],
      );

      return array_merge($config, $defaults);
    });

    $scripts->add( 'wp-ng_ngAnimate',     wp_ng_get_asset_path('scripts/angular-animate.js'),   array( $this->prefix ), $bower->get_version('angular-animate'),   1 );
    $scripts->add( 'wp-ng_ngCookies',     wp_ng_get_asset_path('scripts/angular-cookies.js'),   array( $this->prefix ), $bower->get_version('angular-cookies'),   1 );
    $scripts->add( 'wp-ng_ngMessages',    wp_ng_get_asset_path('scripts/angular-messages.js'),  array( $this->prefix ), $bower->get_version('angular-messages'),  1 );
    $scripts->add( 'wp-ng_ngRoute',       wp_ng_get_asset_path('scripts/angular-route.js'),     array( $this->prefix ), $bower->get_version('angular-route'),     1 );
    $scripts->add( 'wp-ng_ngSanitize',    wp_ng_get_asset_path('scripts/angular-sanitize.js'),  array( $this->prefix ), $bower->get_version('angular-sanitize'),  1 );
    $scripts->add( 'wp-ng_ngTouch',       wp_ng_get_asset_path('scripts/angular-touch.js'),     array( $this->prefix ), $bower->get_version('angular-touch'),     1 );

    $scripts->add( 'wp-ng_breakpointApp', wp_ng_get_asset_path('scripts/angularjs-breakpoint.js'), array( $this->prefix ), $bower->get_version('angularjs-breakpoint'), 1 );
    $scripts->add( 'wp-ng_bs.screenSize', wp_ng_get_asset_path('scripts/bootstrap-screensize.js'), array( $this->prefix ), $bower->get_version('bootstrap-screensize'), 1 );

    $scripts->add( 'wp-ng_mm.foundation', wp_ng_get_asset_path('scripts/angular-foundation-6.js'), array( $this->prefix, 'wp-ng_es6-shim', 'wp-ng_ngTouch' ), $bower->get_version('angular-foundation-6'), 1 );
    add_filter('wp_ng_mm.foundation_config', function ( $config ) {
      $defaults = array(
        'init'    => true,
        'element' => 'body'
      );

      return array_merge($config, $defaults);
    });

    $scripts->add( 'wp-ng_ui.bootstrap',  wp_ng_get_asset_path('scripts/angular-bootstrap.js'), array( $this->prefix ), $bower->get_version('angular-bootstrap'), 1 );
    $scripts->add( 'wp-ng_ui.router',     wp_ng_get_asset_path('scripts/angular-ui-router.js'), array( $this->prefix ), $bower->get_version('angular-ui-router'), 1 );
    $scripts->add( 'wp-ng_ui.grid',       wp_ng_get_asset_path('scripts/angular-ui-grid.js'),   array( $this->prefix ), $bower->get_version('angular-ui-grid'), 1 );
    $scripts->add( 'wp-ng_ui.validate',   wp_ng_get_asset_path('scripts/angular-ui-validate.js'), array( $this->prefix ), $bower->get_version('angular-ui-validate'), 1 );
    $scripts->add( 'wp-ng_ui.mask',       wp_ng_get_asset_path('scripts/angular-ui-mask.js'),   array( $this->prefix ), $bower->get_version('angular-ui-mask'), 1 );
    $scripts->add( 'wp-ng_ui.select',     wp_ng_get_asset_path('scripts/angular-ui-select.js'), array( $this->prefix), $bower->get_version('angular-ui-select'), 1 );

    $scripts->add( 'wp-ng_pascalprecht.translate', wp_ng_get_asset_path('scripts/angular-translate.js'), array( $this->prefix ), $bower->get_version('angular-translate'), 1 );

    $scripts->add( 'wp-ng_offClick',      wp_ng_get_asset_path('scripts/angular-off-click.js'), array( $this->prefix ), $bower->get_version('angular-off-click'), 1 );
    $scripts->add( 'wp-ng_nya.bootstrap.select', wp_ng_get_asset_path('scripts/nya-bootstrap-select.js'), array( $this->prefix ), $bower->get_version('nya-bootstrap-select'), 1 );
    $scripts->add( 'wp-ng_ngDialog',      wp_ng_get_asset_path('scripts/ng-dialog.js'),         array( $this->prefix ), $bower->get_version('ng-dialog'), 1 );

    //Scroll
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
          'theme'             => 'dark',
          'autoHideScrollbar' => true,
        ),
      );

      return array_merge($config, $defaults);
    });

    $scripts->add( 'wp-ng_duScroll',      wp_ng_get_asset_path('scripts/angular-scroll.js'),    array( $this->prefix ), $bower->get_version('angular-scroll'), 1 );

    //Carousel
    $scripts->add( 'wp-ng_slick',         wp_ng_get_asset_path('scripts/angular-slick.js'),     array( $this->prefix, 'wp-ng_slick-carousel' ), $bower->get_version('angular-slick'), 1 );
    $scripts->add( 'wp-ng_slickCarousel', wp_ng_get_asset_path('scripts/angular-slick-carousel.js'), array( $this->prefix, 'wp-ng_slick-carousel' ), $bower->get_version('angular-slick-carousel'), 1 );

    //Upload
    $scripts->add( 'wp-ng_ngFileUpload', wp_ng_get_asset_path('scripts/ng-file-upload.js'), array( $this->prefix ), $bower->get_version('ng-file-upload'), 1 );

    //Local Storage
    $scripts->add( 'wp-ng_ngStorage', wp_ng_get_asset_path('scripts/ngstorage.js'), array( $this->prefix ), $bower->get_version('ngstorage'), 1 );

    //Progress or loading Bar
    $scripts->add( 'wp-ng_angular-loading-bar', wp_ng_get_asset_path('scripts/angular-loading-bar.js'), array( $this->prefix, 'wp-ng_ngAnimate' ), $bower->get_version('angular-loading-bar'), 1 );
    $scripts->add( 'wp-ng_angular-svg-round-progressbar', wp_ng_get_asset_path('scripts/angular-svg-round-progressbar.js'), array( $this->prefix ), $bower->get_version('angular-svg-round-progressbar'), 1 );
    $scripts->add( 'wp-ng_angularProgressbar', wp_ng_get_asset_path('scripts/angular-progressbar.js'), array( $this->prefix ), $bower->get_version('angular-progressbar'), 1 );


    //Editable
    $scripts->add( 'wp-ng_xeditable', wp_ng_get_asset_path('scripts/angular-xeditable.js'), array( $this->prefix ), $bower->get_version('angular-xeditable'), 1 );

    //Tag Input (Multi select)
    $scripts->add( 'wp-ng_ngTagsInput', wp_ng_get_asset_path('scripts/ng-tags-input.js'), array( $this->prefix ), $bower->get_version('ng-tags-input'), 1 );


    $scripts->add( 'wp-ng_infinite-scroll', wp_ng_get_asset_path('scripts/ngInfiniteScroll.js'), array( $this->prefix ), $bower->get_version('ngInfiniteScroll'), 1 );
    $scripts->add( 'wp-ng_ui-leaflet',    wp_ng_get_asset_path('scripts/ui-leaflet.js'),         array( $this->prefix, 'wp-ng_nemLogging' ), $bower->get_version('ui-leaflet'), 1 );
    $scripts->add( 'wp-ng_pageslide-directive', wp_ng_get_asset_path('scripts/angular-pageslide-directive.js'), array( $this->prefix ), $bower->get_version('angular-pageslide-directive'), 1 );
    $scripts->add( 'wp-ng_ngGeonames',    wp_ng_get_asset_path('scripts/ng-geonames.js'),        array( $this->prefix ), $bower->get_version('ng-geonames'), 1 );
    $scripts->add( 'wp-ng_ngAntimoderate',wp_ng_get_asset_path('scripts/ng-antimoderate.js'),    array( $this->prefix ), $bower->get_version('ng-antimoderate'), 1 );
    $scripts->add( 'wp-ng_ngColorUtils',  wp_ng_get_asset_path('scripts/ng-color-utils.js'),     array( $this->prefix ), $bower->get_version('ng-color-utils'), 1 );
    $scripts->add( 'wp-ng_socialLinks',   wp_ng_get_asset_path('scripts/angular-social-links.js'), array( $this->prefix ), $bower->get_version('angular-social-links'), 1 );
    $scripts->add( 'wp-ng_720kb.socialshare', wp_ng_get_asset_path('scripts/angular-socialshare.js'), array( $this->prefix ), $bower->get_version('angular-socialshare'), 1 );
    $scripts->add( 'wp-ng_ngMagnify',     wp_ng_get_asset_path('scripts/ng-magnify.js'),           array( $this->prefix ), $bower->get_version('ng-magnify'), 1 );

    $scripts->add( 'wp-ng_hl.sticky', wp_ng_get_asset_path('scripts/angular-sticky-plugin.js'), array( $this->prefix ), $bower->get_version('angular-sticky'), 1 );

    $scripts->add( 'wp-ng_focus-if',  wp_ng_get_asset_path('scripts/ng-focus-if.js'),           array( $this->prefix ), $bower->get_version('ng-focus-if'), 1 );

    $scripts->add( 'wp-ng_angularLazyImg', wp_ng_get_asset_path('scripts/angular-lazy-img.js'), array( $this->prefix ), $bower->get_version('angular-lazy-img'), 1 );

    $scripts->add( 'wp-ng_LiveSearch', wp_ng_get_asset_path('scripts/angular-livesearch.js'), array( $this->prefix ), $bower->get_version('angular-livesearch'), 1 );

    //Videogular
    $scripts->add( 'wp-ng_com.2fdevs.videogular', wp_ng_get_asset_path('scripts/videogular.js'), array( $this->prefix, 'wp-ng_ngSanitize' ), $bower->get_version('videogular'), 1 );
    $scripts->add( 'wp-ng_com.2fdevs.videogular.plugins.buffering',   wp_ng_get_asset_path('scripts/videogular-buffering.js'),    array( $this->prefix, 'wp-ng_com.2fdevs.videogular' ), $bower->get_version('videogular-buffering'), 1 );
    $scripts->add( 'wp-ng_com.2fdevs.videogular.plugins.controls',    wp_ng_get_asset_path('scripts/videogular-controls.js'),     array( $this->prefix, 'wp-ng_com.2fdevs.videogular' ), $bower->get_version('videogular-controls'), 1 );
    $scripts->add( 'wp-ng_com.2fdevs.videogular.plugins.overlayplay', wp_ng_get_asset_path('scripts/videogular-overlay-play.js'), array( $this->prefix, 'wp-ng_com.2fdevs.videogular' ), $bower->get_version('videogular-overlay-play'), 1 );
    $scripts->add( 'wp-ng_com.2fdevs.videogular.plugins.poster',      wp_ng_get_asset_path('scripts/videogular-poster.js'),       array( $this->prefix, 'wp-ng_com.2fdevs.videogular' ), $bower->get_version('videogular-poster'), 1 );
    $scripts->add( 'wp-ng_info.vietnamcode.nampnq.videogular.plugins.youtube', wp_ng_get_asset_path('scripts/videogular-youtube.js'), array( $this->prefix, 'wp-ng_com.2fdevs.videogular' ), $bower->get_version('bower-videogular-youtube'), 1 );
    $scripts->add( 'wp-ng_videogular.plugins.vimeo', wp_ng_get_asset_path('scripts/videogular-vimeo.js'), array( $this->prefix, 'wp-ng_com.2fdevs.videogular' ), $bower->get_version('videogular-vimeo'), 1 );

    //Authentication Satellizer
    $scripts->add( 'wp-ng_satellizer', wp_ng_get_asset_path('scripts/satellizer.js'), array( $this->prefix ), $bower->get_version('satellizer'), 1 );


  }

  /**
   * Add Default modules angular styles
   *
   * @param $styles
   */
  public function default_styles ( &$styles ) {

    $bower = new Wp_Ng_Bower();

    $styles->add( 'wp-ng_ngAnimate', wp_ng_get_asset_path('styles/angular-animate-css.css'), array( $this->prefix ), $bower->get_version('angular-animate-css'), 'all' );

    $styles->add( 'wp-ng_bootstrap', wp_ng_get_asset_path('styles/bootstrap.css'), array(), $bower->get_version('bootstrap'), 'all' );

    $styles->add( 'wp-ng_foundation',      wp_ng_get_asset_path('styles/foundation.css'),      array(), $bower->get_version('foundation-sites'), 'all' );
    $styles->add( 'wp-ng_foundation-flex', wp_ng_get_asset_path('styles/foundation-flex.css'), array(), $bower->get_version('foundation-sites'), 'all' );
    $styles->add( 'wp-ng_mm.foundation-motion-ui', wp_ng_get_asset_path('styles/motion-ui.css'),array(), $bower->get_version('motion-ui'), 'all' );
    $styles->add( 'wp-ng_mm.foundation-fix',  wp_ng_get_asset_path('styles/angular-foundation-fix.css'), array(), $bower->get_version('angular-foundation-6'), 'all' );


    $styles->add( 'wp-ng_font-awesome', wp_ng_get_asset_path('styles/font-awesome.css'), array(), $bower->get_version('font-awesome'), 'all' );

    $styles->add( 'wp-ng_ui-leaflet-awesome-markers', wp_ng_get_asset_path('styles/leaflet-awesome-markers.css'), array( 'wp-ng_ui-leaflet' ), $bower->get_version('Leaflet.awesome-markers'), 'all' );
    $styles->add( 'wp-ng_ui-leaflet-vector-markers',  wp_ng_get_asset_path('styles/leaflet-vector-markers.css'),  array( 'wp-ng_ui-leaflet' ), $bower->get_version('Leaflet.vector-markers'), 'all' );


    $styles->add( 'wp-ng_nya.bootstrap.select', wp_ng_get_asset_path('styles/nya-bootstrap-select.css'), array( $this->prefix ), $bower->get_version('nya-bootstrap-select'), 'all' );

    $styles->add( 'wp-ng_ngDialog',         wp_ng_get_asset_path('styles/ng-dialog.css'),         array( $this->prefix ), $bower->get_version('ng-dialog'), 'all' );

    $styles->add( 'wp-ng_ngMagnify',    wp_ng_get_asset_path('styles/ng-magnify.css'),          array( $this->prefix ), $bower->get_version('ng-magnify'), 'all' );
    $styles->add( 'wp-ng_ngScrollbars', wp_ng_get_asset_path('styles/ng-scrollbars.css'),       array( $this->prefix ), $bower->get_version('ng-scrollbars'), 'all' );

    //Carousel
    $styles->add( 'wp-ng_slick',        wp_ng_get_asset_path('styles/slick-carousel.css'),      array( $this->prefix ), $bower->get_version('slick-carousel'), 'all' );
    $styles->add( 'wp-ng_slick-theme',  wp_ng_get_asset_path('styles/slick-carousel-theme.css'),array( 'wp-ng_slick' ), $bower->get_version('slick-carousel'), 'all' );
    $styles->add( 'wp-ng_slickCarousel',wp_ng_get_asset_path('styles/slick-carousel.css'),      array( $this->prefix ), $bower->get_version('slick-carousel'), 'all' );
    $styles->add( 'wp-ng_slickCarousel-theme', wp_ng_get_asset_path('styles/slick-carousel-theme.css'), array( 'wp-ng_slickCarousel' ), $bower->get_version('slick-carousel'), 'all' );

    //Loading Bar
    $styles->add( 'wp-ng_angular-loading-bar',  wp_ng_get_asset_path('styles/angular-loading-bar.css'), array( $this->prefix ), $bower->get_version('angular-loading-bar'), 'all' );

    //Editable
    $styles->add( 'wp-ng_xeditable',  wp_ng_get_asset_path('styles/angular-xeditable.css'), array( $this->prefix ), $bower->get_version('angular-xeditable'), 'all' );

    //Tag Input (Multi select)
    $styles->add( 'wp-ng_ngTagsInput',  wp_ng_get_asset_path('styles/ng-tags-input.css'), array( $this->prefix ), $bower->get_version('ng-tags-input'), 'all' );

    //Map
    $styles->add( 'wp-ng_ui-leaflet',   wp_ng_get_asset_path('styles/leaflet.css'),             array( $this->prefix ), $bower->get_version('leaflet'), 'all' );

    $styles->add( 'wp-ng_pageslide-directive', wp_ng_get_asset_path('styles/angular-pageslide-directive.css'), array( $this->prefix ), $bower->get_version('angular-pageslide-directive'), 'all' );
    $styles->add( 'wp-ng_ui.grid',      wp_ng_get_asset_path('styles/angular-ui-grid.css'),   array( $this->prefix ), $bower->get_version('angular-ui-grid'), 'all' );
    $styles->add( 'wp-ng_ui.select',    wp_ng_get_asset_path('styles/angular-ui-select.css'), array( $this->prefix ), $bower->get_version('angular-ui-select'), 'all' );

    $styles->add( 'wp-ng_hl.sticky',    wp_ng_get_asset_path('styles/angular-sticky-plugin.css'), array( $this->prefix ), $bower->get_version('angular-sticky-plgin'), 'all' );

    $styles->add( 'wp-ng_LiveSearch',    wp_ng_get_asset_path('styles/angular-livesearch.css'), array( $this->prefix ), $bower->get_version('angular-livesearch'), 'all' );

    $styles->add( 'wp-ng_com.2fdevs.videogular', wp_ng_get_asset_path('styles/videogular.css'), array( $this->prefix ), $bower->get_version('videogular-themes-default'), 'all' );

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

    $ng_modules = $this->get_ng_modules_from_handles( $this->scripts_src, $wp_scripts );

    return $ng_modules;
  }

  /**
   * Get the modules from enqueue style and deps and create styles src array
   *
   * @return array
   */
  public function get_ng_module_from_handles_style() {
    global $wp_styles;

    $ng_modules = $this->get_ng_modules_from_handles( $this->styles_src, $wp_styles );

    return $ng_modules;
  }

  /**
   * Get the modules from enqueue style and deps
   *
   * @param bool $style
   *
   * @return array
   */
  private function get_ng_modules_from_handles( &$script_src, &$script ) {

    $ng_modules = array();
    $script_src = array();

    //Create an array with all handles
    foreach( $script->queue as $handle ) {
      $wp_ng_handles = $this->get_ng_module_from_handle( $handle, $script->registered, $script );
      foreach ( $wp_ng_handles as $wp_ng_handle => $type ) {

        if ( !isset($script_src[$wp_ng_handle]) && $type && isset($script->registered[$wp_ng_handle]) ) {
          $script_src[$wp_ng_handle] = $script->registered[$wp_ng_handle]->src;
        }

        $module_name = $this->get_ng_module_name($wp_ng_handle);
        if ( !in_array( $module_name, $ng_modules) && $type === self::HANDLE_NG_MODULE ) {
          $_ng_modules = explode('+', $wp_ng_handle);

          foreach ( $_ng_modules as $key => $_ng_module ) {
            //Remove prefix handle for angular module name
            $ng_modules[] = $this->get_ng_module_name($_ng_module );
          }
        }
      }
    }

    return $ng_modules;
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

    if ( isset( $registered[ $handle ] ) ) {

      //Check deps recursive call function
      foreach ($registered[ $handle ]->deps as $handle_dep) {
        if ( $this->is_handle_ng_module( $handle_dep, $script ) ) {
          $handles_ng_module = array_merge($handles_ng_module, $this->get_ng_module_from_handle( $handle_dep, $registered, $script) );
        }
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

    if ( empty($this->exclude_handles_module) ) {
      $this->exclude_handles_module = $this->exclude_handles_module();
    }

    //Check if style handle is registered
    if ( !isset($script->registered[$handle]) || (isset($this->exclude_handles_module[$handle]) && $this->exclude_handles_module[$handle] === true) ) {
      return self::HANDLE_NOT_REGISTERED;
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
