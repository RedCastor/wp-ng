<?php

/**
 * WP NG Angular Bootstrapper for Wordpress
 *
 *
 * @link              http://redcastor.io
 * @since             1.0.0
 * @package           Wp_Ng
 *
 * @wordpress-plugin
 * Plugin Name:       WP NG
 * Plugin URI:        http://redcastor.io
 * Description:       WP NG is a Angular bootstrapper for wordpress. The plugin do automatic bootstrap your app and add module dependencie in your app.
 * Version:           1.7.8
 * Author:            Auban le Grelle
 * Author URI:        https://redcastor.io
 * Copyright:         Copyright (c) 2018, Auban le Grelle.
 * License:           MIT License
 * License URI:       http://opensource.org/licenses/MIT
 * Text Domain:       wp-ng
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define('WP_NG_PLUGIN_NAME',         'wp-ng');
define('WP_NG_PLUGIN_VERSION',      '1.7.8');
define('WP_NG_REQUIRED_WP_VERSION',	'4.5');
define('WP_NG_WP_URL', 'https://wordpress.org/plugins/wp-ng');
define('WP_NG_GITHUB_URL', 'https://github.com/RedCastor/wp-ng');

//Plugin directory
define('WP_NG_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_NG_PLUGIN_URL' , plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-ng-activator.php
 */
function activate_wp_ng() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng-activator.php';
	Wp_Ng_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-ng-deactivator.php
 */
function deactivate_wp_ng() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng-deactivator.php';
	Wp_Ng_Deactivator::deactivate();
}

/**
 * The code that runs during plugin activation if error on actiavtion
 */
function activation_note_version_wp_ng() {
  echo '<div class="error">';
  echo '<p><strong>' . esc_html( __('WP NG require minimum wp version: ' . WP_NG_REQUIRED_WP_VERSION . ' !!', 'wp-ng') ) . '</strong></p>';
  echo '</div>';
}

register_activation_hook( __FILE__, 'activate_wp_ng' );
register_deactivation_hook( __FILE__, 'deactivate_wp_ng' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng-dependencies.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_ng() {
  global $wp_version;

  if( version_compare( $wp_version, WP_NG_REQUIRED_WP_VERSION, "<") ) {
    add_action( 'admin_notices', 'activation_note_version_wp_ng');
    return;
  }


  $plugin = new Wp_Ng();
  $plugin->run();
}
run_wp_ng();
