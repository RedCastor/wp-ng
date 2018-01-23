<?php

/**
 * The file that defines the global functions plugin class
 *
 * @link       team@redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */

/**
 * Asset Path
 *
 * @param $filename
 * @return string
 */
function wp_ng_get_asset_path($filename) {
  $dist_url = plugins_url( 'public/dist/', dirname( __FILE__ ) );
  $file = basename($filename);
  static $manifest;

  if (empty($manifest)) {
    $manifest_path = plugin_dir_path( dirname( __FILE__ ) ) . 'public/dist/assets.json';
    $manifest = new Wp_Ng_JsonManifest($manifest_path);
  }

  if (array_key_exists($file, $manifest->get())) {
    $directory = trailingslashit(dirname($filename) );

    return $dist_url . $directory . $manifest->get()[$file];
  } else {
    return $dist_url . $filename;
  }
}

/**
 * Asset Admin Path
 *
 * @param $filename
 * @return string
 */
function wp_ng_get_admin_asset_path($filename) {
  $dist_path = plugins_url( 'admin/dist/', dirname( __FILE__ ) );
  $directory = dirname($filename) . '/';
  $file = basename($filename);
  static $manifest;

  if (empty($manifest)) {
    $manifest_path = plugin_dir_path( dirname( __FILE__ ) ) . 'admin/dist/assets.json';
    $manifest = new Wp_Ng_JsonManifest($manifest_path);
  }

  if (array_key_exists($file, $manifest->get())) {
    return $dist_path . $directory . $manifest->get()[$file];
  } else {
    return $dist_path . $directory . $file;
  }
}


/**
 * Check if is a valid IP address.
 *
 * @since  3.0.6
 * @param  string $ip_address IP address.
 * @return string|bool The valid IP address, otherwise false.
 */
function wp_ng_is_ip_address( $ip_address ) {
  // WP 4.7+ only.
  if ( function_exists( 'rest_is_ip_address' ) ) {
    return rest_is_ip_address( $ip_address );
  }

  $ipv4_pattern = '/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/';

  if ( ! preg_match( $ipv4_pattern, $ip_address ) && ! Requests_IPv6::check_ipv6( $ip_address ) ) {
    return false;
  }

  return $ip_address;
}


/**
 * Get current user IP Address.
 * @return string
 */
function wp_ng_get_ip_address() {
  if ( isset( $_SERVER['HTTP_X_REAL_IP'] ) ) {
    return $_SERVER['HTTP_X_REAL_IP'];
  } elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
    // Proxy servers can send through this header like this: X-Forwarded-For: client1, proxy1, proxy2
    // Make sure we always only send through the first IP in the list which should always be the client IP.
    return (string) wp_ng_is_ip_address( trim( current( explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) ) );
  } elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
    return $_SERVER['REMOTE_ADDR'];
  }
  return '';
}


/**
 * Get user agent string.
 * @return string
 */
function wp_ng_get_user_agent() {
  return isset( $_SERVER['HTTP_USER_AGENT'] ) ? strtolower( $_SERVER['HTTP_USER_AGENT'] ) : '';
}


/**
 * Create a one time nonce
 *
 * @param int $action
 * @return string
 */
function wp_ng_create_onetime_nonce( $action = -1, $expiration = 3600 ) {
  $time = time();
  $action = $time . $action;
  $nonce = wp_create_nonce( $action );

  //Adjust the lifetime of the transient
  set_transient( '_nonce_' . $time, 1, $expiration );

  return $nonce . '-' . $time;
}

/**
 * verify a one time nonce
 *
 * @param $_nonce
 * @param int $action
 * @return bool
 */
function wp_ng_verify_onetime_nonce( $nonce, $action = -1, $invalidate = true ) {

  @list( $_nonce, $time ) = explode( '-', $nonce );

  // bad formatted onetime-nonce
  if ( empty( $_nonce ) || empty( $time ) ) {
    return false;
  }

  $nonce_transient = get_transient( '_nonce_' . $time );

  // nonce cannot be validated or has expired or was already used
  if (
    ! wp_verify_nonce( $_nonce, $time . $action ) ||
    false === $nonce_transient ||
    'used' === $nonce_transient
  ) {
    return false;
  }

  if ( $invalidate === true ) {

    wp_ng_invalidate_onetime_nonce( $nonce );
  }

  // return true to mark this nonce as valid
  return true;
}


