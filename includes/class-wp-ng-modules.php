<?php

/**
 * Modules Class
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
class Wp_Ng_Modules {


  public $prefix;

  private $exclude_handles_module = array();

  private $scripts_src = array();
  private $styles_src = array();

  const HANDLE_NOT_REGISTERED = 0;
  const HANDLE_NG_MODULE = 1;
  const HANDLE_NOT_NG_MODULE = 2;


  /** @var Wp_Ng_Emails The single instance of the class */
  protected static $_instance = null;

  /**
   *
   * @param string name
   * @return Singleton
   */
  public static function getInstance() {

    if(is_null(self::$_instance)) {
      self::$_instance = new self();
    }

    return self::$_instance;
  }


  /**
   * Cloning is forbidden.
   *
   * @since 1.4.2
   */
  public function __clone() {
    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wp-ng' ), '1.4.2' );
  }

  /**
   * Unserializing instances of this class is forbidden.
   *
   * @since 1.4.2
   */
  public function __wakeup() {
    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wp-ng' ), '1.4.2' );
  }


  /**
   * Wp_Ng_Modules constructor.
   */
  public function __construct() {

    $this->prefix = WP_NG_PLUGIN_NAME;

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

    $lang_code = apply_filters('wp_ng_current_language', '');
    $bower = new Wp_Ng_Bower();

    $scripts->add( 'wp-ng_bootstrap',     wp_ng_get_asset_path('scripts/bootstrap.js'),  array( 'jquery' ), $bower->get_version('bootstrap'), 1 );
    $scripts->add( 'wp-ng_foundation',    wp_ng_get_asset_path('scripts/foundation.js'), array( 'jquery' ), $bower->get_version('foundation-sites'), 1 );
    $scripts->add( 'wp-ng_mm.foundation-motion-ui',     wp_ng_get_asset_path('scripts/motion-ui.js'), array( 'jquery' ), $bower->get_version('motion-ui'), 1 );
    $scripts->add( 'wp-ng_slick-carousel',wp_ng_get_asset_path('scripts/slick-carousel.js'), array( 'jquery' ), $bower->get_version('slick-carousel'), 1 );
    $scripts->add( 'wp-ng_owl-carousel', wp_ng_get_asset_path('scripts/owl-carousel.js'), array( 'jquery' ), $bower->get_version('owl.carousel'), 1 );
    $scripts->add( 'wp-ng_photoswipe',wp_ng_get_asset_path('scripts/photoswipe.js'), array( 'jquery' ), $bower->get_version('photoswipe'), 1 );
    $scripts->add( 'wp-ng_es6-shim',      wp_ng_get_asset_path('scripts/es6-shim.js'),  array(), $bower->get_version('es6-shim'), 1 );
    $scripts->add( 'wp-ng_custom-event-polyfill', wp_ng_get_asset_path('scripts/custom-event-polyfill.js'), array(), $bower->get_version('custom-event-polyfill'), 1 );
    $scripts->add( 'wp-ng_mutationObserver-shim', wp_ng_get_asset_path('scripts/mutationObserver-shim.js'), array(), $bower->get_version('MutationObserver-shim'), 1 );
    $scripts->add( 'wp-ng_jquery.nicescroll', wp_ng_get_asset_path('scripts/jquery-nicescroll.js'), array('jquery'), $bower->get_version('jquery.nicescroll'), 1 );


    //Date Picker Input
    $scripts->add( 'wp-ng_flatpickr', wp_ng_get_asset_path('scripts/flatpickr.js'), array(), $bower->get_version('flatpickr'), 1 );
    $flatpickr_dep = array('wp-ng_flatpickr');
    if ($lang_code !== 'en') {
      $scripts->add( 'wp-ng_flatpickr-locale', wp_ng_get_asset_path("vendor/flatpickr/l10n/{$lang_code}.js"), array(), $bower->get_version('flatpickr'), 1 );
      $flatpickr_dep[] = 'wp-ng_flatpickr-locale';
    }

    //Translate
    $scripts->add( 'wp-ng_pascalprecht.translate-static', wp_ng_get_asset_path('scripts/angular-translate-loader-static-files.js'), array( 'wp-ng_pascalprecht.translate' ), $bower->get_version('angular-translate-loader-static-files'), 1 );
    $scripts->add( 'wp-ng_pascalprecht.translate-cookie', wp_ng_get_asset_path('scripts/angular-translate-storage-cookie.js'),      array( 'wp-ng_pascalprecht.translate' ), $bower->get_version('angular-translate-storage-cookie'), 1 );


    //Leaflet Addons
    $scripts->add( 'wp-ng_ui-leaflet-layers', wp_ng_get_asset_path('scripts/ui-leaflet-layers.js'), array( 'wp-ng_ui-leaflet' ), $bower->get_version('ui-leaflet-layers'), 1 );

    $google_map_protocol = (is_ssl() ? 'https' : 'http');
    $google_map_version = wp_ng_get_module_option( 'google_map_version', 'wp-ng_ui-leaflet', '');
    $google_map_key = wp_ng_get_module_option( 'google_map_key', 'wp-ng_ui-leaflet', '');
    $google_map_url = add_query_arg( apply_filters( 'wp_ng_ui-leaflet-layer-google_params', array('v' => $google_map_version, 'key' => $google_map_key)), $google_map_protocol . '://maps.google.com/maps/api/js' );
    $scripts->add( 'wp-ng_ui-leaflet-layer-google', $google_map_url, array(), null, 1 );
    $scripts->add( 'wp-ng_ui-leaflet-awesome-markers', wp_ng_get_asset_path('scripts/leaflet-awesome-markers.js'), array( 'wp-ng_ui-leaflet' ), $bower->get_version('Leaflet.awesome-markers'), 1 );
    $scripts->add( 'wp-ng_ui-leaflet-vector-markers',  wp_ng_get_asset_path('scripts/leaflet-vector-markers.js'),  array( 'wp-ng_ui-leaflet' ), $bower->get_version('Leaflet.vector-markers'), 1 );

    //Logging
    $scripts->add( 'wp-ng_rcRollbar', wp_ng_get_asset_path('scripts/rc-rollbar.js'),  array( $this->prefix ), $bower->get_version('rc-rollbar'), 1 );
    add_filter('wp_ng_rcRollbar_config', function ( $config ) {

      $options = wp_ng_get_module_options( 'wp-ng_rcRollbar' );

      $defaults = array(
        'accessToken' => isset($options['access_token']) ? $options['access_token'] : '',
        'captureUncaught' => true,
        //'rollbarJsUrl' => 'https://cdnjs.cloudflare.com/ajax/libs/rollbar.js/2.1.0/rollbar.min.js',
        'enableLogLevel' => array(
          'error' => (isset($options['track_error']) && $options['track_error'] === 'on') ? true : false,
          'warning' => (isset($options['track_warning']) && $options['track_warning'] === 'on')? true : false,
          'debug' => (isset($options['track_debug']) && $options['track_debug'] === 'on') ? true : false,
          'info' => (isset($options['track_info']) && $options['track_info'] === 'on') ? true : false,
        ),
        'payload' => array(
          'code_version' => wp_ng_logger()->get_code_version(),
        ),
      );

      //Set log to logged user
      if ( is_user_logged_in() ) {
        $user = wp_get_current_user();

        $defaults['payload']['person'] = array(
          'id' => (string) $user->ID,
          'username' => $user->user_login,
          'email' => $user->user_email,
        );
      }

      return wp_parse_args($config, $defaults);
    });

    $scripts->add( 'wp-ng_angular-json-pretty', wp_ng_get_asset_path('scripts/angular-json-pretty.js'),  array( $this->prefix ), $bower->get_version('angular-json-pretty'), 1 );

    $scripts->add( 'wp-ng_oc.lazyLoad',wp_ng_get_asset_path('scripts/oclazyload.js'),           array( $this->prefix ), $bower->get_version('oclazyload'), 1 );
    add_filter('wp_ng_oc.lazyLoad_config', function ( $config ) {

      $defaults = array(
        'debug' => false,
        'events' => true,
        'modules' => array(),
      );

      return wp_parse_args($config, $defaults);
    });

    $scripts->add( 'wp-ng_nemLogging', wp_ng_get_asset_path('scripts/angular-simple-logger.js'),array( $this->prefix ), $bower->get_version('angular-simple-logger'), 1 );

    $scripts->add( 'wp-ng_ngResource', wp_ng_get_asset_path('scripts/angular-resource.js'),     array( $this->prefix ), $bower->get_version('angular-resource'), 1 );

    $scripts->add( 'wp-ng_wpNgRest',   wp_ng_get_asset_path('scripts/wp-ng-rest.js'),   array( $this->prefix, 'wp-ng_ngResource' ), WP_NG_PLUGIN_VERSION, 1 );
    add_filter('wp_ng_wpNgRest_config', function ( $config ) {

      $_lang = wp_ng_get_language();

      $defaults = array(
        'restUrl'     => get_rest_url(),
        'restPath'    => '',
        'restNonceKey'=> 'X-WP-NG-Nonce',
        'restLangKey' => 'X-WP-NG-Lang',
        'restNonceVal'=> wp_create_nonce('wp_ng_rest'),
        'restLangVal' => $_lang['current'],
      );

      return wp_parse_args($config, $defaults);
    });

    $scripts->add( 'wp-ng_isoCurrencies',   wp_ng_get_asset_path('scripts/iso-currencies.js'), array( $this->prefix ), WP_NG_PLUGIN_VERSION, 1 );
    add_filter('wp_ng_isoCurrencies_config', function ( $config ) {

      $defaults = array();

      //Set Woocommerce config currency
      if (function_exists('get_woocommerce_currency')) {
        $defaults['code'] = get_woocommerce_currency();
      }

      if (function_exists('wc_get_price_decimals')) {
        $defaults['fraction'] = wc_get_price_decimals();
      }

      if (function_exists('get_woocommerce_currency_symbol')) {
        $defaults['symbol'] = html_entity_decode(get_woocommerce_currency_symbol());
      }

      if (!empty(get_option( 'woocommerce_currency_pos' ))) {
        $defaults['position'] = get_option( 'woocommerce_currency_pos' );
      }

      if (function_exists('wc_get_price_decimal_separator')) {
        $defaults['decimalSep'] = wc_get_price_decimal_separator();
      }

      if (function_exists('wc_get_price_thousand_separator')) {
        $defaults['thousandSep'] = wc_get_price_thousand_separator();
      }

      return wp_parse_args($config, $defaults);
    });

    $scripts->add( 'wp-ng_ngAnimate',     wp_ng_get_asset_path('scripts/angular-animate.js'),   array( $this->prefix ), $bower->get_version('angular-animate'),   1 );
    $scripts->add( 'wp-ng_ngCookies',     wp_ng_get_asset_path('scripts/angular-cookies.js'),   array( $this->prefix ), $bower->get_version('angular-cookies'),   1 );
    $scripts->add( 'wp-ng_ngMessages',    wp_ng_get_asset_path('scripts/angular-messages.js'),  array( $this->prefix ), $bower->get_version('angular-messages'),  1 );
    $scripts->add( 'wp-ng_ngRoute',       wp_ng_get_asset_path('scripts/angular-route.js'),     array( $this->prefix ), $bower->get_version('angular-route'),     1 );
    $scripts->add( 'wp-ng_ngSanitize',    wp_ng_get_asset_path('scripts/angular-sanitize.js'),  array( $this->prefix ), $bower->get_version('angular-sanitize'),  1 );
    $scripts->add( 'wp-ng_ngTouch',       wp_ng_get_asset_path('scripts/angular-touch.js'),     array( $this->prefix ), $bower->get_version('angular-touch'),     1 );

    //Utils
    $scripts->add( 'wp-ng_breakpointApp', wp_ng_get_asset_path('scripts/angularjs-breakpoint.js'), array( $this->prefix ), $bower->get_version('angularjs-breakpoint'), 1 );
    $scripts->add( 'wp-ng_bs.screenSize', wp_ng_get_asset_path('scripts/bootstrap-screensize.js'), array( $this->prefix ), $bower->get_version('bootstrap-screensize'), 1 );
    $scripts->add( 'wp-ng_ismobile',      wp_ng_get_asset_path('scripts/angular-ismobile.js'),     array( $this->prefix ), $bower->get_version('angular-ismobile'), 1 );
    $scripts->add( 'wp-ng_angular-inview',wp_ng_get_asset_path('scripts/angular-inview.js'),       array( $this->prefix ), $bower->get_version('angular-inview'), 1 );


    $scripts->add( 'wp-ng_mm.foundation', wp_ng_get_asset_path('scripts/angular-foundation-6.js'), array( $this->prefix, 'wp-ng_es6-shim', 'wp-ng_ngTouch' ), $bower->get_version('angular-foundation-6'), 1 );
    add_filter('wp_ng_mm.foundation_config', function ( $config ) {
      $defaults = array(
        'init'    => true,
        'element' => 'body'
      );

      return wp_parse_args($config, $defaults);
    });

    $scripts->add( 'wp-ng_ui.bootstrap',  wp_ng_get_asset_path('scripts/angular-bootstrap.js'), array( $this->prefix ), $bower->get_version('angular-bootstrap'), 1 );
    $scripts->add( 'wp-ng_router', wp_ng_get_asset_path('scripts/wp-ng-router.js'), array(), WP_NG_PLUGIN_VERSION, 1 );
    $scripts->add( 'wp-ng_ui.router',     wp_ng_get_asset_path('scripts/angular-ui-router.js'), array( $this->prefix, 'wp-ng_router' ), $bower->get_version('angular-ui-router'), 1 );
    add_filter('wp_ng_ui.router_config', function ( $config ) {

      $options = wp_ng_get_module_options( 'wp-ng_ui.router' );

      $wrap = false;

      //Wrap only on base url
      if ( wp_ng_get_base_url() === wp_ng_get_current_url() ) {
        $wrap = (isset($options['wrap'])) ? $options['wrap'] : '#main';
      }

      $defaults = array(
        'preventState'  => array(
          'enable'        => (isset($options['prevent_base_url']) && $options['prevent_base_url'] === 'on') ? true : false,
        ),
        'wrap_enable'   => is_front_page(),
        'wrap'          => $wrap,
        'wrap_exclude'  => (isset($options['wrap_exclude'])) ? $options['wrap_exclude'] : '',
        'templates'     => array(
          'notFound'      => wp_ng_get_template( 'global/ui-router-not-found.php', null, null, false ),
          'base'          => wp_ng_get_template( 'global/ui-router-base.php', null, null, false ),
          'wrapperStart'  => wp_ng_get_template( 'global/wrapper-ui-router-start.php', null, null, false ),
          'wrapperEnd'    => wp_ng_get_template( 'global/wrapper-ui-router-end.php', null, null, false )
        ),
        'states'          => Wp_Ng_Public_Ui_Router::get_ng_router_states(),
      );

      return wp_parse_args($config, $defaults);
    });

    $scripts->add( 'wp-ng_ui.grid',       wp_ng_get_asset_path('scripts/angular-ui-grid.js'),   array( $this->prefix ), $bower->get_version('angular-ui-grid'), 1 );
    $scripts->add( 'wp-ng_ui.validate',   wp_ng_get_asset_path('scripts/angular-ui-validate.js'), array( $this->prefix ), $bower->get_version('angular-ui-validate'), 1 );
    $scripts->add( 'wp-ng_ui.mask',       wp_ng_get_asset_path('scripts/angular-ui-mask.js'),   array( $this->prefix ), $bower->get_version('angular-ui-mask'), 1 );
    $scripts->add( 'wp-ng_ui.select',     wp_ng_get_asset_path('scripts/angular-ui-select.js'), array( $this->prefix), $bower->get_version('angular-ui-select'), 1 );
    $scripts->add( 'wp-ng_ui.select.zf6', wp_ng_get_asset_path('scripts/ui-select-zf6.js'),     array( $this->prefix, 'wp-ng_ui.select'), $bower->get_version('ui-select-zf6'), 1 );
    add_filter('wp_ng_ui.select_config', function ( $config ) {

      $defaults = array(
        'theme' => 'selectize'
      );

      return wp_parse_args($config, $defaults);
    });
    $scripts->add( 'wp-ng_checklist-model', wp_ng_get_asset_path('scripts/angular-checklist-model.js'),   array( $this->prefix ), $bower->get_version('checklist-model'), 1 );

    $scripts->add( 'wp-ng_ui.swiper', wp_ng_get_asset_path('scripts/angular-ui-swiper.js'), array( $this->prefix ), $bower->get_version('angular-ui-swiper'), 1 );
    $scripts->add( 'wp-ng_ui.event', wp_ng_get_asset_path('scripts/angular-ui-event.js'), array( $this->prefix ), $bower->get_version('angular-ui-event'), 1 );


    //Password Trust
    $scripts->add( 'wp-ng_trTrustpass',   wp_ng_get_asset_path('scripts/angular-trustpass.js'), array( $this->prefix ), $bower->get_version('angular-trustpass'), 1 );


    $scripts->add( 'wp-ng_pascalprecht.translate', wp_ng_get_asset_path('scripts/angular-translate.js'), array( $this->prefix ), $bower->get_version('angular-translate'), 1 );

    $scripts->add( 'wp-ng_offClick',      wp_ng_get_asset_path('scripts/angular-off-click.js'), array( $this->prefix ), $bower->get_version('angular-off-click'), 1 );
    $scripts->add( 'wp-ng_nya.bootstrap.select', wp_ng_get_asset_path('scripts/nya-bootstrap-select.js'), array( $this->prefix ), $bower->get_version('nya-bootstrap-select'), 1 );
    $scripts->add( 'wp-ng_oi.select', wp_ng_get_asset_path('scripts/oi-select.js'), array( $this->prefix ), $bower->get_version('oi.select'), 1 );

    $scripts->add( 'wp-ng_ngDialog',      wp_ng_get_asset_path('scripts/ng-dialog.js'),         array( $this->prefix ), $bower->get_version('ng-dialog'), 1 );

    //Scroll Bar
    $scripts->add( 'wp-ng_smoothScroll_by_id', wp_ng_get_asset_path('scripts/wp-ng-smoothScroll.js'), array(), WP_NG_PLUGIN_VERSION, 1 );
    $scripts->add( 'wp-ng_smoothScroll',  wp_ng_get_asset_path('scripts/ngSmoothScroll.js'),    array( $this->prefix, 'wp-ng_smoothScroll_by_id' ), $bower->get_version('ngSmoothScroll'), 1 );
    add_filter('wp_ng_smoothScroll_config', function ( $config ) {

      $options = wp_ng_get_module_options( 'wp-ng_smoothScroll' );

      $defaults = array(
        'scroll_by_id'  => (isset($options['scroll_by_id']) && $options['scroll_by_id'] === 'on') ? true : false,
        'easing'        => (isset($options['easing'])) ? $options['easing'] : '',
        'duration'      => (isset($options['duration'])) ? absint($options['duration']) : 800,
        'offset'        => (isset($options['offset'])) ? absint($options['offset']) : 0,
        'offset_selector' => (isset($options['offset_selector'])) ? $options['offset_selector'] : '',
      );

      return wp_parse_args($config, $defaults);
    });


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

      return wp_parse_args($config, $defaults);
    });
    $scripts->add( 'wp-ng_angular-nicescroll',  wp_ng_get_asset_path('scripts/angular-nicescroll.js'),    array( $this->prefix, 'wp-ng_jquery.nicescroll' ), $bower->get_version('angular-nicescroll'), 1 );

    //Scroll
    $scripts->add( 'wp-ng_ngScrollSpy',  wp_ng_get_asset_path('scripts/ng-ScrollSpy.js'),    array( $this->prefix ), $bower->get_version('ng-ScrollSpy.js'), 1 );
    $scripts->add( 'wp-ng_snapscroll',  wp_ng_get_asset_path('scripts/angular-snapscroll.js'),    array( $this->prefix ), $bower->get_version('angular-snapscroll'), 1 );
    $scripts->add( 'wp-ng_duScroll', wp_ng_get_asset_path('scripts/angular-scroll.js'), array( $this->prefix ), $bower->get_version('angular-scroll'), 1 );
    $scripts->add( 'wp-ng_ngTinyScrollbar', wp_ng_get_asset_path('scripts/ng-tiny-scrollbar.js'), array( $this->prefix, 'wp-ng_mutationObserver-shim' ), $bower->get_version('ngTinyScrollbar'), 1 );

    $scripts->add( 'wp-ng_swipe',  wp_ng_get_asset_path('scripts/angular-swipe.js'),    array( $this->prefix ), $bower->get_version('angular-swipe'), 1 );
    $scripts->add( 'wp-ng_angular.vertilize', wp_ng_get_asset_path('scripts/angular-vertilize.js'), array( $this->prefix ), $bower->get_version('angular-vertilize'), 1 );

    //Image Gallery and Carousel
    $scripts->add( 'wp-ng_slick',         wp_ng_get_asset_path('scripts/angular-slick.js'),     array( $this->prefix, 'wp-ng_slick-carousel' ), $bower->get_version('angular-slick'), 1 );
    $scripts->add( 'wp-ng_slickCarousel', wp_ng_get_asset_path('scripts/angular-slick-carousel.js'), array( $this->prefix, 'wp-ng_slick-carousel' ), $bower->get_version('angular-slick-carousel'), 1 );

    $scripts->add( 'wp-ng_angular-owl-carousel-2', wp_ng_get_asset_path('scripts/angular-owl-carousel2.js'), array( $this->prefix, 'wp-ng_owl-carousel' ), $bower->get_version('angular-owl-carousel2'), 1 );
    $scripts->add( 'wp-ng_angularGrid', wp_ng_get_asset_path('scripts/angulargrid.js'), array( $this->prefix ), $bower->get_version('angulargrid'), 1 );

    $scripts->add( 'wp-ng_rcGallery', wp_ng_get_asset_path('scripts/rc-gallery.js'), array( $this->prefix ), $bower->get_version('rc-gallery'), 1 );
    $scripts->add( 'wp-ng_rcGalleryUnitegallery', wp_ng_get_asset_path('scripts/rc-gallery-unitegallery.js'), array( $this->prefix, 'wp-ng_rcGallery' ), $bower->get_version('rc-gallery-unitegallery'), 1 );
    add_filter('wp_ng_rcGalleryUnitegallery_config', function ( $config ) {

      $options = wp_ng_get_module_options( 'wp-ng_rcGallery');

      $urls = array();

      //Configure module with source library and theme.
      if ( !empty($options['scriptUnitegallery']) ) {

        $urls = array(
          wp_ng_get_asset_path('vendor/unitegallery/js/unitegallery.min.js'),
          wp_ng_get_asset_path('vendor/unitegallery/css/unitegallery.min.css'),
        );

        //Load selected themes
        if ( isset($options['admin_gallery_themes_unitegallery']) && is_array($options['admin_gallery_themes_unitegallery']) ) {
          foreach ($options['admin_gallery_themes_unitegallery'] as $name) {
            $urls[] = wp_ng_get_asset_path("vendor/unitegallery/themes/{$name}/unitegallery.{$name}.min.js");

            if ($name === 'video' || $name === 'default') {
              $urls[] = wp_ng_get_asset_path("vendor/unitegallery/themes/{$name}/unitegallery.{$name}.min.css");
            }
          }
        }
      }


      $defaults = array(
        'urls' => $urls,
      );

      return wp_parse_args($config, $defaults);
    });
    $scripts->add( 'wp-ng_rcGalleryGalleria',     wp_ng_get_asset_path('scripts/rc-gallery-galleria.js'),     array( $this->prefix, 'wp-ng_rcGallery' ), $bower->get_version('rc-gallery-galleria'), 1 );
    add_filter('wp_ng_rcGalleryGalleria_config', function ( $config ) {

      $options = wp_ng_get_module_options( 'wp-ng_rcGallery');

      $urls = array();
      $theme_urls = array();

      //Configure module with source library and theme.
      if ( !empty($options['scriptGalleria']) ) {

        $urls = array(
          wp_ng_get_asset_path('vendor/galleria/galleria.min.js'),
        );

        //Load selected themes
        if ( isset($options['admin_gallery_themes_galleria']) && is_array($options['admin_gallery_themes_galleria']) ) {
          foreach ($options['admin_gallery_themes_galleria'] as $name) {
            $theme_urls[] = wp_ng_get_asset_path("vendor/galleria/themes/{$name}/galleria.{$name}.min.js");

            if ($name === 'video' || $name === 'default') {
              $theme_urls[] = wp_ng_get_asset_path("vendor/galleria/themes/{$name}/galleria.{$name}.min.css");
            }
          }
        }
      }


      $defaults = array(
        'urls' => $urls,
        'themeUrls' => $theme_urls,
      );


      return wp_parse_args($config, $defaults);
    });

    $scripts->add( 'wp-ng_rcGalleria', wp_ng_get_asset_path('scripts/rc-galleria.js'), array( $this->prefix ), $bower->get_version('rc-galleria'), 1 );
    add_filter('wp_ng_rcGalleria_config', function ( $config ) {
      $defaults = array(
        'path'     => wp_ng_get_asset_path('vendor/galleria/themes'),
        'theme'    => 'classic',
        'options'  => array()
      );

      return wp_parse_args($config, $defaults);
    });


    //Upload
    $scripts->add( 'wp-ng_ngFileUpload', wp_ng_get_asset_path('scripts/ng-file-upload.js'), array( $this->prefix ), $bower->get_version('ng-file-upload'), 1 );

    //Local Storage
    $scripts->add( 'wp-ng_ngStorage', wp_ng_get_asset_path('scripts/ngstorage.js'), array( $this->prefix ), $bower->get_version('ngstorage'), 1 );

    //Progress or loading Bar
    $scripts->add( 'wp-ng_angular-loading-bar', wp_ng_get_asset_path('scripts/angular-loading-bar.js'), array( $this->prefix, 'wp-ng_ngAnimate' ), $bower->get_version('angular-loading-bar'), 1 );
    $scripts->add( 'wp-ng_angular-svg-round-progressbar', wp_ng_get_asset_path('scripts/angular-svg-round-progressbar.js'), array( $this->prefix ), $bower->get_version('angular-svg-round-progressbar'), 1 );
    $scripts->add( 'wp-ng_angularProgressbar', wp_ng_get_asset_path('scripts/angular-progressbar.js'), array( $this->prefix ), $bower->get_version('angular-progressbar'), 1 );
    $scripts->add( 'wp-ng_angularjs-gauge', wp_ng_get_asset_path('scripts/angularjs-gauge.js'), array( $this->prefix ), $bower->get_version('angularjs-gauge'), 1 );

    //Editable
    $scripts->add( 'wp-ng_xeditable', wp_ng_get_asset_path('scripts/angular-xeditable.js'), array( $this->prefix ), $bower->get_version('angular-xeditable'), 1 );

    //Tag Input (Multi select)
    $scripts->add( 'wp-ng_ngTagsInput', wp_ng_get_asset_path('scripts/ng-tags-input.js'), array( $this->prefix ), $bower->get_version('ng-tags-input'), 1 );


    $scripts->add( 'wp-ng_infinite-scroll', wp_ng_get_asset_path('scripts/ngInfiniteScroll.js'), array( $this->prefix ), $bower->get_version('ngInfiniteScroll'), 1 );
    $scripts->add( 'wp-ng_ui-leaflet',    wp_ng_get_asset_path('scripts/ui-leaflet.js'),         array( $this->prefix, 'wp-ng_nemLogging' ), $bower->get_version('ui-leaflet'), 1 );
    $scripts->add( 'wp-ng_pageslide-directive', wp_ng_get_asset_path('scripts/angular-pageslide-directive.js'), array( $this->prefix ), $bower->get_version('angular-pageslide-directive'), 1 );
    $scripts->add( 'wp-ng_ngGeonames',    wp_ng_get_asset_path('scripts/ng-geonames.js'),        array( $this->prefix ), $bower->get_version('ng-geonames'), 1 );
    $scripts->add( 'wp-ng_ngAntimoderate',wp_ng_get_asset_path('scripts/ng-antimoderate.js'),    array( $this->prefix ), $bower->get_version('ng-antimoderate'), 1 );
    add_filter('wp_ng_ngAntimoderate_config', function ( $config ) {

      $defaults = array(
        'src' => array(
          'error' => wp_ng_get_asset_path('images/not-found-02.svg'),
        )
      );

      return wp_parse_args($config, $defaults);
    });

    $scripts->add( 'wp-ng_ngColorUtils',  wp_ng_get_asset_path('scripts/ng-color-utils.js'),     array( $this->prefix ), $bower->get_version('ng-color-utils'), 1 );

    //Sahre social
    $scripts->add( 'wp-ng_socialLinks',   wp_ng_get_asset_path('scripts/angular-social-links.js'), array( $this->prefix ), $bower->get_version('angular-social-links'), 1 );
    $scripts->add( 'wp-ng_720kb.socialshare', wp_ng_get_asset_path('scripts/angular-socialshare.js'), array( $this->prefix ), $bower->get_version('angular-socialshare'), 1 );
    add_filter('wp_ng_720kb.socialshare_config', function ( $config ) {
      global $post;

      $defaults = array();

      if ( $post ) {

        $options = wp_ng_get_module_options( 'wp-ng_720kb.socialshare' );

        $providers = array('facebook', 'twitter', 'google', 'pinterest', 'linkedin', 'tumblr', 'buffer', 'wordpress', 'whatsapp', 'viber', 'skype', 'telegram');
        $url = get_permalink( $post->ID );
        $text = get_the_title( $post->ID );
        $media = site_url( get_the_post_thumbnail_url( $post->ID, 'medium') );


        foreach ( $providers as $provider ) {

          $via = false;

          switch ($provider) {
            case 'facebook':
              $via = isset($options['via_facebook']) ? $options['via_facebook'] : false;
              break;
            case 'twitter':
              $via = isset($options['via_twitter']) ? $options['via_twitter'] : false;
              break;
            case 'telegram':
            case 'whatsapp':
            case 'viber':
            case 'skype':
              $media = false;
              break;
          }

          $conf = array(
            'url' => $url,
            'text' => $text,
            'media' => $media,
          );

          if ($via) {
            $conf['via'] = $via;
          }

          $defaults[] = array(
            'provider' => $provider,
            'conf'     => $conf,
          );
        }

      }

      return wp_parse_args($config, $defaults);
    });

    //Tooltips
    $scripts->add( 'wp-ng_720kb.tooltips', wp_ng_get_asset_path('scripts/angular-tooltips.js'), array( $this->prefix ), $bower->get_version('angular-tooltips'), 1 );

    //Image Magnify
    $scripts->add( 'wp-ng_ngMagnify', wp_ng_get_asset_path('scripts/ng-magnify.js'), array( $this->prefix ), $bower->get_version('ng-magnify'), 1 );

    //Sticky
    $scripts->add( 'wp-ng_hl.sticky',       wp_ng_get_asset_path('scripts/angular-sticky-plugin.js'), array( $this->prefix ), $bower->get_version('angular-sticky'), 1 );
    $scripts->add( 'wp-ng_ngStickyFooter',  wp_ng_get_asset_path('scripts/ng-sticky-footer.js'), array( $this->prefix, 'wp-ng_mutationObserver-shim' ), $bower->get_version('ng-sticky-footer'), 1 );

    $scripts->add( 'wp-ng_focus-if', wp_ng_get_asset_path('scripts/ng-focus-if.js'), array( $this->prefix ), $bower->get_version('ng-focus-if'), 1 );
    $scripts->add( 'wp-ng_ngInput',  wp_ng_get_asset_path('scripts/ng-input.js'),    array( $this->prefix ), $bower->get_version('ng-input'), 1 );

    $scripts->add( 'wp-ng_angularLazyImg', wp_ng_get_asset_path('scripts/angular-lazy-img.js'), array( $this->prefix ), $bower->get_version('angular-lazy-img'), 1 );

    $scripts->add( 'wp-ng_LiveSearch', wp_ng_get_asset_path('scripts/angular-livesearch.js'), array( $this->prefix ), $bower->get_version('angular-livesearch'), 1 );

    //Videogular
    $scripts->add( 'wp-ng_com.2fdevs.videogular', wp_ng_get_asset_path('scripts/videogular.js'), array( $this->prefix, 'wp-ng_custom-event-polyfill', 'wp-ng_ngSanitize' ), $bower->get_version('rc-videogular'), 1 );
    $scripts->add( 'wp-ng_com.2fdevs.videogular.plugins.buffering',   wp_ng_get_asset_path('scripts/videogular-buffering.js'),    array( $this->prefix, 'wp-ng_com.2fdevs.videogular' ), $bower->get_version('rc-videogular'), 1 );
    $scripts->add( 'wp-ng_com.2fdevs.videogular.plugins.controls',    wp_ng_get_asset_path('scripts/videogular-controls.js'),     array( $this->prefix, 'wp-ng_com.2fdevs.videogular' ), $bower->get_version('rc-videogular'), 1 );
    $scripts->add( 'wp-ng_com.2fdevs.videogular.plugins.overlayplay', wp_ng_get_asset_path('scripts/videogular-overlay-play.js'), array( $this->prefix, 'wp-ng_com.2fdevs.videogular' ), $bower->get_version('rc-videogular'), 1 );
    $scripts->add( 'wp-ng_com.2fdevs.videogular.plugins.poster',      wp_ng_get_asset_path('scripts/videogular-poster.js'),       array( $this->prefix, 'wp-ng_com.2fdevs.videogular' ), $bower->get_version('rc-videogular'), 1 );
    $scripts->add( 'wp-ng_rc-videogular.plugins.youtube',             wp_ng_get_asset_path('scripts/videogular-youtube.js'), array( $this->prefix, 'wp-ng_com.2fdevs.videogular' ), $bower->get_version('rc-videogular'), 1 );
    $scripts->add( 'wp-ng_rc-videogular.plugins.vimeo',               wp_ng_get_asset_path('scripts/videogular-vimeo.js'),        array( $this->prefix, 'wp-ng_com.2fdevs.videogular' ), $bower->get_version('rc-videogular'), 1 );

    //Authentication Satellizer
    $scripts->add( 'wp-ng_satellizer', wp_ng_get_asset_path('scripts/satellizer.js'), array( $this->prefix ), $bower->get_version('satellizer'), 1 );

    //Button Styles with loading
    $scripts->add( 'wp-ng_ngProgressButtonStyles', wp_ng_get_asset_path('scripts/ng-progress-button-styles.js'), array( $this->prefix ), $bower->get_version('ng-progress-button-styles'), 1 );

    //Image Cropper
    $scripts->add( 'wp-ng_angular-img-cropper', wp_ng_get_asset_path('scripts/angular-img-cropper.js'), array( $this->prefix ), $bower->get_version('angular-img-cropper-redcastor'), 1 );

    //Dialog Modal
    $scripts->add( 'wp-ng_rcDialog', wp_ng_get_asset_path('scripts/rc-dialog.js'), array( $this->prefix ), $bower->get_version('rc-dialog'), 1 );

    //Icons
    $scripts->add( 'wp-ng_webicon', wp_ng_get_asset_path('scripts/webicon.js'), array( $this->prefix ), $bower->get_version('webicon'), 1 );
    add_filter('wp_ng_webicon_config', function ( $config ) {

      $defaults = array();
      $webicon = wp_ng_get_module_options( 'wp-ng_webicon');

      if (isset($webicon['spinners']) && $webicon['spinners'] === 'on') {
        $defaults['sources']['spinner'] = wp_ng_get_asset_path('images/icons-spin.svg');
      }

      //Parse additional sources
      if (isset($webicon['sources']) && is_array($webicon['sources'])) {
        $defaults['sources'] = array_map('esc_url', $webicon['sources']);
      }

      //Parse additional aliases
      if (isset($webicon['aliases']) && is_array($webicon['aliases'])) {
        $defaults['alias'] = $webicon['aliases'];
      }

      if (isset($webicon['svg_icons']) && !empty($webicon['svg_icons'])) {
        $icon_url = $webicon['svg_icons'];
        $parsed_url= parse_url($icon_url);

        $icon_alias = (isset($webicon['alias']) && !empty($webicon['alias'])) ? $webicon['alias'] : '';
        $icon_name = basename($parsed_url['path'], '.svg');

        $defaults['sources'][$icon_name] = esc_url($webicon['svg_icons']);
        $defaults['alias'][$icon_alias] = $icon_name;
      }

      foreach ($config as $key => $val) {

        if ( is_array($val) ) {
          $defaults[$key] = wp_parse_args($val, $defaults[$key]);
        }
      }

      return wp_parse_args($config, $defaults);
    });

    //Media
    $scripts->add( 'wp-ng_rcMedia', wp_ng_get_asset_path('scripts/rc-media.js'), array( $this->prefix ), $bower->get_version('rc-media'), 1 );
    add_filter('wp_ng_rcMedia_config', function ( $config ) {

      $defaults = array(
        'restUrl'     => get_rest_url(),
        'restPath'    => 'wp/v2/media',
      );

      return wp_parse_args($config, $defaults);
    });


    //V by Lukasz Watroba https://github.com/LukaszWatroba
    $scripts->add( 'wp-ng_vButton',     wp_ng_get_asset_path('scripts/v-button.js'),    array( $this->prefix ), $bower->get_version('v-button'), 1 );
    $scripts->add( 'wp-ng_vTabs',       wp_ng_get_asset_path('scripts/v-tabs.js'),      array( $this->prefix, 'wp-ng_ngAnimate' ), $bower->get_version('v-tabs'), 1 );
    $scripts->add( 'wp-ng_vAccordion',  wp_ng_get_asset_path('scripts/v-accordion.js'), array( $this->prefix, 'wp-ng_ngAnimate' ), $bower->get_version('v-accordion'), 1 );
    $scripts->add( 'wp-ng_vModal',      wp_ng_get_asset_path('scripts/v-modal.js'),     array( $this->prefix ), $bower->get_version('v-modal'), 1 );
    $scripts->add( 'wp-ng_vTextfield',  wp_ng_get_asset_path('scripts/v-textfield.js'), array( $this->prefix ), $bower->get_version('v-textfield'), 1 );

    //Alert
    $scripts->add( 'wp-ng_ng-sweet-alert',  wp_ng_get_asset_path('scripts/ng-sweet-alert.js'), array( $this->prefix ), $bower->get_version('ng-sweet-alert'), 1 );

    //API NG
    $scripts->add( 'wp-ng_jtt_aping',  wp_ng_get_asset_path('scripts/apiNG.js'), array( $this->prefix ), $bower->get_version('apiNG'), 1 );
    add_filter('wp_ng_jtt_aping_config', function ( $config ) {

      $options_instagram = wp_ng_get_module_options( 'wp-ng_jtt_aping_instagram');
      $options_facebook = wp_ng_get_module_options( 'wp-ng_jtt_aping_facebook');
      $options_codebird = wp_ng_get_module_options( 'wp-ng_jtt_aping_codebird');
      $options_tumblr = wp_ng_get_module_options( 'wp-ng_jtt_aping_tumblr');
      $options_vimeo = wp_ng_get_module_options( 'wp-ng_jtt_aping_vimeo');
      $options_youtube = wp_ng_get_module_options( 'wp-ng_jtt_aping_youtube');
      $options_openweathermap = wp_ng_get_module_options( 'wp-ng_jtt_aping_openweathermap');

      $defaults = array(
        'instagram' => array(
          'access_token' => isset($options_instagram['access_token']) ? $options_instagram['access_token'] : '',
        ),
        'facebook' => array(
          'access_token' => isset($options_facebook['access_token']) ? $options_facebook['access_token'] : '',
        ),
        'twitter' => array(
          'bearer_token' => isset($options_codebird['bearer_token']) ? $options_codebird['bearer_token'] : '',
        ),
        'tumblr' => array(
          'api_key' => isset($options_tumblr['api_key']) ? $options_tumblr['api_key'] : '',
        ),
        'vimeo' => array(
          'access_token' => isset($options_vimeo['access_token']) ? $options_vimeo['access_token'] : '',
        ),
        'youtube' => array(
          'apiKey' => isset($options_youtube['api_key']) ? $options_youtube['api_key'] : '',
        ),
        'openweathermap' => array(
          'api_key' => isset($options_openweathermap['api_key']) ? $options_openweathermap['api_key'] : '',
        ),
      );

      return wp_parse_args($config, $defaults);
    });

    $scripts->add( 'wp-ng_jtt_aping_instagram',   wp_ng_get_asset_path('scripts/apiNG-plugin-instagram.js'),   array( $this->prefix, 'wp-ng_jtt_aping' ), $bower->get_version('apiNG-plugin-instagram'), 1 );
    $scripts->add( 'wp-ng_jtt_aping_facebook',    wp_ng_get_asset_path('scripts/apiNG-plugin-facebook.js'),    array( $this->prefix, 'wp-ng_jtt_aping' ), $bower->get_version('apiNG-plugin-facebook'), 1 );
    $scripts->add( 'wp-ng_jtt_aping_codebird',    wp_ng_get_asset_path('scripts/apiNG-plugin-codebird.js'),    array( $this->prefix, 'wp-ng_jtt_aping' ), $bower->get_version('apiNG-plugin-codebird'), 1 );
    $scripts->add( 'wp-ng_jtt_aping_flickr',      wp_ng_get_asset_path('scripts/apiNG-plugin-flickr.js'),      array( $this->prefix, 'wp-ng_jtt_aping' ), $bower->get_version('apiNG-plugin-flickr'), 1 );
    $scripts->add( 'wp-ng_jtt_aping_tumblr',      wp_ng_get_asset_path('scripts/apiNG-plugin-tumblr.js'),      array( $this->prefix, 'wp-ng_jtt_aping' ), $bower->get_version('apiNG-plugin-tumblr'), 1 );
    $scripts->add( 'wp-ng_jtt_aping_wikipedia',   wp_ng_get_asset_path('scripts/apiNG-plugin-wikipedia.js'),   array( $this->prefix, 'wp-ng_jtt_aping' ), $bower->get_version('apiNG-plugin-wikipedia'), 1 );
    $scripts->add( 'wp-ng_jtt_aping_dailymotion', wp_ng_get_asset_path('scripts/apiNG-plugin-dailymotion.js'), array( $this->prefix, 'wp-ng_jtt_aping' ), $bower->get_version('apiNG-plugin-dailymotion'), 1 );
    $scripts->add( 'wp-ng_jtt_aping_vimeo',       wp_ng_get_asset_path('scripts/apiNG-plugin-vimeo.js'),       array( $this->prefix, 'wp-ng_jtt_aping' ), $bower->get_version('apiNG-plugin-vimeo'), 1 );
    $scripts->add( 'wp-ng_jtt_aping_youtube',     wp_ng_get_asset_path('scripts/apiNG-plugin-youtube.js'),     array( $this->prefix, 'wp-ng_jtt_aping' ), $bower->get_version('apiNG-plugin-youtube'), 1 );
    $scripts->add( 'wp-ng_jtt_aping_openweathermap',     wp_ng_get_asset_path('scripts/apiNG-plugin-openweathermap.js'),     array( $this->prefix, 'wp-ng_jtt_aping' ), $bower->get_version('apiNG-plugin-openweathermap'), 1 );


    //PhotoSwipe
    $scripts->add( 'wp-ng_rcPhotoswipe',  wp_ng_get_asset_path('scripts/rc-photoswipe.js'), array( $this->prefix, 'wp-ng_photoswipe' ), $bower->get_version('rc-photoswipe'), 1 );

    //Sortable
    $scripts->add( 'wp-ng_angular-sortable-view',  wp_ng_get_asset_path('scripts/angular-sortable-view.js'), array( $this->prefix ), $bower->get_version('angular-sortable-view'), 1 );

    //Back Top Button
    $scripts->add( 'wp-ng_angular.backtop',  wp_ng_get_asset_path('scripts/angular-backtop.js'), array( $this->prefix ), $bower->get_version('angular-backtop'), 1 );

    //Loaction
    $scripts->add( 'wp-ng_ngLocationSearch',  wp_ng_get_asset_path('scripts/ng-location-search.js'), array( $this->prefix ), $bower->get_version('ng-location-search'), 1 );

    //Pagination
    $scripts->add( 'wp-ng_bgf.paginateAnything',  wp_ng_get_asset_path('scripts/angular-paginate-anything.js'), array( $this->prefix ), $bower->get_version('angular-paginate-anything'), 1 );

    //Image Dimensions
    $scripts->add( 'wp-ng_ngImageDimensions',  wp_ng_get_asset_path('scripts/angular-image-dimensions.js'), array( $this->prefix ), $bower->get_version('angular-image-dimensions'), 1 );

    //Gridster2
    $scripts->add( 'wp-ng_angular-gridster2',  wp_ng_get_asset_path('scripts/angular-gridster2-1.js'), array( $this->prefix ), $bower->get_version('angular-gridster2-1'), 1 );

    //Parallax
    $scripts->add( 'wp-ng_duParallax',  wp_ng_get_asset_path('scripts/angular-parallax.js'), array( $this->prefix, 'wp-ng_duScroll' ), $bower->get_version('angular-parallax'), 1 );

    //javascript datetime picker
    $scripts->add( 'wp-ng_angular-flatpickr',  wp_ng_get_asset_path('scripts/angular-flatpickr.js'), array_merge(array( $this->prefix ), $flatpickr_dep), $bower->get_version('angular-flatpickr'), 1 );

    //Drag and Drop
    $scripts->add( 'wp-ng_dragularModule',  wp_ng_get_asset_path('scripts/dragular.js'), array( $this->prefix ), $bower->get_version('dragular'), 1 );

    //Animate slide up and down
    $scripts->add( 'wp-ng_ng-slide-down',  wp_ng_get_asset_path('scripts/ng-slide-down.js'), array( $this->prefix ), $bower->get_version('ng-slide-down'), 1 );

    //Rating
    $scripts->add( 'wp-ng_ngRateIt',  wp_ng_get_asset_path('scripts/ng-rateit.js'), array( $this->prefix ), $bower->get_version('angular-rateit'), 1 );

    //HTTP
    $scripts->add( 'wp-ng_rcHttp',  wp_ng_get_asset_path('scripts/rc-http.js'), array( $this->prefix ), $bower->get_version('rc-http'), 1 );

  }

  /**
   * Add Default modules angular styles
   *
   * @param $styles
   */
  public function default_styles ( &$styles ) {

    $bower = new Wp_Ng_Bower();

    $styles->add( 'wp-ng_ngAnimate', wp_ng_get_asset_path('styles/angular-animate-css.css'), array(), $bower->get_version('angular-animate-css'), 'all' );
    $styles->add( 'wp-ng_ngAnimate-all', wp_ng_get_asset_path('styles/angular-animate-css-all.css'), array(), $bower->get_version('angular-animate-css'), 'all' );

    //javascript datetime picker
    $styles->add( 'wp-ng_flatpickr',  wp_ng_get_asset_path('styles/flatpickr.css'), array(), $bower->get_version('flatpickr'), 'all' );

    //Bootstrap
    $styles->add( 'wp-ng_bootstrap', wp_ng_get_asset_path('styles/bootstrap.css'), array(), $bower->get_version('bootstrap'), 'all' );
    $styles->add( 'wp-ng_ui.bootstrap-checkbox',  wp_ng_get_asset_path('styles/awesome-bootstrap-checkbox.css'), array(), $bower->get_version('awesome-bootstrap-checkbox'), 'all' );
    $styles->add( 'wp-ng_ui.bootstrap-font-awesome', wp_ng_get_asset_path('styles/font-awesome.css'), array(), $bower->get_version('font-awesome'), 'all' );

    //Foundation
    $styles->add( 'wp-ng_foundation',               wp_ng_get_asset_path('styles/foundation.css'),      array(), $bower->get_version('foundation-sites'), 'all' );
    $styles->add( 'wp-ng_foundation-flex',          wp_ng_get_asset_path('styles/foundation-flex.css'), array(), $bower->get_version('foundation-sites'), 'all' );
    $styles->add( 'wp-ng_mm.foundation-motion-ui',  wp_ng_get_asset_path('styles/motion-ui.css'),       array(), $bower->get_version('motion-ui'), 'all' );
    $styles->add( 'wp-ng_mm.foundation-fix',        wp_ng_get_asset_path('styles/angular-foundation-fix.css'), array(), $bower->get_version('angular-foundation-6'), 'all' );
    $styles->add( 'wp-ng_mm.foundation-bs3-2-zf6',  wp_ng_get_asset_path('styles/bs3-2-zf6.css'),       array(), $bower->get_version('bs3-2-zf6'), 'all' );
    $styles->add( 'wp-ng_mm.foundation-checkbox',  wp_ng_get_asset_path('styles/awesome-foundation6-checkbox.css'), array(), $bower->get_version('awesome-foundation6-checkbox'), 'all' );
    $styles->add( 'wp-ng_mm.foundation-font-awesome', wp_ng_get_asset_path('styles/font-awesome.css'), array(), $bower->get_version('font-awesome'), 'all' );


    $styles->add( 'wp-ng_angular-json-pretty', wp_ng_get_asset_path('styles/angular-json-pretty.css'), array( $this->prefix ), $bower->get_version('angular-json-pretty'), 'all' );

    $styles->add( 'wp-ng_ui-leaflet-awesome-markers', wp_ng_get_asset_path('styles/leaflet-awesome-markers.css'), array( 'wp-ng_ui-leaflet' ), $bower->get_version('Leaflet.awesome-markers'), 'all' );
    $styles->add( 'wp-ng_ui-leaflet-vector-markers',  wp_ng_get_asset_path('styles/leaflet-vector-markers.css'),  array( 'wp-ng_ui-leaflet' ), $bower->get_version('Leaflet.vector-markers'), 'all' );


    $styles->add( 'wp-ng_nya.bootstrap.select', wp_ng_get_asset_path('styles/nya-bootstrap-select.css'), array( $this->prefix ), $bower->get_version('nya-bootstrap-select'), 'all' );
    $styles->add( 'wp-ng_oi.select', wp_ng_get_asset_path('styles/oi-select.css'), array( $this->prefix ), $bower->get_version('oi.select'), 'all' );

    $styles->add( 'wp-ng_ngDialog',         wp_ng_get_asset_path('styles/ng-dialog.css'), array( $this->prefix ), $bower->get_version('ng-dialog'), 'all' );

    $styles->add( 'wp-ng_720kb.tooltips', wp_ng_get_asset_path('styles/angular-tooltips.css'), array( $this->prefix ), $bower->get_version('angular-tooltips'), 'all' );

    $styles->add( 'wp-ng_ngMagnify', wp_ng_get_asset_path('styles/ng-magnify.css'), array( $this->prefix ), $bower->get_version('ng-magnify'), 'all' );

    $styles->add( 'wp-ng_ngTinyScrollbar', wp_ng_get_asset_path('styles/ng-tiny-scrollbar.css'), array( $this->prefix ), $bower->get_version('ngTinyScrollbar'), 'all' );
    $styles->add( 'wp-ng_ngScrollbars', wp_ng_get_asset_path('styles/ng-scrollbars.css'),        array( $this->prefix ), $bower->get_version('ng-scrollbars'), 'all' );

    //Image Gallery and Carousel
    $styles->add( 'wp-ng_slick',        wp_ng_get_asset_path('styles/slick-carousel.css'),      array( $this->prefix ), $bower->get_version('slick-carousel'), 'all' );
    $styles->add( 'wp-ng_slick-theme',  wp_ng_get_asset_path('styles/slick-carousel-theme.css'),array( 'wp-ng_slick' ), $bower->get_version('slick-carousel'), 'all' );
    $styles->add( 'wp-ng_slickCarousel',wp_ng_get_asset_path('styles/slick-carousel.css'),      array( $this->prefix ), $bower->get_version('slick-carousel'), 'all' );
    $styles->add( 'wp-ng_slickCarousel-theme', wp_ng_get_asset_path('styles/slick-carousel-theme.css'), array( 'wp-ng_slickCarousel' ), $bower->get_version('slick-carousel'), 'all' );

    $styles->add( 'wp-ng_angular-owl-carousel-2', wp_ng_get_asset_path('styles/owl-carousel.css'), array( $this->prefix ), $bower->get_version('owl.carousel'), 'all' );
    $styles->add( 'wp-ng_angular-owl-carousel-2-theme-default', wp_ng_get_asset_path('styles/owl-carousel-theme-default.css'), array( 'wp-ng_angular-owl-carousel-2' ), $bower->get_version('owl.carousel'), 'all' );
    $styles->add( 'wp-ng_angular-owl-carousel-2-theme-green', wp_ng_get_asset_path('styles/owl-carousel-theme-green.css'), array( 'wp-ng_angular-owl-carousel-2' ), $bower->get_version('owl.carousel'), 'all' );

    $styles->add( 'wp-ng_ui.swiper', wp_ng_get_asset_path('styles/angular-ui-swiper.css'), array( $this->prefix ), $bower->get_version('angular-ui-swiper'), 'all' );

    //Icons
    $styles->add( 'wp-ng_webicon', wp_ng_get_asset_path('styles/webicon.css'), array( $this->prefix ), $bower->get_version('webicon'), 'all' );

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
    $styles->add( 'wp-ng_ui.select-selectize', wp_ng_get_asset_path('styles/selectize.css'), array( 'wp-ng_ui.select' ), $bower->get_version('angular-ui-select'), 'all' );
    $styles->add( 'wp-ng_ui.select.zf6', wp_ng_get_asset_path('styles/ui-select-zf6.css'), array( $this->prefix, 'wp-ng_ui.select' ), $bower->get_version('ui-select-zf6'), 'all' );

    $styles->add( 'wp-ng_trTrustpass',      wp_ng_get_asset_path('styles/angular-trustpass.css'),   array( $this->prefix ), $bower->get_version('angular-trustpass'), 'all' );

    $styles->add( 'wp-ng_hl.sticky',    wp_ng_get_asset_path('styles/angular-sticky-plugin.css'), array( $this->prefix ), $bower->get_version('angular-sticky-plgin'), 'all' );

    $styles->add( 'wp-ng_ngInput',    wp_ng_get_asset_path('styles/ng-input.css'), array( $this->prefix ), $bower->get_version('ng-input'), 'all' );

    $styles->add( 'wp-ng_LiveSearch',    wp_ng_get_asset_path('styles/angular-livesearch.css'), array( $this->prefix ), $bower->get_version('angular-livesearch'), 'all' );

    $styles->add( 'wp-ng_com.2fdevs.videogular', wp_ng_get_asset_path('styles/videogular.css'), array( $this->prefix ), $bower->get_version('rc-videogular'), 'all' );

    //Button Styles with loading
    $styles->add( 'wp-ng_ngProgressButtonStyles', wp_ng_get_asset_path('styles/ng-progress-button-styles.css'), array( $this->prefix ), $bower->get_version('ng-progress-button-styles'), 'all' );

    //Media
    $styles->add( 'wp-ng_rcMedia-dialog', wp_ng_get_asset_path('styles/rc-media-dialog.css'), array( $this->prefix ), $bower->get_version('rc-media'), 'all' );
    $styles->add( 'wp-ng_rcMedia-select', wp_ng_get_asset_path('styles/rc-media-select.css'), array( $this->prefix ), $bower->get_version('rc-media'), 'all' );
    $styles->add( 'wp-ng_rcMedia-zf',     wp_ng_get_asset_path('styles/rc-media-zf.css'),     array( $this->prefix ), $bower->get_version('rc-media'), 'all' );

    //V by Lukasz Watroba https://github.com/LukaszWatroba
    //Check dependencie of active valitycss
    $v_button = wp_ng_get_module_option('style_valitycss', 'vButton', false);
    $v_tabs = wp_ng_get_module_option('style_valitycss', 'vTabs', false);
    $v_accordion = wp_ng_get_module_option('style_valitycss', 'vAccordion', false);
    $v_modal = wp_ng_get_module_option('style_valitycss', 'vModal', false);
    $v_textfield = wp_ng_get_module_option('style_valitycss', 'vTextfield', false);
    $v_dep = array ($this->prefix );

    if ($v_button == 'on' || $v_tabs == 'on' || $v_accordion == 'on' || $v_modal == 'on' || $v_textfield == 'on') {
      $v_dep[] = 'wp-ng_valitycss';
    }

    $styles->add( 'wp-ng_valitycss',   wp_ng_get_asset_path('styles/valitycss.css'),  array(), $bower->get_version('valitycss'), 'all' );
    $styles->add( 'wp-ng_vButton',     wp_ng_get_asset_path('styles/v-button.css'),    $v_dep, $bower->get_version('v-button'),    'all' );
    $styles->add( 'wp-ng_vTabs',       wp_ng_get_asset_path('styles/v-tabs.css'),      $v_dep, $bower->get_version('v-tabs'),      'all' );
    $styles->add( 'wp-ng_vAccordion',  wp_ng_get_asset_path('styles/v-accordion.css'), $v_dep, $bower->get_version('v-accordion'), 'all' );
    $styles->add( 'wp-ng_vModal',      wp_ng_get_asset_path('styles/v-modal.css'),     $v_dep, $bower->get_version('v-modal'),     'all' );
    $styles->add( 'wp-ng_vTextfield',  wp_ng_get_asset_path('styles/v-textfield.css'), $v_dep, $bower->get_version('v-textfield'), 'all' );

    //Sweet Alert
    $styles->add( 'wp-ng_ng-sweet-alert',   wp_ng_get_asset_path('styles/ng-sweet-alert.css'), array( $this->prefix ), $bower->get_version('ng-sweet-alert'), 'all' );

    //PhotoSwipe
    $styles->add( 'wp-ng_rcPhotoswipe',     wp_ng_get_asset_path('styles/photoswipe.css'), array( $this->prefix ), $bower->get_version('rc-photoswipe'), 'all' );

    //Back Top Button
    $styles->add( 'wp-ng_angular.backtop',  wp_ng_get_asset_path('styles/angular-backtop.css'), array( $this->prefix ), $bower->get_version('angular-backtop'), 'all' );

    //Gridster2
    $styles->add( 'wp-ng_angular-gridster2', wp_ng_get_asset_path('styles/angular-gridster2-1.css'), array( $this->prefix ), $bower->get_version('angular-gridster2-1'), 'all' );

    //Drag and Drop
    $styles->add( 'wp-ng_dragularModule',   wp_ng_get_asset_path('styles/dragular.css'), array( $this->prefix ), $bower->get_version('dragular'), 'all' );

    //Rating
    $styles->add( 'wp-ng_ngRateIt',         wp_ng_get_asset_path('styles/ng-rateit.css'), array( $this->prefix ), $bower->get_version('angular-rateit'), 'all' );
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

    $wp_scripts = wp_scripts();

    $ng_modules = $this->get_ng_modules_from_handles( $this->scripts_src, $wp_scripts );

    return $ng_modules;
  }

  /**
   * Get the modules from enqueue style and deps and create styles src array
   *
   * @return array
   */
  public function get_ng_module_from_handles_style() {

    $wp_styles = wp_styles();

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
