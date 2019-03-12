<?php

/**
 * The file that defines the pluggable functions plugin class
 * This file is load on hook "plugins_loaded"
 *
 * @link       team@redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */


/**
 * Compatibility Super Cache Plugin not Installed
 */
if ( !function_exists('wp_cache_clear_cache') ) {

  // Super Cache Plugin
  function wp_cache_clear_cache () {

    //Plugin Cache Enabler
    do_action('ce_clear_cache');
  }

}