/**
 * Invalidate a one time nonce
 *
 * @param $_nonce
 * @param int $action
 * @return bool
 */
function wp_ng_invalidate_onetime_nonce( $nonce ) {

  @list( $_nonce, $time ) = explode( '-', $nonce );

  // mark this nonce as used for 1h expiration
  set_transient( '_nonce_' . $time, 'used', 60*60 );
}


/**
 * Main instance of modules.
 *
 * Returns the main instance of modules to prevent the need to use globals.
 *
 *
 * @return Wp_Ng_Modules
 */
function wp_ng_modules() {
  return Wp_Ng_Modules::getInstance();
}

/**
 * Main instance of logger.
 *
 * Returns the main instance of modules to prevent the need to use globals.
 *
 *
 * @return Wp_Ng_Logger
 */
function wp_ng_logger() {
  return Wp_Ng_Logger::getInstance();
}

/**
 * Main instance of template.
 *
 * Returns the main instance of template to prevent the need to use globals.
 *
 * @return Wp_Ng_Template
 */
function wp_ng_template() {
  return Wp_Ng_Template::getInstance();
}

/**
 * Main instance of helper.
 *
 * Returns the main instance of helper to prevent the need to use globals.
 *
 *
 * @return Wp_Ng_Helper
 */
function wp_ng_helper() {
  return Wp_Ng_Helper::getInstance();
}

/**
 * Main instance of emails.
 *
 * Returns the main instance of emails to prevent the need to use globals.
 *
 *
 * @return Wp_Ng_Emails
 */
function wp_ng_emails() {
  return Wp_Ng_Emails::getInstance();
}


/**
 * Register a email class instance
 *
 * @param $email_id
 * @param $email_instance
 *
 * @return bool
 */
function wp_ng_register_email ( $email_id, $email_instance ) {

  return wp_ng_emails()->register_email($email_id, $email_instance);
}

/**
 * Get emails sender options
 */
function wp_ng_get_email_sender_options() {

  return wp_ng_get_options('email_sender' );
}

/**
 * Get emails sender options
 */
function wp_ng_get_email_sender_option( $name, $default = '' ) {

  $sender_options = wp_ng_get_options( 'email_sender' );

  if ( isset($sender_options[$name]) ) {
    return $sender_options[$name];
  }

  return $default;
}

/**
 * Get emails template options
 */
function wp_ng_get_email_template_options() {

  return wp_ng_get_options( 'email_template' );
}

/**
 * Get emails template option by name
 */
function wp_ng_get_email_template_option( $name, $default = '' ) {

  $template_options = wp_ng_get_options( 'email_template' );

  if ( isset($template_options[$name]) ) {
    return $template_options[$name];
  }

  return $default;
}

/**
 * Get email options by form id
 *
 * @param int $form_id
 * @return array
 */
function wp_ng_get_email_options ( $form_id ) {
  return wp_ng_helper()->get_email_options( $form_id );
}

/**
 * Add meta box for email options
 * @param $id
 * @param $title
 * @param $callback
 * @param $screen
 */
function wp_ng_add_meta_box_email_options ($post_type, $screen, $email_id, $number = 1, $simple = false) {

  return new Wp_Ng_Admin_Metabox_Email_Options($post_type, $screen, $email_id, $number, $simple);
}


function wp_ng_email_send_error_message () {

  return wp_ng_emails()->send_error_message();
}



/**
 * Get template
 *
 * @param $template_name
 * @param null $plugin_name
 * @param null $args
 * @param bool $echo
 * @return output
 */
function wp_ng_get_template( $template_name, $plugin_name = null, $args = null, $echo = true ) {
  $return = !$echo;

  return wp_ng_template()->get_template($template_name, $plugin_name, $args, $return);
}


/**
 * Settings sections descriptions
 *
 * @param $bower_name
 * @param $desc
 * @param string $version
 *
 * @return string
 */
