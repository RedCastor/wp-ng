<?php

/**
 * The public-facing includes functionality of the plugin.
 *
 * @link       http://redcastor.io
 * @since      1.0.0
 *
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes
 */







/**
 * The public-facing includes functionality of the plugin.
 *
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Public_Fallback {


  /**
   * Register angular from Google's CDN with a local fallback
   *
   * @param array or string $deps
   */
  static public function register_angular_fallback( $deps = array()) {

    if( !is_array($deps) ) {
      $deps = array(strval($deps));
    }

    $bower = new Wp_Ng_Bower();
    $version = $bower->get_version( 'angular' );

    wp_deregister_script('angular');

    if ( wp_ng_is_cdn_angular() ) {
      $src = $bower->map_to_cdn([
        'name' => 'angular',
        'cdn' => 'google-angular',
        'file' => 'angular.min.js'
      ], wp_ng_get_asset_path('scripts/angular.js'));
    }
    else {
      $src = wp_ng_get_asset_path('scripts/angular.js');
    }

    wp_register_script(
      'angular',
      $src,
      $deps,
      $version,
      true
    );

    if ( wp_ng_is_cdn_angular() ) {
      wp_add_inline_script( 'angular', '!window.angular && document.write("\x3Cscript src=\x22' . wp_ng_get_asset_path('scripts/angular.js') . '\x22\x3E\x3C/script\x3E");' );
    }
  }

  /**
   * Register jquery from Google's CDN with a local fallback
   *
   * @param array or string $deps
   */
  static public function register_jquery_fallback( $deps = array()) {

    global $wp_scripts;

    if ( ! is_array( $deps ) ) {
      $deps = array( strval( $deps ) );
    }

    $bower   = new Wp_Ng_Bower();
    $version = $bower->get_version( 'jquery' );

    wp_deregister_script( 'jquery' );
    wp_deregister_script( 'jquery-core' );

    if ( wp_ng_is_cdn_jquery() ) {

      $src = $bower->map_to_cdn( [
        'name' => 'jquery',
        'cdn'  => 'jquery',
        'file' => 'jquery-' . $version . '.min.js'
      ], wp_ng_get_asset_path( 'scripts/jquery.js' ) );
    }
    else {
      $src = wp_ng_get_asset_path( 'scripts/jquery.js' );
    }

    wp_register_script( 'jquery', false, array( 'jquery-core', 'jquery-migrate' ), $version );
    wp_register_script(
      'jquery-core',
      $src,
      $deps,
      $version,
      true
    );

    if ( wp_ng_is_cdn_jquery() ) {
      wp_add_inline_script( 'jquery-core', '!window.jQuery && document.write("\x3Cscript src=\x22' . wp_ng_get_asset_path( 'scripts/jquery.js' ) . '\x22\x3E\x3C/script\x3E");' );
    }

    //Add jquery migrate to cdn with fallback
    if ( isset($wp_scripts->registered['jquery-migrate']) ) {

      $original_src = $wp_scripts->registered['jquery-migrate']->src;
      $version = $wp_scripts->registered['jquery-migrate']->ver;

      if ( wp_ng_is_cdn_jquery() ) {
        $src = $bower->map_to_cdn( [
          'name' => 'jquery-migrate',
          'cdn'  => 'jquery-migrate',
          'file' => 'jquery-migrate-' . $version . '.min.js'
        ], $original_src, $version );
      }
      else {
        $src = $original_src;
      }

      wp_deregister_script( 'jquery-migrate' );
      wp_register_script(
        'jquery-migrate',
        $src,
        array(),
        $version,
        true
      );

      if ( wp_ng_is_cdn_jquery() ) {
        wp_add_inline_script( 'jquery-migrate', '!window.jQuery.migrateWarnings  && document.write("\x3Cscript src=\x22' . get_home_url(null, $src) . '\x22\x3E\x3C/script\x3E");' );
      }

    }

  }

}
