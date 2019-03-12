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

use \Rollbar\Rollbar;
use \Rollbar\Payload\Level;

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
   * @param $option
   * @return mixed
   */
  static public function purge_cache ( $new_value = 'on', $old_value = 'off', $option = '' ) {

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


  /**
   * Clean Wp Cache
   *
   * @param $new_value
   * @param $old_value
   * @param $option
   * @return mixed
   */
  static public function clean_wp_cache ( $new_value = '', $old_value = '', $option = '' ) {

    wp_ng_cache_clean();

    return $new_value;
  }


  /**
   * Rollbar check connection
   *
   * @param string $new_value
   * @param string $old_value
   * @param string $option
   *
   * @return string
   */
  static public function rollbar_check  ( $new_value = '', $old_value = '', $option = '' ) {

    if ($new_value['enable'] === 'on') {

      $result = true;

      try {
        $log_rollbar_env = wp_ng_get_option( 'log_rollbar_env', 'log_rollbar' );

        $config = array(
          'access_token'        => $new_value['access_token'],
          'environment'         => $log_rollbar_env,
          'use_error_reporting' => false,
        );

        Rollbar::init($config);

        $response = Rollbar::log(Level::INFO, 'Test Connection from wp-ng settings updated');
        if (!$response->wasSuccessful()) {
          throw new Exception(__( 'Rollbar API logging failed. Verify the access token.', 'wp-ng' ));
        }

      } catch (Exception $e) {
        $result = new WP_Error( 'wp_ng_rollbar_init', $e->getMessage() );
      }

      if ( is_wp_error( $result ) ) {
        add_settings_error(
          'errorWpNgRollbarApi',
          esc_attr( 'settings_updated' ),
          $result->get_error_message(),
          'error'
        );
      }
      else {
        add_settings_error(
          'updateWpNgRollbarApi',
          esc_attr( 'settings_updated' ),
          __('Rollbar API test connexion OK.', 'wp-ng'),
          'updated'
        );
      }
    }

    return $new_value;
  }

}