function wp_ng_settings_sections_desc_html( $bower_name, $desc, $version = '', $module_site_url = '', $module_demo_url = '' ) {

  if ( empty($version) ) {
    $bower   = new Wp_Ng_Bower();
    $version = $bower->get_version( $bower_name );
  }

  if ( !empty($module_site_url) ) {
    $module_site_url = '&nbsp;|&nbsp;<a href="' . $module_site_url . '" target="_blank">' . __( 'Visit module site', 'wp-ng' ) . '</a>';
  }

  if ( !empty($module_demo_url) ) {
    $module_demo_url = '&nbsp;|&nbsp;<a href="' . $module_demo_url . '" target="_blank">' . __( 'Visit module demo', 'wp-ng' ) . '</a>';
  }

  $html = '<div class="module-description">';
  $html .= '<p>' . $desc . '</p>';
  $html .= '</div>';
  $html .= '<div class="second plugin-version-author-uri">';
  $html .= 'Version ' . $version;
  $html .= $module_site_url;
  $html .= $module_demo_url;
  $html .= '</div>';

  return $html;
}


/**
 * Get Plugin Option value
 */
function wp_ng_get_option( $option, $section , $default = '' ) {

  $settings_page = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );

  //$field_key = null;

  //Search Field for section option
  foreach ($settings_page->get_fields() as $key => $tab ){
    if ( isset($tab[$section]) ) {
      $section_fields = $tab[$section];
      $field_key = array_search($option, array_column($section_fields, 'name'));
      break;
    }
  }

  if ( $field_key !== null ) {
    //Set the default value if exist
    $default = ( empty( $default ) && isset( $section_fields[ $field_key ]['default'] ) ) ? $section_fields[ $field_key ]['default'] : $default;

    //Is option global
    $global = boolval( isset( $section_fields[ $field_key ]['global'] ) && $section_fields[ $field_key ]['global'] === true );

    return $settings_page->get_option( $option, $section, $default, $global );
  }

  return '';
}


/**
 * Get Plugin Options section values
 */
function wp_ng_get_options( $section ) {

  $settings = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );
  $options = array();

  //Search Field for section option
  foreach ($settings->get_fields() as $key => $tab ){
    if ( isset($tab[$section]) ) {
      foreach ($tab[$section] as $field_key => $field) {
        $default = isset($field['default']) ? $field['default'] : '';
        $options[$field['name']] = $settings->get_option( $field['name'], $section, $default, false );
      }
      break;
    }
  }

  return $options;
}



/**
 * Get Default and current Language. Compatibility with WPML
 * @param $lang
 *
 * @return array
 */
function wp_ng_get_language () {

  //WPML Exist
  if (function_exists('icl_object_id' )) {
    global $sitepress;

    $_default_lang = $sitepress->get_default_language();
    $_current_lang = ICL_LANGUAGE_CODE;
  }
  else {
    $_default_lang = explode("_", get_locale())[0];
    $_current_lang = explode("_", get_locale())[0];
  }

  $_lang = array( 'default' => $_default_lang, 'current' => $_current_lang );

  return apply_filters('wp_ng_language', $_lang);
}



/**
 * Get Logging options
 */
function wp_ng_get_log_options() {

  $log_file = wp_ng_get_options( 'log_file' );
  $log_rollbar = wp_ng_get_options( 'log_rollbar' );
  $log_rollbar['env'] = wp_ng_get_option( 'log_rollbar_env', 'log_rollbar' );

  return array(
    'file' => $log_file,
    'rollbar' => $log_rollbar
  );
}


/**
 * Get Angular App Name
 */
function wp_ng_get_app_name() {

  return wp_ng_get_option( 'app_name', 'general' );
}

/**
 * Get Angular App Element
 */
function wp_ng_get_app_element() {

  return wp_ng_get_option( 'app_element', 'general' );
}

/**
 * Get Cache hours
 */
function wp_ng_get_cache_hours() {

  return intval( wp_ng_get_option( 'cache_hours', 'general' ) );

}


/**
 * Get is combine modules
 */
function wp_ng_is_combine_modules() {

  return ( wp_ng_get_option( 'combine_ng_modules', 'general' ) === 'on') ? true : false;
}

/**
 * Get is ng-cloak
 */
function wp_ng_is_ng_cloak() {

  return (wp_ng_get_option( 'ng-cloak', 'general' ) === 'on') ? true : false;
}

