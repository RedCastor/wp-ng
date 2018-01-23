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

  /**
   * Init Hooks.
   */
  public static function init() {

    //Public Filter HooK
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

    add_filter('wp_ng_apply_translation',     array( __CLASS__, 'apply_translation'), 10, 4);

    add_filter('wp_ng_create_onetime_nonce',  array( __CLASS__, 'create_onetime_nonce' ), 10, 3);
    add_filter('wp_ng_verify_onetime_nonce',  array( __CLASS__, 'verify_onetime_nonce' ), 10, 4);
    add_action('wp_ng_invalidate_onetime_nonce', array( __CLASS__, 'invalidate_onetime_nonce' ));

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



  public static function apply_translation( $atts, $default = 'text', $name = 'WP NG Form', $domain = 'wp-ng' ) {

    return wp_ng_apply_translation($atts, $default, $name, $domain);
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

}
