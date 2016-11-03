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

    wp_deregister_script('angular');

    $bower = new Wp_Ng_Bower();

    wp_register_script(
      'angular',
      $bower->map_to_cdn([
        'name' => 'angular',
        'cdn' => 'google-angular',
        'file' => 'angular.min.js'
      ], wp_ng_get_asset_path('scripts/angular.js')),
      $deps,
      $bower->get_version('angular'),
      true
    );

    wp_add_inline_script( 'angular', '!window.angular && document.write("\x3Cscript src=\x22' . wp_ng_get_asset_path('scripts/angular.js') . '\x22\x3E\x3C/script\x3E");' );
  }

  /**
   * Register jquery from Google's CDN with a local fallback
   *
   * @param array or string $deps
   */
  static public function register_jquery_fallback( $deps = array()) {

    if( !is_array($deps) ) {
      $deps = array(strval($deps));
    }

    wp_deregister_script('jquery');

    $bower = new Wp_Ng_Bower();
    $version = $bower->get_version('jquery');

    wp_register_script(
      'jquery',
      $bower->map_to_cdn([
        'name' => 'jquery',
        'cdn' => 'jquery',
        'file' => 'jquery-' . $version . '.min.js'
      ], wp_ng_get_asset_path('scripts/jquery.js')),
      $deps,
      $version,
      true
    );

    wp_add_inline_script( 'jquery', '!window.jQuery && document.write("\x3Cscript src=\x22' . wp_ng_get_asset_path('scripts/jquery.js') . '\x22\x3E\x3C/script\x3E");' );
  }

}