/**
 * Get is ng-preload
 */
function wp_ng_is_ng_preload() {

  return (wp_ng_get_option( 'ng-preload', 'general' ) === 'on') ? true : false;
}

/**
 * Disbale WPAUTOP
 */
function wp_ng_disable_wpautop() {

  return (wp_ng_get_option( 'disable_wpautop', 'advanced' ) === 'on') ? true : false;
}

/**
 * Enable WP NG AUTOP
 */
function wp_ng_enable_wpngautop() {

  return (wp_ng_get_option( 'enable_wpngautop', 'advanced' ) === 'on') ? true : false;
}

/**
 * Disbale Verify html tinymce
 */
function wp_ng_disable_tinymce_verify_html() {

  return (wp_ng_get_option( 'disable_tinymce_verify_html', 'advanced' ) === 'on') ? true : false;
}

/**
 * Get is cdn angular enable
 */
function wp_ng_is_cdn_angular() {

  return (wp_ng_get_option( 'cdn_angular', 'advanced' ) === 'on') ? true : false;
}

/**
 * Get is cdn jquery enable
 */
function wp_ng_is_cdn_jquery() {

  return (wp_ng_get_option( 'cdn_jquery', 'advanced' ) === 'on') ? true : false;
}


/**
 * Get is angular debug enable
 */
function wp_ng_is_enbale_ng_debug() {

  return (wp_ng_get_option( 'enable_ng_debug', 'advanced' ) === 'on') ? true : false;
}


/**
 * Checks plugin wp-ng support for a given feature
 *
 * @since 1.2.15
 *
 * @global array $_wp_ng_plugin_features
 *
 * @param string $feature the feature being checked
 * @return bool
 */
function wp_ng_plugin_supports( $feature ) {
  global $_wp_ng_plugin_features;

  if ( !isset( $_wp_ng_plugin_features[$feature] ) ) {
    return false;
  }

  // If no args passed then no extra checks need be performed
  if ( func_num_args() <= 1 ) {
    return true;
  }

  $args = array_slice( func_get_args(), 1 );

  switch ( $feature ) {
    case 'wp-ng_modules':
      $type = $args[0];
      return in_array( $type, $_wp_ng_plugin_features[$feature][0] );
  }

  /**
   * Filters whether the wp-ng plugin supports a specific feature.
   *
   * @since 1.2.15
   *
   * @param bool   true     Whether the wp-ng plugin supports the given feature. Default true.
   * @param array  $args    Array of arguments for the feature.
   * @param string $feature The wp-ng plugin feature.
   */
  return apply_filters( "wp_ng_current_plugin_supports-{$feature}", true, $args, $_wp_ng_plugin_features[$feature] );
}


/*
 * Registers plugin support for a given feature.
 *
 * @global array $_wp_ng_plugin_features
 * @param mixed  $args,...  extra arguments to pass along with certain features.
 *
 * @return void|bool False on failure, void otherwise.
 */
function wp_ng_add_plugin_support( $feature ) {
  global $_wp_ng_plugin_features;

  if ( func_num_args() == 1 ) {
    $args = true;
  }
  else {
    $args = array_slice( func_get_args(), 1 );
  }

  $settings = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );
  $feature = $settings->get_option_prefix( $feature );

  if ( !is_array($_wp_ng_plugin_features)  ) {
    $_wp_ng_plugin_features = array();

  }

  if ( !isset($_wp_ng_plugin_features[$feature]) ) {
    $_wp_ng_plugin_features[$feature] = $args;
  }
  else if ( is_array($args) ) {
    //Add features if not exist and check if feature params is on
    foreach ( $args[0] as $arg_key => $arg_args) {

      if ( is_string($arg_args) && !in_array($arg_args, $_wp_ng_plugin_features[$feature][0]) ) {
        $_wp_ng_plugin_features[$feature][0][] = $arg_args;
      }
      elseif ( is_string($arg_key) && !array_key_exists($arg_key, $_wp_ng_plugin_features[$feature][0]) ) {
        $_wp_ng_plugin_features[$feature][0][$arg_key] = $arg_args;
      }
      elseif ( is_string($arg_key) && array_key_exists($arg_key, $_wp_ng_plugin_features[$feature][0]) && is_array($arg_args) ) {
        foreach ( $arg_args as $key => $value ) {
          if ( $value === 'on' ) {
            $_wp_ng_plugin_features[$feature][0][$arg_key][$key] = $value;
          }
        }
      }
    }

  }

}



