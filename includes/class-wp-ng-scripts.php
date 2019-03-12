<?php

/**
 * Extra Script Class
 *
 * @link       http://redcastor.io
 * @since      1.5.1
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
class Wp_Ng_Scripts {


  public $prefix;


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
   * @since 1.5.1
   */
  public function __clone() {
    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wp-ng' ), '1.4.2' );
  }

  /**
   * Unserializing instances of this class is forbidden.
   *
   * @since 1.5.1
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
   * Register Scripts
   */
  public function register_scripts () {

    $fallback_src = wp_ng_get_asset_path( 'scripts/webfontloader.js' );

    $bower   = new Wp_Ng_Bower();
    $src = $bower->map_to_cdn( [
      'name' => 'webfont',
      'cdn'  => 'cloudflare',
      'file' => 'webfontloader.js'
    ], $fallback_src, $bower->get_version('webfontloader') );

    //Inline Webfont Ascync
    wp_add_inline_script( 'wp-ng_WebFont', '(function(d, w){function createWebFont( src ) {var wf = d.createElement(\'script\'), s = d.scripts[0];wf.src=src;s.parentNode.insertBefore(wf,s);return wf;}var wf=createWebFont(\'' . $src . '\');wf.onerror=function(){createWebFont(\'' . $fallback_src . '\');};})(document, window)' );
  }


  /**
   * Registe Styles
   */
  public function register_styles () {

  }

  /**
   * Add Default scripts
   *
   * @param $scripts
   */
  public function default_scripts ( &$scripts ) {

    $bower = new Wp_Ng_Bower();

    $scripts->add('wp-ng_WebFont', wp_ng_get_asset_path('scripts/web-font.js'), array(), $bower->get_version('webfontloader'), 1 );
    add_filter('wp_ng_WebFont_config', function ( $config ) {

      $options = wp_ng_get_script_options( 'WebFont' );
      $timeout = absint($options['timeout']);

      $defaults = array(
        'classes' => true,
        'events' => true,
      );

      //Google Font
      if ( !empty($options['google_families']) ) {
        $defaults['google'] = array(
          'families' => $options['google_families'],
        );
      }

      if ( !empty($options['typekit_id']) ) {
        $defaults['typekit'] = array(
          'id' => str_replace(',', ';', $options['typekit_id']),
        );

        if ( $options['typekit_edge'] === 'on' ) {
          $defaults['typekit']['api'] = '//use.edgefonts.net';
        }
      }

      if ( !empty($options['custom_families']) ) {
        $defaults['custom'] = array(
          'families' => explode(',', $options['custom_families']),
          'urls' => explode( ',', $options['custom_urls']),
        );
      }

      //Timeout
      if ( $timeout > 0) {
        $defaults['timeout'] = $timeout;
      }

      return wp_parse_args($config, $defaults);
    });

    $scripts->add('wp-ng_objectFitImages', wp_ng_get_asset_path('scripts/object-fit-images.js'), array(), $bower->get_version('object-fit-images'), 1 );
    add_filter('wp_ng_objectFitImages_config', function ( $config ) {

      $defaults = array(
        'element' => 'img.fit',
      );

      return wp_parse_args($config, $defaults);
    });

    $scripts->add('wp-ng_aos', wp_ng_get_asset_path('scripts/aos.js'), array(), $bower->get_version('aos'), 1 );
    add_filter('wp_ng_aos_config', function ( $config ) {

      $options = wp_ng_get_script_options( 'aos' );

      $defaults = array(
        'disable' => (isset($options['disable']) && $options['disable'] === 'on') ? true : false,
        'offset' => absint($options['offset']),
        'delay' => absint($options['delay']),
        'duration' => absint($options['duration']),
        'once' => (isset($options['once']) && $options['once'] === 'on') ? true : false,
        'mirror' => (isset($options['mirror']) && $options['mirror'] === 'on') ? true : false,
        'easing' => $options['easing'],
      );

      return wp_parse_args($config, $defaults);
    });

    $scripts->add('wp-ng_aot', wp_ng_get_asset_path('scripts/aot.js'), array(), $bower->get_version('aot'), 1 );
    add_filter('wp_ng_aot_config', function ( $config ) {

      $defaults = array(
        'selector' => 'body',
        'options' => array(),
      );

      return wp_parse_args($config, $defaults);
    });

    $scripts->add('wp-ng_animsition', wp_ng_get_asset_path('scripts/animsition.js'), array('jquery'), $bower->get_version('animsition'), 1 );
    add_filter('wp_ng_animsition_config', function ( $config ) {

      $options = wp_ng_get_script_options( 'animsition' );

      $defaults = array(
        'element' => 'body',
        'class' => 'animsition',
        'config' => array(
          'inClass' => $options['in_class'],
          'outClass' => $options['out_class'],
          'inDuration' => absint($options['in_duration']),
          'outDuration' => absint($options['out_duration']),
          'linkElement' => 'a:not([target="_blank"]):not([href^="#"],[href=""])',
          'loading' => true,
          'loadingClass' => 'animsition-loading',
          'loadingInner' => !empty($options['load_inner']) ? '<img src="' . $options['load_inner'] . '" />' : '', // e.g '<img src="loading.svg" />'
          'timeout' => (isset($options['timeout']) && $options['timeout'] === 'on') ? true : false,
          'timeoutCountdown' => absint($options['timeout_countdown']),
          'onLoadEvent' => true,
          'browser' => ['animation-duration', '-webkit-animation-duration'],
          'overlay' => strpos($options['in_class'], 'overlay') === 0 && strpos($options['out_class'], 'overlay') === 0,
          'overlayClass' => 'animsition-overlay-slide',
        ),
      );

      return wp_parse_args($config, $defaults);
    });

    $scripts->add('wp-ng_scrollify', wp_ng_get_asset_path('scripts/scrollify.js'), array('jquery'), $bower->get_version('Scrollify'), 1 );
    add_filter('wp_ng_scrollify_config', function ( $config ) {

      $options = wp_ng_get_script_options( 'scrollify' );

      $defaults = array(
        'section'             => $options['section'],
        'sectionName'         => $options['section_name'],
        'interstitialSection' => $options['interstitial_section'],
        'moveClick'           => $options['move_click'],
        'nextClick'           => $options['next_click'],
        'easing'              => trim($options['easing']),
        'scrollSpeed'         => absint($options['scroll_speed']),
        'offset'              => intval($options['offset']),
        'scrollbars'          => true,
        'standardScrollElements' => '',
        'setHeights'          => true,
        'overflowScroll'      => true,
        'updateHash'          => true,
        'touchScroll'         => (isset($options['touch_scroll']) && $options['touch_scroll'] === 'on') ? true : false,
      );

      return wp_parse_args($config, $defaults);
    });

  }


  /**
   * Add Default modules angular styles
   *
   * @param $styles
   */
  public function default_styles ( &$styles ) {

    $bower = new Wp_Ng_Bower();

    $styles->add('wp-ng_animate', wp_ng_get_asset_path('styles/animate.css'), array(), $bower->get_version('animate.css'), 'all' );
    $styles->add('wp-ng_aot-animate', false, array('wp-ng_animate'), $bower->get_version('aot'), 'all' );

    $webfont_options = wp_ng_get_script_options( 'WebFont' );
    $primary_font = trim($webfont_options['primary'], ';');
    $primary_fallback_font = trim($webfont_options['primary_fallback'], ';');

    //Create cache webfont primary if primary correct formated single quote
    if ( !empty($primary_font) && (substr_count($primary_font, "'") % 2) === 0 ) {

      $cache = new Wp_Ng_Cache( 'webfont_primary.css' , '.css', $this->prefix );
      $class_primary_font = str_replace(array(' ', "'", "'") , array('', '', ''), strtolower( explode(',', $primary_font)[0] ));

      $primary_font_content = sprintf('.wf-active body, .wf-inactive body { font-family: %2$s; } .wf-%1$s-active body { font-family: %3$s; }', $class_primary_font, $primary_fallback_font, $primary_font );
      $cache_font_basename = $cache->create_file( $primary_font_content );

      if ( $cache_font_basename ) {

        $styles->add( 'wp-ng_WebFont-primary', $cache::cache_dir($this->prefix, $cache_font_basename, true), array(), $bower->get_version('webfontloader'), 'all' );
      }
    }

    $styles->add('wp-ng_WebFont', wp_ng_get_asset_path('styles/webfontloader.css'), array(), $bower->get_version('webfontloader'), 'all' );
    $styles->add('wp-ng_objectFitImages', wp_ng_get_asset_path('styles/object-fit-images.css'), array(), $bower->get_version('object-fit-images'), 'all' );
    $styles->add('wp-ng_aos', wp_ng_get_asset_path('styles/aos.css'), array(), $bower->get_version('aos'), 'all' );
    $styles->add('wp-ng_aot', wp_ng_get_asset_path('styles/aot.css'), array(), $bower->get_version('aot'), 'all' );
    $styles->add('wp-ng_animsition', wp_ng_get_asset_path('styles/animsition.css'), array(), $bower->get_version('animsition'), 'all' );

  }

}
