<?php

/**
 * The admin-specific includes functionality of the plugin.
 *
 * @link       http://redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/admin/includes
 */

/**
 * The admin-specific includes functionality of the plugin.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/admin/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Admin_Fields_Action {

  /**
   * Purge Cache Action remove all chache files.
   *
   * @param $new_value
   * @param $old_value
   * @return mixed
   */
  static public function purge_cache ( $new_value = 'on', $old_value = 'off' ) {

    $cache_dir = Wp_Ng_Cache::cache_dir( WP_NG_PLUGIN_NAME );

    if ( $new_value === 'on' && is_dir( $cache_dir ) ) {
      foreach(glob($cache_dir . '/*') as $file) {
        if(is_dir($file))
          rrmdir($file);
        else
          unlink($file);
      }
      rmdir($cache_dir);
    }

    return $old_value;
  }
}