/**
 * Get active modules
 *
 * @param bool $on_condition
 * @return mixed
 */
function wp_ng_get_active_modules( $on_condition = true, $cache = true ) {

  static $cache_module_handles = null;

  if ( !is_array($cache_module_handles) || !$cache || $on_condition === true ) {

    $module_handles = array();

    $modules = wp_ng_get_options( 'modules' );

    if (is_array($modules)) {

      $settings = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );

      foreach ( $modules as $module => $module_settings ) {

        $module_handle = wp_ng_sanitize_name('module', $module);

        if ( isset($module_settings['active']) && $module_settings['active'] === 'on' ) {

          $module_settings['conditions']['options'] = isset($module_settings['conditions']['options']) ? $module_settings['conditions']['options'] : array();
          $module_settings['conditions']['value'] = isset($module_settings['conditions']['value']) ? $module_settings['conditions']['value'] : 'off';

          $condition_result = true;

          if ( $on_condition === true && $module_settings['conditions']['value'] === 'on' ) {
            $condition_check = new Wp_Ng_Conditional( $module_settings['conditions']['options'] );
            $condition_result = $condition_check->result;
          }

          if ( $condition_result === true ) {
            $module_handles[$module_handle] = $module_settings;

            //Scripts module
            $module_scripts = array_filter($module_settings, function($value, $key) {
              return strpos($key, 'script') === 0;
            }, ARRAY_FILTER_USE_BOTH);


            foreach ( $module_scripts as $module_script_name => $module_script ) {

              $module_handles[$module_handle][$module_script_name] = null;

              $handle_suffix = wp_ng_sanitize_name('field', $module_script_name);

              if ( $module_script === 'on' ) {
                $module_handles[$module_handle][$module_script_name] = $module_handle . $handle_suffix;
              }
              else if ( $module_script !== 'off' && !empty( $module_script ) ) {
                $module_handles[$module_handle][$module_script_name] = $settings->get_option_prefix( $module_script ) . $handle_suffix;;
              }

            }

            //Styles module
            $module_styles = array_filter($module_settings, function($value, $key) {
              return strpos($key, 'style') === 0;
            }, ARRAY_FILTER_USE_BOTH);


            foreach ( $module_styles as $module_style_name => $module_style ) {

              $module_handles[$module_handle][$module_style_name] = null;

              $handle_suffix = wp_ng_sanitize_name('field', $module_style_name);

              if ( $module_style === 'on' ) {
                $module_handles[$module_handle][$module_style_name] = $module_handle . $handle_suffix;
              }
              else if ( $module_style !== 'off' && !empty( $module_style ) ) {
                $module_handles[$module_handle][$module_style_name] = $settings->get_option_prefix( $module_style ) . $handle_suffix;
              }

            }
          }
        }
      }
    }

    $cache_module_handles = $module_handles;
  }

  return apply_filters('wp_ng_active_modules', $cache_module_handles, $on_condition);
}


/**
 * Get module options
 *
 * @param null $empty_value
 * @param $module_handle
 *
 * @return bool|mixed|null
 */
function wp_ng_get_module_options( $module_handle ) {

  $module_handles = wp_ng_get_active_modules( false );

  if ( isset($module_handles[$module_handle]) ) {
    return $module_handles[$module_handle];
  }

  return false;
}


/**
 * Get module options
 *
 * @param string $default
 * @param $option
 * @param $module_handle
 * @return string
 */
function wp_ng_get_module_option( $option, $module_handle, $default = '' ) {

  $options = wp_ng_get_module_options( $module_handle );

  if ( is_array($options) && isset($options[$option]) && !empty($options[$option]) ) {
    return $options[$option];
  }

  return $default;
}


/**
 * Is admin gallery enable in modules active.
 *
 * @return bool
 */
function wp_ng_is_admin_gallery() {

  foreach ( wp_ng_get_active_modules( false ) as  $module_handle => $module_options) {

    if (!empty($module_options['admin_gallery'])) {
      return true;
    }
  }

  return false;
}

