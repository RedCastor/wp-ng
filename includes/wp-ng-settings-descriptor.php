<?php

/**
 * The file that defines the settings fields option descriptor
 *
 * @link       team@redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */



/**
 * Define general settings fields
 */
function wp_ng_settings_fields( $fields )
{

  $fields = array(
    'wp_ng_general' => array(
      'title' => __('General', 'wp-ng'),
      'sections' => array(
        'general' => array(
          'title' => __('General Settings', 'wp-ng'),
          'fields' => array(
            array(
              'name'        => 'app_name',
              'label'       => __('Application name', 'wp-ng'),
              'global'      => true,
              'placeholder' => 'wpng.root',
              'default'     => 'wpng.root',
              'type'        => 'text',
              'sanitize_callback' => 'sanitize_file_name'
            ),
            array(
              'name'        => 'combine_ng_modules',
              'label'       => __('Combine modules', 'wp-ng'),
              'desc'        => __( 'Combine the modules script and style. Combine create file in cache based on modification timestamp and module loaded in current context.' , 'wp-ng'),
              'global'      => true,
              'default'     => 'on',
              'type'        => 'checkbox',
              'sanitize_callback' => ''
            ),
            array(
              'name'        => 'ng-cloak',
              'label'       => __('Body Cloak', 'wp-ng'),
              'desc'        => __( 'Cloak the body. More info see' , 'wp-ng') . ' ( directive <a target="blank" href="https://docs.angularjs.org/api/ng/directive/ngCloak">ngCloak</a> )',
              'global'      => true,
              'default'     => 'off',
              'type'        => 'checkbox',
              'sanitize_callback' => ''
            ),
            array(
              'name'        => 'cache_hours',
              'label'       => __('Cache File Hours', 'wp-ng'),
              'desc'        => __( 'Remove file in cache base on timestamp and your hours value.' , 'wp-ng'),
              'global'      => true,
              'default'     => 48,
              'type'        => 'number',
              'sanitize_callback' => ''
            ),
            array(
              'name'        => 'purge_cache',
              'action'      => array( 'Wp_Ng_Admin_Fields_Action', 'purge_cache' ),
              'label'       => __('Purge Cache', 'wp-ng'),
              'desc'        => sprintf( __( 'Purge the cache directory. Number of file in cache: %s script, %s style' , 'wp-ng'), count(glob(Wp_Ng_Cache::cache_dir( WP_NG_PLUGIN_NAME ) . '*.js')), count(glob(Wp_Ng_Cache::cache_dir( WP_NG_PLUGIN_NAME ) . '*.css')) ),
              'global'      => true,
              'default'     => 'off',
              'type'        => 'checkbox',
              'sanitize_callback' => ''
            ),
          ),
        ),
      ),
    ),
  );

  return $fields;
}
add_filter('wp_ng_settings_fields', 'wp_ng_settings_fields');










