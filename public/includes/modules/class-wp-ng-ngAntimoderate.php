<?php

/**
 * The public-facing includes functionality Module Antimoderate.
 *
 * @link       http://redcastor.io
 * @since      1.6.2
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
final class Wp_Ng_Public_NG_Antimoderate {


  /**
   * Init Hooks.
   */
  public static function init() {

    if ( wp_ng_is_module_active('ngAntimoderate') &&  wp_ng_get_module_option( 'wp_images', 'ngAntimoderate', 'off') === 'on' ) {
      add_action('init', array( __CLASS__, 'setup_media'));

      add_filter('wp_get_attachment_image_attributes', array( __CLASS__, 'get_attachment_image_attributes'), 100, 3);
    }

    add_filter('wp_get_attachment_image_attributes', array( __CLASS__, 'remove_attachment_attr_antimoderate'), 100, 3);
  }


  /**
   * Theme setup media
   */
  public static function setup_media() {

    // Add Image thumbnail micro
    add_image_size( 'micro', 96 );
    add_image_size( 'micro_cropped', 96, 96, true );

  }


  /**
   * get_attachment_image_attributes
   *
   * @param $attr
   * @param $attachment
   * @param $size
   */
  public static function get_attachment_image_attributes ( $attr, $attachment, $size ) {

    $no_antimoderate = false;

    if ( in_array('no-antimoderate', $attr) || !empty($attr['no-antimoderate']) ) {

      $no_antimoderate = true;
    }

    $file_type = wp_check_filetype( get_attached_file( $attachment->ID ) );

    if ( !is_admin() && $size !== 'thumbnail' && !$no_antimoderate && in_array($file_type['ext'], ['jpg', 'jpeg', 'jpe', 'png']) ) {

      $size_src = wp_get_attachment_image_src( $attachment->ID, $size );

      $large_width = absint(get_option('large_size_w'));
      $large_height = absint(get_option('large_size_h'));

      if ($size_src[0] <= $large_width && $size_src[1] <= $large_height ) {
        return $attr;
      }

      $micro_size = 'micro';

      if ($size_src[1] === $size_src[2]) {
        $micro_size = 'micro_cropped';
      }

      $micro_src = wp_get_attachment_image_src( $attachment->ID, $micro_size );

      if ( !empty($attr['src']) && is_array($micro_src) ) {
        $attr['data-ng-src'] = $attr['src'];
        unset($attr['src']);
        unset($attr['srcset']);

        $attr['data-ng-antimoderate'] = $micro_src[0];
        $attr['data-filter'] = 'blur(15px)';
        $attr['data-transition'] = 'filter 300ms';
        $attr['data-loaded-class'] = 'loaded';
        $attr['data-loading-class'] = 'loading';
      }
    }

    return $attr;
  }


  /*
   * Remove no-antimoderate attribute
   */
  public static function remove_attachment_attr_antimoderate ( $attr, $attachment, $size ) {

    unset($attr['no-antimoderate']);

    return $attr;
  }
}