/**
 * Get module options field
 *
 * @param $module_handle
 * @return array
 */
function wp_ng_get_module_options_field( $module_handle, $field_name ) {


  $settings = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );
  $section = 'modules';
  $field = array();

  //Search Field for section option
  foreach ($settings->get_fields() as $key => $tab ){
    if ( isset($tab[$section]) ) {
      foreach ($tab[$section] as $fields_key => $fields) {

        if ($module_handle === wp_ng_sanitize_name('module', $fields['name']) ) {
          if (isset($fields['sub_fields'])) {
            $field_key = array_search($field_name, array_column($fields['sub_fields'], 'name'));
            $field = $fields['sub_fields'][$field_key];
          }

          break;
        }
      }
      break;
    }
  }

  return $field;
}

/**
 * Sanitize the name by
 *
 * @param string $by | module, handle, name, field
 * @param $name
 * @return mixed
 */
function wp_ng_sanitize_name( $by, $name ) {

  $replacements = array(
    '__dot__' => '.',
  );

  switch ($by) {
    case 'module':
      break;
    case 'handle':
      break;
    case 'name':

      $replacements = array(
        '.' => '__dot__',
      );
      break;
    case 'field':
      break;
  }

  $replacements = apply_filters( 'wp_ng_name_replacements' , $replacements, $by, $name);

  $to_name = str_replace(array_keys( $replacements ), array_values( $replacements ), $name);

  switch ($by) {
    case 'module':

      $settings = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );
      $to_name = $settings->get_option_prefix( $to_name );
      break;
    case 'handle':

      $settings = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );
      $to_name = $settings->get_option_remove_prefix($to_name);
      break;
    case 'name':
      break;
    case 'field':

      $field_prefix = array('script', 'style', 'admin');

      foreach ($field_prefix as $prefix) {

        if (strpos($to_name, $prefix ) === 0) {
          $to_name = substr($to_name, strlen($prefix));

          //Remove first underscore if not script or style other wise replace by dash.
          if (strpos($to_name, '_' ) === 0) {

            $to_name = substr($to_name, 1);

            if ($prefix === 'style' || $prefix === 'script') {
              $to_name = '-' . $to_name;
            }
          }

          break;
        }
      }
      break;
  }

  return apply_filters( 'wp_ng_sanitized_name' , $to_name, $name);
}


/**
 * Create array based on map keys.
 *
 * @param $keys_map
 * @param $values
 * @param bool $camelcase  (optional camelcase key destination)
 * @param array $empty_keys (optional provide array of key source to accepted value empty)
 * @return array
 */
function wp_ng_array_keys_map( $keys_map , $values, $camelcase = false, $empty_keys = array()) {

  $result = array();

  foreach ($keys_map as $key_src => $key_dest) {

    if ( !empty($key_dest) && (!empty($values[$key_src]) || in_array($key_src, $empty_keys)) ) {

      //Convert key to camelcase
      if ( $camelcase === true ) {
        $key_dest = lcfirst(str_replace(' ', '', ucwords(strtr( $key_dest, '-', ' '))));
      }

      $result[$key_dest] = $values[$key_src];
    }
  }

  return $result;
}


/**
 * Encode array to json string format
 *
 * Wordpress shortcode use bracket so set param shortcode to true for encode bracket json.
 *
 *
 * @param $str
 * @param array $arr
 * @param bool $shortcode
 * @return mixed
 */
function wp_ng_json_encode( $arr, $shortcode = false ) {

  $json_str = CJSON::encode($arr);
  $json_str = htmlentities( $json_str, ENT_NOQUOTES, 'UTF-8' );

  //Encode html entities single quote, double quote and replace json double quote by single quote
  $special = array(
    '\'' => '&#39;',
    '\"' => '&#34;',
    '"'  => "'",
  );

  if ($shortcode === true) {
    $special['['] = '%5B';
    $special[']'] = '%5D';
  }

  $str = str_replace( array_keys( $special ), array_values( $special ), $json_str );

  return $str;
}


/**
 * Encode array to json string format
 *
 * @param $str
 * @param array $arr
 * @return mixed
 */
