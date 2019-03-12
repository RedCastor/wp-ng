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

  $fields['wp_ng_general'] = array(
    'title' => __('General', 'wp-ng'),
    'sections' => array(
      'general' => array(
        'title' => __('General Settings', 'wp-ng'),
        'desc' => wp_ng_angular_desc_html('Current AngularJS '),
        'actions' => array(
          array(
            'function_to_add' => array( 'Wp_Ng_Admin_Fields_Action', 'clean_wp_cache' ),
            'priority' => 100
          )
        ),
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
            'name'        => 'app_element',
            'label'       => __('Application DOM Element', 'wp-ng'),
            'global'      => true,
            'placeholder' => 'body',
            'default'     => 'body',
            'type'        => 'text',
            'sanitize_callback' => 'sanitize_text_field'
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
            'label'       => __('Document Cloak', 'wp-ng'),
            'desc'        => __( 'Cloak the application. More info see' , 'wp-ng') . ' ( directive <a target="blank" href="https://docs.angularjs.org/api/ng/directive/ngCloak">ngCloak</a> )',
            'global'      => true,
            'default'     => 'off',
            'type'        => 'checkbox',
            'sanitize_callback' => ''
          ),
          array(
            'name'        => 'ng-preload',
            'label'       => __('Document Preload', 'wp-ng'),
            'desc'        => __( 'Preload the application. Class ng-preload is add to application element html for disable transition and set visibility to hidden on all document.' , 'wp-ng'),
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
  );


  $fields['wp_ng_advanced'] = array(
    'title' => __('Advanced', 'wp-ng'),
    'sections' => array(
      'advanced' => array(
        'title' => __('Adanced Settings', 'wp-ng'),
        'actions' => array(
          array(
            'function_to_add' => array( 'Wp_Ng_Admin_Fields_Action', 'clean_wp_cache' ),
            'priority' => 100
          )
        ),
        'fields' => array(
          array(
            'name'        => 'disable_wpautop',
            'label'       => __('Disable wpautop', 'wp-ng'),
            'desc'        => __('Disbable the automatic paragraph in all content.', 'wp-ng'),
            'global'      => true,
            'default'     => 'off',
            'type'        => 'checkbox',
            'sanitize_callback' => ''
          ),
          array(
            'name'        => 'enable_wpngautop',
            'label'       => __('Enbale Custom wpautop', 'wp-ng'),
            'desc'        => sprintf(__('Replace linebreak by %s in content. Excepted last char before new line is a html tag (\'>\') or shortcode (\']\').', 'wp-ng'), '<code>br</code>') . '<br>' . \
                             sprintf( '<p>%s <a href="https://wordpress.org/plugins/html-editor-syntax-highlighter/" target="_blank">View Plugin</a>&nbsp;|&nbsp;<a href="%s/wp-admin/update.php?action=install-plugin&plugin=html-editor-syntax-highlighter&_wpnonce=%s">Install html editor syntax highlighter plugin</a></p>',
                                      __('For better work wp editor use the HTML Editor Syntax Highlighter plugin.', 'wp-ng'),
                                      get_site_url(),
                                      wp_create_nonce('install-plugin_html-editor-syntax-highlighter')
                             ),
            'global'      => true,
            'default'     => 'off',
            'type'        => 'checkbox',
            'sanitize_callback' => ''
          ),
          array(
            'name'        => 'disable_tinymce_verify_html',
            'label'       => __('Disable Verify Html', 'wp-ng'),
            'desc'        => __('Disbable the verify html in wp editor.', 'wp-ng'),
            'global'      => true,
            'default'     => 'off',
            'type'        => 'checkbox',
            'sanitize_callback' => ''
          ),
          array(
            'name'        => 'cdn_angular',
            'label'       => __('Enable CDN Angular', 'wp-ng'),
            'desc'        => __('Enable the angular cdn with fallback.', 'wp-ng'),
            'global'      => true,
            'default'     => 'on',
            'type'        => 'checkbox',
            'sanitize_callback' => ''
          ),
          array(
            'name'        => 'cdn_angular_url',
            'label'       => __('CDN URL Angular', 'wp-ng'),
            'desc'        => __('CDN Format ( //your-cdn.com/libs/angularjs/%version%/%file% )', 'wp-ng'),
            'placeholder' => '//your-cdn.com/libs/%name%/%version%/%file%',
            'default'     => '',
            'type'        => 'text',
          ),
          array(
            'name'        => 'cdn_jquery',
            'label'       => __('Enable CDN Jquery', 'wp-ng'),
            'desc'        => __('Enable the jquery and jquery-migrate cdn with fallback.', 'wp-ng'),
            'global'      => true,
            'default'     => 'on',
            'type'        => 'checkbox',
            'sanitize_callback' => ''
          ),
          array(
            'name'        => 'cdn_jquery_footer',
            'label'       => __('CDN Jquery In Footer', 'wp-ng'),
            'desc'        => __('Place the jquery and jquery-migrate cdn in the footer only for frontend.', 'wp-ng'),
            'global'      => true,
            'default'     => 'off',
            'type'        => 'checkbox',
            'sanitize_callback' => ''
          ),
          array(
            'name'        => 'cdn_jquery_url',
            'label'       => __('CDN URL Jquery', 'wp-ng'),
            'desc'        => __('CDN Format ( //your-cdn.com/libs/jquery/%version%/%file% )', 'wp-ng'),
            'placeholder' => '//your-cdn.com/libs/%name%/%version%/%file%',
            'default'     => '',
            'type'        => 'text',
          ),
          array(
            'name'        => 'cdn_jquery_migrate_url',
            'label'       => __('CDN URL Jquery Migrate', 'wp-ng'),
            'desc'        => __('CDN Format ( //your-cdn.com/libs/jquery-migrate/%version%/%file% )', 'wp-ng'),
            'placeholder' => '//your-cdn.com/libs/%name%/%version%/%file%',
            'default'     => '',
            'type'        => 'text',
          ),
          array(
            'name'        => 'combine_handles_style',
            'label'       => __('Combine handles style', 'wp-ng'),
            'desc'        => __('One handle per line.', 'wp-ng'),
            'global'      => true,
            'default'     => '',
            'type'        => 'textarea',
            'sanitize_callback' => 'sanitize_textarea_field'
          ),
          array(
            'name'        => 'combine_handles_script',
            'label'       => __('Combine handles script', 'wp-ng'),
            'desc'        => __('One handle per line.', 'wp-ng'),
            'global'      => true,
            'default'     => '',
            'type'        => 'textarea',
            'sanitize_callback' => 'sanitize_textarea_field'
          ),
          array(
            'name'        => 'rest_nonce_hours',
            'label'       => __('Rest Api nonce Life Hours', 'wp-ng'),
            'desc'        => __( 'Set the time of the nonce life for rest api header X-WP-NG-Nonce if 0 is disabled or if use cache enabler set 1 minute greather than cache value.' , 'wp-ng'),
            'global'      => true,
            'default'     => 0,
            'type'        => 'number',
            'sanitize_callback' => 'absint'
          ),
          array(
            'name'        => 'enable_ng_debug',
            'label'       => __('Enable Angular Debug', 'wp-ng'),
            'desc'        => __('Activate the angular javascript debugging.', 'wp-ng'),
            'global'      => true,
            'default'     => 'off',
            'type'        => 'checkbox',
            'sanitize_callback' => ''
          ),
        ),
      ),
    ),
  );


  $fields['wp_ng_log'] = array(
    'title' => __('Logging', 'wp-ng'),
    'sections' => array(
      'log_file' => array(
        'title' => __('Logging File Settings', 'wp-ng'),
        'desc'  => __('Use this action to add log', 'wp-ng') . '&nbsp;&nbsp;"do_action(\'wp_ng_log_%LEVEL%\', \'your-handle\', \'Your log message\');"',
        'fields' => array(
          array(
            'name'    => 'enable',
            'label'   => __('Enable', 'wp-ng'),
            'desc'    => __('Activate file logging', 'wp-ng'),
            'default' => 'off',
            'type'    => 'checkbox',
          ),
          array(
            'name'        => 'track_level',
            'label'       => __('Track Level', 'wp-ng'),
            'placeholder' => __('Chose levels', 'wp-ng'),
            'default'     => array(WP_NG_LOG_EMERGENCY, WP_NG_LOG_CRITICAL, WP_NG_LOG_ERROR, WP_NG_LOG_WARNING),
            'type'        => 'multiselect',
            'options'     => array(
              1     => 'EMERGENCY',
              2     => 'CRITICAL',
              4     => 'ERROR',
              8     => 'WARNING',
              16    => 'DEBUG',
              32    => 'INFO',
              64    => 'NOTICE',
              128   => 'ALERT',
            ),
          ),
        ),
      ),
      'log_rollbar' => array(
        'title' => __('Logging Rollbar Settings', 'wp-ng'),
        'desc' => '<h4>Catch Errors Before Your Users Do.&nbsp;&nbsp;<a href="https://rollbar.com" target="_blank" >https://rollbar.com</a></h4><p>Full-stack error monitoring and analytics for developers</p>',
        'action'      => array( 'Wp_Ng_Admin_Fields_Action', 'rollbar_check' ),
        'fields' => array(
          array(
            'name'        => 'enable',
            'label'       => __('Enable', 'wp-ng'),
            'desc'        => __('Activate Rollbar logging', 'wp-ng'),
            'default'     => 'off',
            'type'        => 'checkbox',
          ),
          array(
            'name'        => 'access_token',
            'label'       => __('Access Token', 'wp-ng'),
            'desc'        => __('Set your server access token', 'wp-ng'),
            'default'     => '',
            'type'        => 'text',
            'sanitize_callback' => 'sanitize_key',
          ),
          array(
            'name'        => 'log_rollbar_env',
            'label'       => __('Environment', 'wp-ng'),
            'default'     => defined('WP_ENV') ? WP_ENV : 'production',
            'type'        => 'text',
            'global'      => true,
            'sanitize_callback' => 'sanitize_key',
          ),
          array(
            'name'        => 'track_level',
            'label'       => __('Track Level', 'wp-ng'),
            'placeholder' => __('Chose levels', 'wp-ng'),
            'default'     => array(WP_NG_LOG_EMERGENCY, WP_NG_LOG_CRITICAL, WP_NG_LOG_ERROR, WP_NG_LOG_WARNING),
            'type'        => 'multiselect',
            'options'     => array(
              1     => 'EMERGENCY',
              2     => 'CRITICAL',
              4     => 'ERROR',
              8     => 'WARNING',
              16    => 'DEBUG',
              32    => 'INFO',
              64    => 'NOTICE',
              128   => 'ALERT',
            ),
          ),
          array(
            'name'        => 'enable_debug',
            'label'       => __('Enable PHP Debug', 'wp-ng'),
            'desc'        => __('Attention this option override the default wordpress error reporting and set with tracked php level value defined under this option', 'wp-ng'),
            'default'     => 'off',
            'type'        => 'checkbox',
          ),
          array(
            'name'        => 'enable_track_php',
            'label'       => __('Enable Track PHP', 'wp-ng'),
            'default'     => 'off',
            'type'        => 'checkbox',
          ),
          array(
            'name'        => 'track_php_errno',
            'label'       => __('Track PHP', 'wp-ng'),
            'placeholder' => __('Chose debug levels', 'wp-ng'),
            'default'     => array(E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_ERROR, E_WARNING, E_PARSE, E_USER_ERROR, E_USER_WARNING, E_RECOVERABLE_ERROR),
            'type'        => 'multiselect',
            'options'     => array(
              1     => 'E_ERROR',
              2     => 'E_WARNING',
              4     => 'E_PARSE',
              8     => 'E_NOTICE',
              16    => 'E_CORE_ERROR',
              32    => 'E_CORE_WARNING',
              64    => 'E_COMPILE_ERROR',
              128   => 'E_COMPILE_WARNING',
              256   => 'E_USER_ERROR',
              512   => 'E_USER_WARNING',
              1024  => 'E_USER_NOTICE',
              2048  => 'E_STRICT',
              4096  => 'E_RECOVERABLE_ERROR',
              8192  => 'E_DEPRECATED',
              16384 => 'E_USER_DEPRECATED',
              32767 => 'E_ALL',
            ),
          ),
        ),
      ),
    ),
  );


  //Enable emails if supported by activated plugins
  if ( wp_ng_plugin_supports('wp-ng_email') ) {

    $fields['wp_ng_email'] = array(
      'title' => __('Email', 'wp-ng'),
      'sections' => array(
        'email_sender' => array(
          'title' => __('Email Sender Options', 'wp-ng'),
          'fields' => array(
            array(
              'name' => 'from_name',
              'label' => __('"From" Name', 'wp-ng'),
              'default' => get_option('blogname'),
              'type' => 'text',
            ),
            array(
              'name' => 'from_address',
              'label' => __('"From" Address', 'wp-ng'),
              'default' => get_option('admin_email'),
              'type' => 'email',
            ),
          ),
        ),
        'email_template' => array(
          'title' => __('Email Template Options', 'wp-ng'),
          'fields' => array(
            array(
              'name' => 'header_image',
              'label' => __('Header Image', 'wp-ng'),
              'desc' => __('Url to a image', 'wp-ng'),
              'default' => '',
              'type' => 'url',
            ),
            array(
              'name' => 'footer_text',
              'label' => __('Footer Text', 'wp-ng'),
              'desc' => __('Text of the footer', 'wp-ng'),
              'default' => get_bloginfo('name') . ' - Powered by RedCastor',
              'type' => 'textarea',
            ),
            array(
              'name' => 'base_color',
              'label' => __('Base Colour', 'wp-ng'),
              'default' => '#bc0825',
              'type' => 'color',
            ),
            array(
              'name' => 'bg_color',
              'label' => __('Background Color', 'wp-ng'),
              'default' => '#f5f5f5',
              'type' => 'color',
            ),
            array(
              'name' => 'body_bg_color',
              'label' => __('Body Background Colour', 'wp-ng'),
              'default' => '#fdfdfd',
              'type' => 'color',
            ),
            array(
              'name' => 'body_text_color',
              'label' => __('Body Text Colour', 'wp-ng'),
              'default' => '#3d3d3d',
              'type' => 'color',
            ),
          ),
        ),
      ),
    );

    //Options for woocommerce
    if ( Wp_Ng_Dependencies::Woocommerce_active_check() ) {

      $fields['wp_ng_email']['sections']['email_template']['fields'][] = array(
        'name' => 'woocommerce_hf',
        'label' => __('Woocommerce Header and Footer', 'wp-ng'),
        'desc' => __('Override template option for send email with header and footer from woocommerce template.', 'wp-ng'),
        'default' => 'off',
        'type' => 'checkbox',
      );

      $fields['wp_ng_email']['sections']['email_template']['fields'][] = array(
        'name' => 'woocommerce_style',
        'label' => __('Style Woocommerce', 'wp-ng'),
        'desc' => __('Override template option for send email with style from woocommerce.', 'wp-ng'),
        'default' => 'off',
        'type' => 'checkbox',
      );
    }
  }

  if ( Wp_Ng_Dependencies::Elementor_active_check() ) {

    $fields['wp_ng_advanced']['sections']['advanced']['fields'][] = array(
      'name' => 'combine_elementor',
      'label' => __('Combine Elementor', 'wp-ng'),
      'desc' => __('Combine the scripts and styles elementor handles.', 'wp-ng'),
      'default' => 'off',
      'type' => 'checkbox',
    );
  }

  return $fields;
}
add_filter('wp_ng_settings_fields', 'wp_ng_settings_fields');










