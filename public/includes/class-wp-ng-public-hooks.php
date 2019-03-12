<?php

/**
 * The public-facing includes functionality Hooks.
 *
 * @link       http://redcastor.io
 * @since      1.5.0
 *
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes
 */







/**
 *
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Public_Hooks {

  public static $is_lazyload = false;
  public static $gallery_mode = '';


  /**
   * Init Hooks.
   */
  public static function init() {

    /* Public Filter HooK */
    add_filter('wp_ng_get_options',           array( __CLASS__, 'get_options' ), 10, 2);
    add_filter('wp_ng_get_option',            array( __CLASS__, 'get_option' ), 10, 3);

    add_filter('wp_ng_get_language',          array( __CLASS__, 'get_language'), 10);
    add_filter('wp_ng_current_language',      array( __CLASS__, 'current_language'), 10);

    add_filter('wp_ng_get_active_modules',    array( __CLASS__, 'get_active_modules'), 10, 2);
    add_filter('wp_ng_get_module_options',    array( __CLASS__, 'get_module_options'), 10, 2);
    add_filter('wp_ng_get_module_option',     array( __CLASS__, 'get_module_option'), 10, 3);

    add_filter('wp_ng_json_encode',           array( __CLASS__, 'json_encode'), 10, 3);
    add_filter('wp_ng_json_encode_shortcode', array( __CLASS__, 'json_encode_shortcode'), 10, 2);
    add_filter('wp_ng_json_decode',           array( __CLASS__, 'json_decode'), 10, 2);

    add_filter('wp_ng_get_html_attributes',   array( __CLASS__, 'get_html_attributes'), 10, 4);

    add_filter('wp_ng_apply_translation',     array( __CLASS__, 'apply_translation'), 10, 4);

    add_filter('wp_ng_shuffle_assoc',         array( __CLASS__, 'shuffle_assoc'), 10, 1);

    add_filter('wp_ng_create_onetime_nonce',  array( __CLASS__, 'create_onetime_nonce' ), 10, 3);
    add_filter('wp_ng_verify_onetime_nonce',  array( __CLASS__, 'verify_onetime_nonce' ), 10, 4);
    add_action('wp_ng_invalidate_onetime_nonce', array( __CLASS__, 'invalidate_onetime_nonce' ));

    /* the_content */
    add_filter('wp_ng_the_content',           array( __CLASS__, 'get_the_content'), 10);
    add_filter('wp_ng_the_content_unautop',   array( __CLASS__, 'get_the_content_unautop'), 10);

    /* Template Hooks*/
    add_action( 'wp_ng_template_wrapper_lazyload_start', array( __CLASS__, 'output_wrapper_lazyload_start'), 10 );
    add_action( 'wp_ng_template_wrapper_lazyload_end',   array( __CLASS__, 'output_wrapper_lazyload_end'), 10 );
    add_action( 'wp_ng_template_wrapper_gallery_start',  array( __CLASS__, 'output_wrapper_gallery_start'), 10, 6 );
    add_action( 'wp_ng_template_wrapper_gallery_end',    array( __CLASS__, 'output_wrapper_gallery_end'), 10 );
  }



  public static function get_options ( $empty_value, $section ) {

    return wp_ng_get_options( $section );
  }

  public static function get_option ( $default, $option, $section ) {

    return wp_ng_get_option( $option, $section, $default );
  }

  public static function get_language( $empty_value ) {

    return wp_ng_get_language();
  }

  public static function current_language( $empty_value ) {

    $locale = (object)wp_ng_get_language();

    return $locale->current;
  }


  public static function get_active_modules( $empty_value, $on_condition = true ) {

    return wp_ng_get_active_modules( $on_condition );
  }

  public static function get_module_options( $empty_value, $module_handle ) {

    $options = wp_ng_get_module_options( $module_handle );

    if (!$options) {
      return $empty_value;
    }

    return $options;
  }

  public static function get_module_option( $default, $option, $module_handle ) {

    return wp_ng_get_module_option( $option, $module_handle, $default );
  }



  public static function json_encode( $empty_value, $arr, $shortcode = false ) {

    return wp_ng_json_encode( $arr, $shortcode);
  }

  public static function json_encode_shortcode( $empty_value, $arr ) {

    return wp_ng_json_encode_shortcode( $arr );
  }

  public static function json_decode( $empty_value, $str) {

    return wp_ng_json_decode( $str );
  }


  public static function get_html_attributes ( $empty_value, $args, $prefix = '', $shortcode = false) {

    return wp_ng_get_html_attributes( $args, $prefix, $shortcode);
  }



  public static function apply_translation( $atts, $default = 'text', $name = 'WP NG Form', $domain = 'wp-ng' ) {

    return wp_ng_apply_translation($atts, $default, $name, $domain);
  }


  public static function shuffle_assoc( $list ) {

    return wp_ng_shuffle_assoc( $list );
  }




  public static function create_onetime_nonce ( $empty_value, $action = -1, $expiration = 3600 ) {

    return wp_ng_create_onetime_nonce( $action, $expiration );
  }

  public static function verify_onetime_nonce ( $empty_value, $nonce, $action = -1, $invalidate = true ) {

    return wp_ng_verify_onetime_nonce( $nonce, $action, $invalidate );
  }

  public static function invalidate_onetime_nonce ( $nonce ) {

    return wp_ng_invalidate_onetime_nonce( $nonce );
  }

  /**
   * Content Hooks
   */
  /**
   * Get the content filter but remove global $post to prevent other plugins content such elementor
   * This filter is used in shortcode to resolve content example embed.
   *
   * @param $content
   */
  public static function get_the_content ( $content ) {

    global $post;

    //Save global post before restore
    $saved_post = $post;

    //Set global post to null;
    $post = null;

    $content = apply_filters('the_content', $content);

    //Restore global post after
    $post = $saved_post;

    return $content;
  }

  /**
   * content unautop
   *
   * @param $content
   *
   * @return mixed
   */
  public static function get_the_content_unautop ( $content ) {

    $has_wpautop = false;
    $has_wpngautop = false;

    if (has_filter('the_content', 'wpautop')) {
      $has_wpautop = true;
      remove_filter('the_content', 'wpautop');
    }

    if (has_filter('the_content', 'wpngautop')) {
      $has_wpngautop = true;
      remove_filter ( 'the_content', 'wpngautop' );
    }

    $content = self::get_the_content($content);

    if ($has_wpautop) {
      add_filter('the_content', 'wpautop');
    }

    if ($has_wpngautop) {
      add_filter ( 'the_content', 'wpngautop' );
    }

    return $content;
  }

  /**
   * Template Hooks
   */

  /**
   * Output the start of the lazyload wrapper.
   */
  public static function output_wrapper_lazyload_start( $ng_modules = array() ) {

    self::$is_lazyload = wp_script_is(wp_ng_sanitize_name('module', 'oc.lazyLoad'), 'queue');

    //Get Modules sources from modules
    $sources = array_merge(
      array_values(wp_ng_get_modules_scripts( $ng_modules, true )),
      array_values(wp_ng_get_modules_styles( $ng_modules, true ))
    );

    if (empty($sources)) {
      self::$is_lazyload = false;
    }

    if ( self::$is_lazyload ) {

      wp_ng_get_template( 'global/wrapper-lazyload-start.php', null, array('ng_modules' => $ng_modules, 'sources' => $sources) );
    }
  }

  /**
   * Output the end of the lazyload wrapper.
   */
  public static function output_wrapper_lazyload_end() {

    if ( self::$is_lazyload ) {

      wp_ng_get_template( 'global/wrapper-lazyload-end.php' );
    }
  }

  /**
   * Output the start of the gallery wrapper.
   */
  public static function output_wrapper_gallery_start( $template, $type, $mode = '', $gallery = array(), $id, $options = array() ) {

    self::$gallery_mode = $mode;

    $args = array(
      'template' => $template,
      'type' => $type,
      'mode' => $mode,
      'gallery' => $gallery,
      'id' => $id,
      'options' => $options
    );

    if ( !empty($mode) && !wp_ng_get_template( "global/wrapper-{$mode}-start.php", null, $args ) ) {
      self::$gallery_mode = '';
    }
  }

  /**
   * Output the end of the gallery wrapper.
   */
  public static function output_wrapper_gallery_end() {

    $mode = self::$gallery_mode;

    if ( !empty($mode) ) {
      wp_ng_get_template( "global/wrapper-{$mode}-end.php" );
    }
  }

}