function wp_ng_json_encode_shortcode( $arr ) {

  return wp_ng_json_encode( $arr, true);
}



/**
 * Decode json string to array format
 *
 * @param $var
 *
 * @return array|mixed|object
 */
function wp_ng_json_decode( $str ) {

  $arr = array();

  if (is_string($str)) {
    $str = html_entity_decode($str, ENT_COMPAT, 'UTF-8');

    $special = array(
      '[' => '%5B',
      ']' => '%5D',
    );

    $str = str_replace( array_values( $special ), array_keys( $special ), $str );

    $arr = CJSON::decode($str, true);

  }

  return (is_array($arr) ? $arr : array());
}



/**
 * Replace linebreak by <br> in content
 *
 * Doule linebreak is convert to single linebreak.
 *
 * Excpection of:
 * - last char before new line is a html tag ('>') or shortcode (']')
 * - is the end of content
 *
 * @since	1.5.0
 *
 * @param $content
 * @return string
 */
function wpngautop( $content, $replacement = '<br>' ) {

  if (empty($content)) {
    return $content;
  }

  $tags = apply_filters('wp_ng_linebreak_accepted_tags', array( 'p' ));
  $replacement = apply_filters('wp_ng_linebreak_replacement', $replacement);

  //Parse accepted tags for nl2br
  foreach ($tags as $tag) {
    $regex = sprintf('/<%1$s.*?\>(.*?)<\/%1$s>/si', $tag);

    if (preg_match_all($regex, $content, $matches)) {
      if (isset($matches[1])) {
        foreach($matches[1] as $a) {
          $content = str_replace($a, preg_replace("/(\r\n|\n|\r)/", $replacement, $a), $content);
        }
      }
    }

  }

  //Remove empty line with end of line.
  $content = preg_replace("/(\r\n\r\n|\r\n\t\r\n|\r\r|\n\n)/",PHP_EOL, $content);

  //Parse content with \r\n or \n or \r and replace by <br> only if not end char close html tag and not add <br> if it is the end of content.
  $new_content = '';
  $split_content = preg_split("/(\r\n|\n|\r)/", $content);

  if (count($split_content) <= 1) {
    return $content;
  }

  $last_chrs = apply_filters('wp_ng_linebreak_ignore_last_chars', array( '>', ']' ));

  foreach ($split_content as $key => $a) {

    $last_chr = substr( $a, -1);

    if ( $key === count($split_content) - 1 || in_array($last_chr, $last_chrs) ) {
      $new_content .= $a;
    }
    else {
      $new_content .= $a . $replacement;
    }
  }


  return $new_content;
}


/**
 * Apply translation shortcodes
 * WPML
 *
 * @param $atts
 * @return mixed
 */
function wp_ng_apply_translation ($atts, $default = 'text', $name = 'WP NG Form', $domain = 'wp-ng') {

  $translate = false;
  $translate_name = $name;
  $translate_domain = $domain;
  $translation_names = array();

  if (!empty($atts['translate_name'])) {
    $translate_name = $atts['translate_name'];
    unset($atts['translate_name']);
  }

  if (!empty($atts['translate_domain'])) {
    $translate_domain = $atts['translate_domain'];
    unset($atts['translate_domain']);

    if (!empty($atts['name'])) {
      $translate_name = $atts['name'];
    }
  }

  if (isset($atts['translate']) && ($atts['translate'] === 'true' || $atts['translate'] === true)) {
    $translate = true;
    unset($atts['translate']);
  }

  if (!empty($atts['translate_atts'])) {
    $translation_names = explode(',', $atts['translate_atts']);
    $translation_names = array_map('trim', $translation_names);
    unset($atts['translate_atts']);
  }

  //WPML Translation
  if ($translate === true || !empty($translation_names)) {

    if (!in_array($default, $translation_names)) {
      $translation_names[] = $default;
    }

    foreach ($translation_names as $translation_name ) {
      if ( !empty($atts[$translation_name]) ) {
        $_tr_name = sprintf('%s - %s - %s', $translate_name, $translation_name, $atts[$translation_name]);
        $atts[$translation_name] = apply_filters('wpml_translate_single_string', $atts[$translation_name], $translate_domain, $_tr_name );
      }
    }
  }

  return $atts;
}
