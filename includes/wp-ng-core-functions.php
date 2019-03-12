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
function wp_ng_get_asset_path($filename, $admin = false) {

  if (!$admin) {
    static $manifest_public;

    $path = 'public/dist/';
    $manifest = $manifest_public;
  }
  else {
    static $manifest_admin;

    $path = 'admin/dist/';
    $manifest = $manifest_admin;
  }


  $dist_url = plugins_url( $path, dirname( __FILE__ ) );
  $file = basename($filename);

  if (empty($manifest)) {
    $manifest_path = plugin_dir_path( dirname( __FILE__ ) ) . $path . 'assets.json';
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

  return wp_ng_get_asset_path($filename, true);
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
 * Change nonce life time on cache enable
 *
 * @param $expires_seconds
 * @return int
 */
function wp_ng_life_time_rest_nonce( $expires_seconds ) {

  $expires_hours = wp_ng_get_rest_nonce_hours();

  /* WP_CACHE change nonce life time */
  if ( $expires_hours == 0 && wp_ng_is_advanced_cache() ) {

    // For third party plugin cache enabler options
    if (class_exists('Cache_Enabler')) {
      $options = Cache_Enabler::$options;

      $expires_hours = absint($options['expires']);
    }
  }

  //Greather than 1min
  if ($expires_hours > 0) {
    //Add 1 min to extend more life
    $expires_seconds = ($expires_hours * HOUR_IN_SECONDS) + MINUTE_IN_SECONDS;
  }

  return $expires_seconds;
}


/**
 * Verify Rest nonce
 *
 * @param $nonce
 * @return bool|int
 */
function wp_ng_verify_rest_nonce ( $nonce ) {

  //Add change nonce life
  add_filter('nonce_life', 'wp_ng_life_time_rest_nonce' );

  $result = wp_verify_nonce( $nonce, 'wp_ng_rest' );

  //Add change nonce life
  remove_filter('nonce_life', 'wp_ng_life_time_rest_nonce' );

  return $result;
}


/**
 * Create Rest nonce
 *
 * @return bool|string
 */
function wp_ng_create_rest_nonce () {

  //Add change nonce life
  add_filter('nonce_life', 'wp_ng_life_time_rest_nonce' );

  $nonce = wp_create_nonce('wp_ng_rest');

  //Remove change nonce life
  remove_filter('nonce_life', 'wp_ng_life_time_rest_nonce' );

  return $nonce;
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
 * Set the cookie config
 *
 * Used for update wpNgConfig in cookie if WP_CACHE is enabled
 */
function wp_ng_set_cookie_config () {

  /* WP_CACHE use cookie to send fresh CSRF Nonce */
  if ( wp_ng_is_advanced_cache() ) {

    $_config = apply_filters('wp_ng_cookie_config', array(
      'modules' => array(
        'wpNgRest' => array(
          'restNonceVal'=> wp_ng_create_rest_nonce(),
        ),
      )
    ));

    setcookie('wpNgConfig', json_encode($_config), time() + YEAR_IN_SECONDS, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN);
  }
  else {
    setcookie( 'wpNgConfig', ' ', time() - YEAR_IN_SECONDS, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN );
  }

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
 * Main instance of scripts.
 *
 * Returns the main instance of scripts to prevent the need to use globals.
 *
 *
 * @return Wp_Ng_Modules
 */
function wp_ng_scripts() {
  return Wp_Ng_Scripts::getInstance();
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
 * Get Base Url
 */
function wp_ng_get_base_url () {

  static $cache_base_url;

  if (!empty($cache_base_url)) {
    return $cache_base_url;
  }

  $page_id = 0;

  if (wp_ng_is_module_active('ui.router')) {
    $page_id = apply_filters( 'wp_ng_translate_id', wp_ng_get_module_option( 'base_page_id', 'ui.router', 0), 'page', true );
  }

  $base_url = $page_id ? get_permalink($page_id) : false;

  $cache_base_url = $base_url ? $base_url : home_url( '/' );

  return $cache_base_url;
}

/**
 * Get Current Url
 */
function wp_ng_get_current_url ( $relative = false ) {

  global $wp;

  if ($relative) {
    return trailingslashit('/'. $wp->request);
  }

  return home_url( trailingslashit($wp->request) );
}


/**
 * Get router state by post_id
 *
 * @param $post_id
 * @return object
 */
function wp_ng_get_ng_router_state ( $post_id ) {

  return Wp_Ng_Public_Ui_Router::get_ng_router_state( $post_id );
}


/**
 * Get router url by post_id
 *
 * @param      $post_id
 * @param bool $relative
 *
 * @return bool|string
 */
function wp_ng_get_ng_router_url ( $post_id, $relative = false ) {

  return Wp_Ng_Public_Ui_Router::get_routed_url($post_id, $relative);
}


/**
 * Get router state by post_id
 *
 * @param $post_id
 * @return object
 */
function wp_ng_get_ng_router_state_fields ( $post_id ) {

  return Wp_Ng_Public_Ui_Router::get_ng_router_state_fields( $post_id );
}

function wp_ng_delete_ng_router_cache() {

  return Wp_Ng_Public_Ui_Router::delete_cache();
}


/**
 * Add meta box for email options
 *
 * @param $post_type
 * @param $screen
 *
 * @return Wp_Ng_Admin_Metabox_Ng_Router
 */
function wp_ng_add_meta_box_ng_router ($post_type, $screen) {

  return new Wp_Ng_Admin_Metabox_Ng_Router($post_type, $screen);
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
 * Get template part  string
 * @param string $slug
 * @param string|null $name
 * @return string
 */
function wp_ng_load_template_part( string $slug, string $name = null ) {

  ob_start();

  get_template_part($slug, $name);

  return wp_ng_trim_all(ob_get_clean());
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
 * Get angular description
 *
 * @param $desc
 *
 * @return string
 */
function wp_ng_angular_desc_html( $desc ) {

  if ( empty($version) ) {
    $bower   = new Wp_Ng_Bower();
    $version = $bower->get_version( 'angular' );
  }

  $html = '';

  $html .= '<p>';
  $html .= $desc . '<br>';
  $html .= 'Version ' . $version;
  $html .= '</p>';

  return $html;
}



/**
 * Get Plugin Option value
 */
function wp_ng_get_option( $option, $section , $default = '' ) {

  $settings = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );

  $field_key = null;

  //Search Field for section option
  foreach ($settings->get_fields() as $key => $tab ){
    if ( isset($tab[$section]) ) {
      $section_fields = $tab[$section];
      $field_key = array_search($option, array_column($section_fields, 'name'));
      break;
    }
  }

  if ( $field_key !== null ) {
    //Set the default value if exist
    $field = $section_fields[ $field_key ];

    $default = ( empty( $default ) && isset( $field['default'] ) ) ? $field['default'] : $default;

    //Is option global
    $global = boolval( isset( $field['global'] ) && $field['global'] === true );

    $value = $settings->get_option( $option, $section, $default, $global );
    $value = $settings->set_default_values($field, $value);

    return $value;
  }

  return '';
}


/**
 * Get Plugin Options section values
 */
function wp_ng_get_options( $section ) {

  $settings = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );
  $section_options = array();

  //Search Field for section option
  foreach ($settings->get_fields() as $key => $tab ){
    if ( isset($tab[$section]) ) {
      foreach ($tab[$section] as $field_key => $field) {

        $default = isset($field['default']) ? $field['default'] : '';
        $value = $settings->get_option( $field['name'], $section, $default, false );
        $value = $settings->set_default_values($field, $value);

        $section_options[$field['name']] = $value;
      }
      break;
    }
  }

  return $section_options;
}


/**
 * Get all options in tab
 *
 * @param $section
 * @return array
 */
function wp_ng_get_tab_options( $tab ) {

  $settings = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );
  $options = array();
  $setting_fields = $settings->get_fields();

  //Search Field for section option
  if ( !empty($setting_fields[$tab]) ) {

    foreach ( $setting_fields[$tab] as $section_key => $section ) {
      foreach ($section as $field_key => $field) {
        $default = isset($field['default']) ? $field['default'] : '';
        $options[$section_key][$field['name']] = $settings->get_option( $field['name'], $section_key, $default, false );
      }
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

  return absint( wp_ng_get_option( 'cache_hours', 'general' ) );

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
 * Get is cdn jquery enable
 */
function wp_ng_is_cdn_jquery_footer() {

  if (wp_ng_elementor_is_preview_mode() || is_admin() ) {
    return false;
  }

  return (wp_ng_get_option( 'cdn_jquery_footer', 'advanced' ) === 'on') ? true : false;
}


/**
 * Get Combine handles for style
 */
function wp_ng_get_combine_handles_style() {
  $text_handles = wp_ng_get_option( 'combine_handles_style', 'advanced' );
  $text_handles = wp_ng_trim_all($text_handles, NULL, ',');

  $handles = array();

  foreach (explode(',', $text_handles) as $handle) {
    $handles[$handle] = false;
  }

  return $handles;
}


/**
 * Get Combine handles for style
 */
function wp_ng_get_combine_handles_script() {
  $text_handles = wp_ng_get_option( 'combine_handles_script', 'advanced' );
  $text_handles = wp_ng_trim_all($text_handles, NULL, ',');

  $handles = array();

  foreach (explode(',', $text_handles) as $handle) {
    $handles[$handle] = false;
  }


  return $handles;
}


/**
 * Get Rest nonce life hours
 */
function wp_ng_get_rest_nonce_hours() {

  return absint( wp_ng_get_option( 'rest_nonce_hours', 'advanced' ) );

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
 * Parse options module or script.
 *
 * @param $by
 * @param $setting_name
 * @param $settings
 * @return mixed
 */
function wp_ng_parse_script_options ( $by, $name, $options ) {

  $script_settings = $options;

  //Scripts
  $scripts = array_filter($options, function($value, $key) {
    return strpos($key, 'script') === 0;
  }, ARRAY_FILTER_USE_BOTH);


  foreach ( $scripts as $script_name => $script ) {

    $script_settings[$script_name] = null;

    $handle_suffix = wp_ng_sanitize_name('field', $script_name);

    if ( $script === 'on' ) {
      $script_settings[$script_name] = wp_ng_sanitize_name($by, $name) . $handle_suffix;
    }
    else if ( $script !== 'off' && !empty( $script ) ) {
      $script_settings[$script_name] = wp_ng_sanitize_name($by, $script). $handle_suffix;;
    }

  }

  //Styles
  $script_styles = array_filter($options, function($value, $key) {
    return strpos($key, 'style') === 0;
  }, ARRAY_FILTER_USE_BOTH);


  foreach ( $script_styles as $style_name => $style ) {

    $script_settings[$style_name] = null;

    $handle_suffix = wp_ng_sanitize_name('field', $style_name);

    if ($style === 'on') {
      $script_settings[$style_name] = wp_ng_sanitize_name($by, $name) . $handle_suffix;
    } else if ($style !== 'off' && !empty($style)) {
      $script_settings[$style_name] = wp_ng_sanitize_name($by, $style) . $handle_suffix;
    }

  }

  return $script_settings;
}


/**
 * @param $script
 * @param bool $on_condition
 * @return bool
 */
function wp_ng_is_script_active( $script, $in, $on_condition = true ) {
  global $wp_ng_scripts;

  $is_script_active = false;

  if ( empty($wp_ng_scripts[$in]) ) {
    $wp_ng_scripts[$in] = wp_ng_get_options( $in );
  }

  $script = wp_ng_sanitize_name('name', $script);

  $script_settings = array_key_exists($script, $wp_ng_scripts[$in]) ? $wp_ng_scripts[$in][$script] : array();

  if ( isset($script_settings['active']) && $script_settings['active'] === 'on' ) {

    if (!is_array($script_settings['conditions'])) {
      $condition_value = $script_settings['conditions'];
      $script_settings['conditions'] = array(
        'options' => array(),
        'value' => $condition_value,
      );
    }
    else {

      if ( !isset($script_settings['conditions']['options']) ) $script_settings['conditions']['options'] = array();
      if ( !isset($script_settings['conditions']['value']) ) $script_settings['conditions']['value'] = 'off';
    }

    $is_script_active = true;

    //Check condition
    if ($on_condition === true && $script_settings['conditions']['value'] === 'on') {
      $condition_check = new Wp_Ng_Conditional($script_settings['conditions']['options']);
      $is_script_active = $condition_check->result;
    }
  }

  return $is_script_active;
}


/**
 * Get active scripts
 *
 * @since 1.5.1
 *
 * @param bool $on_condition
 * @return mixed
 */
function wp_ng_get_active_scripts( $cache = true, $on_condition = true) {
  global $wp_ng_scripts;

  static $cache_script_handles = null;

  $script_handles = array();

  if ( empty($cache_script_handles) || !$cache || $on_condition === true ) {

    if (empty($wp_ng_scripts['scripts'])) {
      $wp_ng_scripts['scripts'] = wp_ng_get_options( 'scripts' );
    }

    if (is_array($wp_ng_scripts['scripts'])) {

      $settings = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );

      foreach ( $wp_ng_scripts['scripts'] as $script => $options ) {

        $is_script_active = wp_ng_is_script_active( $script, 'scripts', $on_condition);

        if ( $is_script_active === true ) {

          $script_handles[wp_ng_sanitize_name('script', $script)] = wp_ng_parse_script_options( 'script', $script, $options );
        }
      }
    }

    if ( $on_condition !== true ) {
      $cache_script_handles = $script_handles;
    }
  }
  else {
    $script_handles = $cache_script_handles;
  }

  return apply_filters('wp_ng_active_scripts', $script_handles, $on_condition);
}


/**
 * Get script options
 *
 * @since 1.5.1
 *
 * @param $script script|script_handle
 * @return bool|mixed|null
 */
function wp_ng_get_script_options( $script ) {

  $_script = wp_ng_sanitize_name('handle', $script);
  $scripts = wp_ng_get_options( 'scripts' );
  $script_name = wp_ng_sanitize_name('name', $_script);

  if ( isset($scripts[$script_name]) ) {
    return $scripts[$script_name];
  }

  return false;
}


/**
 * Parse options module or script.
 *
 * @param $by
 * @param $setting_name
 * @param $settings
 * @return mixed
 */
function wp_ng_parse_module_options ( $name, $options ) {

  return wp_ng_parse_script_options( 'module', $name, $options );
}

/**
 * Is Module active
 *
 * @param $module
 * @param bool $on_condition
 * @return bool
 */
function wp_ng_is_module_active( $module, $on_condition = true ) {

  return wp_ng_is_script_active( $module, 'modules', $on_condition);
}


/**
 * Get active modules
 *
 * @param bool $on_condition
 * @return mixed
 */
function wp_ng_get_active_modules( $on_condition = true, $cache = true ) {
  global $wp_ng_scripts;

  static $cache_module_handles = null;

  $module_handles = array();

  if ( empty($cache_module_handles) || !$cache || $on_condition === true ) {

    if (empty($wp_ng_scripts['modules'])) {
      $wp_ng_scripts['modules'] = wp_ng_get_options( 'modules' );
    }

    if (is_array($wp_ng_scripts['modules'])) {

      $settings = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );

      foreach ( $wp_ng_scripts['modules'] as $module => $options ) {

        $is_module_active = wp_ng_is_module_active( $module, $on_condition);

        if ( $is_module_active === true ) {

          $module_handles[wp_ng_sanitize_name('module', $module)] = wp_ng_parse_module_options( $module, $options );
        }
      }
    }

    if ( $on_condition !== true ) {
      $cache_module_handles = $module_handles;
    }
  }
  else {
    $module_handles = $cache_module_handles;
  }

  return apply_filters('wp_ng_active_modules', $module_handles, $on_condition);
}


/**
 * Get module options
 *
 * @param $module module|module_handle
 *
 * @return bool|mixed|null
 */
function wp_ng_get_module_options( $module ) {

  $_module = wp_ng_sanitize_name('handle', $module);
  $ng_modules = wp_ng_get_options( 'modules' );
  $module_name = wp_ng_sanitize_name('name', $_module);

  if ( isset($ng_modules[$module_name]) ) {
    return $ng_modules[$module_name];
  }

  return false;
}


/**
 * Get module options
 *
 * @param string $default
 * @param $option
 * @param $module module|module_handle
 * @return string
 */
function wp_ng_get_module_option( $option, $module, $default = '' ) {

  $ng_module = wp_ng_sanitize_name('handle', $module);
  $options = wp_ng_get_module_options( $ng_module );

  if ( is_array($options) && isset($options[$option]) && !empty($options[$option]) ) {
    return $options[$option];
  }

  return $default;
}


/**
 * Get dependencies for script or style handle.
 *
 * @param $handle
 * @param bool $style
 * @return array
 */
function wp_ng_get_script_deps ( $handle, $style = false ) {

  $scripts = $style ? wp_styles() : wp_scripts();

  if ( !isset($scripts->registered[$handle]) ){
    return array();
  }

  $handle_script = $scripts->registered[$handle];
  $handles = array();

  foreach ( $handle_script->deps as $dep_handle ) {

    if (!in_array($dep_handle, $handles) && isset($scripts->registered[$dep_handle]) ) {
      //Recusrive deps script
      $handles = array_replace($handles, wp_ng_get_script_deps( $dep_handle, $style));

      $dep_handle_scipt = $scripts->registered[$dep_handle];

      if ($dep_handle_scipt->src !== false && !in_array($dep_handle, $scripts->done) ) {
        $handles[$dep_handle] = $dep_handle_scipt->src;
      }
    }
  }

  return $handles;
}


/**
 * Get script or style handles with source for a handle or handle start with.
 *
 * @param $handles
 * @param bool $style
 * @param bool $start_with
 * @return array
 */
function wp_ng_get_script_handles_source ( $handles, $style = false ) {

  $sources = array();
  $scripts = $style ? wp_styles() : wp_scripts();

  if ( !is_array($handles) ) {
    $handles = array($handles);
  }

  $find_queue_scripts = array();

  foreach ($handles as $handle => $start_with ) {
    if ( $start_with === true ) {
      $find_queue_scripts = wp_parse_args(array_filter($scripts->queue, function($val) use ($handle) {
        return strpos($val, $handle) === 0;
      }), $find_queue_scripts);
    }
    else if ( in_array($handle, $scripts->queue) ){
      $find_queue_scripts[] = $handle;
    }
  }

  foreach ( $scripts->queue as $queue_handle ) {

    if ( !in_array( $queue_handle, $find_queue_scripts) ) {
      continue;
    }

    $find_script = $scripts->registered[$queue_handle];

    $dep_handles = wp_ng_get_script_deps($queue_handle, $style);
    $sources = array_replace($sources, $dep_handles);

    if ( $find_script->src !== false && !in_array($queue_handle, $scripts->done) ) {
      $sources[$queue_handle] = $find_script->src;
    }
  }

  return $sources;
}


/**
 * Get style handles with source for a handle or handle start with.
 *
 * @param $handles
 * @param bool $start_with
 * @return array
 */
function wp_ng_get_style_handles_source ( $handles ) {

  return wp_ng_get_script_handles_source( $handles, true );
}


/**
 * Get scripts for a modules with dependencie
 *
 * @param $modules module|module_handle
 * @param bool $style
 * @return array
 */
function wp_ng_get_modules_scripts ( $modules, $lazyload = false , $style = false ) {

  if ( !is_array($modules) ) {
    $modules = array($modules);
  }

  $ng_module = wp_ng_modules();
  $scripts = $style ? wp_styles() : wp_scripts();
  $script_src = array();

  foreach ($modules as $module) {
    $module_handle = wp_ng_sanitize_name('module', $module);
    $is_handle = ($module === $module_handle) ? true : false;


    $ng_handles = $ng_module->get_ng_module_from_handle( $module_handle, $scripts->registered, $scripts);

    //Not lazy load module and deps if is in queue.
    if (!$lazyload || array_search($module_handle, $scripts->queue) === false ) {

      foreach ( $ng_handles as $ng_handle => $type ) {

        //For lazyload if handle is not in queue add source
        if (
          !isset($script_src[$ng_handle]) && $type &&
          isset($scripts->registered[$ng_handle]) &&
          (!$lazyload || array_search($ng_handle, $scripts->queue) === false)) {

          $module_key = !$is_handle ? wp_ng_sanitize_name('handle', $ng_handle) : $ng_handle;
          $lazyload_ext = '';

          //Add prefix oc.LazyLoad if file not prefixed.
          if ($lazyload) {
            $filetype = wp_check_filetype($scripts->registered[$ng_handle]->src);

            if ( !$filetype['ext'] ) {
              $lazyload_ext = !$style ? 'js!' : 'css!';
            }
          }

          $script_src[$module_key] = $lazyload_ext . $scripts->registered[$ng_handle]->src;
        }
      }
    }
  }

  return $script_src;
}


/**
 * Get styles for a modules with dependencie
 *
 * @param $modules
 * @param bool $lazyload
 * @return array
 */
function wp_ng_get_modules_styles ( $modules, $lazyload = false  ) {

  return wp_ng_get_modules_scripts($modules, $lazyload,true);
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
    case 'script':
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
    case 'script':
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
 * Escape string for shortcode
 *
 * @param string $str
 * @return string
 */
function wp_ng_esc_shortcode( $str ) {

  $escaped_str = esc_html( $str );

  $special = array(
    '[' => '%5B',
    ']' => '%5D'
  );

  $escaped_str = str_replace( array_keys( $special ), array_values( $special ), $escaped_str );

  return  $escaped_str;
}


/**
 * Decode string for shortcode
 *
 * @param $str
 * @return string
 */
function wp_ng_shortcode_decode( $str ) {

  $special = array(
    '[' => '%5B',
    ']' => '%5D',
  );

  $decoded_str = str_replace( array_values( $special ), array_keys( $special ), $str );

  return wp_specialchars_decode($decoded_str, 'ENT_QUOTES');
}


/**
 * Encode to json string format
 *
 * Wordpress shortcode use bracket so set param shortcode to true for encode bracket json.
 * The param shortcode true prevent UTF8 from CJSON encoding
 *
 * @param $str
 * @param mixed $src
 * @param bool $shortcode
 * @return mixed
 */
function wp_ng_json_encode( $src, $shortcode = false ) {

  $json_str = CJSON::encode($src);
  $json_str = htmlentities( $json_str, ENT_NOQUOTES, 'UTF-8' );

  //Encode html entities single quote, double quote and replace json double quote by single quote
  $special = array(
    '\'' => "\\'",   //Escape single quote for ng-init
    '\"' => '&#34;',
    '"'  => "'",
  );

  if ($shortcode === true) {
    $special["\u"] = "\\\\u"; //prevent utf8 for db store
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
  else if( is_array($str) ) {
    $arr = $str;
  }

  return (is_array($arr) ? $arr : array());
}


/**
 * Get array of html attributes
 * @param $args
 * @return array
 */
function wp_ng_get_html_attributes ( $args, $prefix = '', $shortcode = false ) {

  $attrs = array();

  if ( !is_array($args) ) {
    return $attrs;
  }

  foreach ($args as $key => $val) {

    if ($val !== null) {

      if (is_bool($val)) {
        $val = $val === true ? 'true' : 'false';
      }

      $attr_key = $key;

      if (!ctype_lower($key)) {
        $attr_key = strtolower(preg_replace('/((?<=[a-z])(?=[A-Z])|(?=[A-Z][a-z]))/', '-$1', $key));
      }

      if ($val === '') {
        $attrs[] = sprintf('%s%s', $prefix, $attr_key);
      }
      else {
        $attrs[] = sprintf('%s%s="%s"', $prefix, $attr_key, (is_array($val) ? wp_ng_json_encode($val, $shortcode) : esc_attr($val)));
      }
    }

  }

  return $attrs;
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

  if (empty($content) || wp_ng_elementor_is_built_with(get_the_ID()) ) {
    return $content;
  }

  //Wrap content paragraph if not contain html and shortcode
  if (!preg_match('/<\s?[^\>]*\/?\s?>/i', $content) && !preg_match('/\[\s?[^\]]*\/?\s?\]/i', $content) ) {
    $content = '<p>' . $content . '</p>';
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



/**
 * Get placeholder image source.
 *
 * @return string
 */
function wp_ng_get_placeholder_image_src() {

  return apply_filters( 'elementor/utils/get_placeholder_image_src', wp_ng_get_asset_path('images/placeholder.png') );
}



/**
 * Simple check for validating a URL, it must start with http:// or https://.
 * and pass FILTER_VALIDATE_URL validation.
 *
 * @param  string $url
 * @return bool
 */
function wp_ng_is_valid_url( $url ) {

  // Must start with http:// or https://
  if ( 0 !== strpos( $url, 'http://' ) && 0 !== strpos( $url, 'https://' ) ) {
    return false;
  }

  // Must pass validation
  if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
    return false;
  }

  return true;
}


/**
 * Remove undesired characters like trim but for all string
 *
 * @param $str
 * @param null $what
 * @param string $with
 * @return string
 */
function wp_ng_trim_all( $str , $what = NULL , $with = ' ' )
{
  if( $what === NULL )
  {
    //  Character      Decimal      Use
    //  "\0"            0           Null Character
    //  "\t"            9           Tab
    //  "\n"           10           New line
    //  "\x0B"         11           Vertical Tab
    //  "\r"           13           New Line in Mac
    //  " "            32           Space

    $what   = "\\x00-\\x20";    //all white-spaces and control chars
  }

  return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
}


/**
 * Convert string to camel case
 *
 * @param $string
 * @param bool $capitalize_first
 * @return mixed|string
 */
function wp_ng_camelize($string, $capitalize_first = false)
{

  $str = str_replace('-', '', ucwords($string, '-'));

  if (!$capitalize_first) {
    $str = lcfirst($str);
  }

  return $str;
}


/**
 * Shuffle array asociative
 *
 * @param $list
 * @return array
 */
function wp_ng_shuffle_assoc( $list ) {

  if ( !is_array($list) ) {
    return $list;
  }

  $keys = array_keys($list);

  shuffle($keys);

  $random = array();

  foreach ($keys as $key) {
    $random[$key] = $list[$key];
  }

  return $random;
}


/**
 * Elementor Plugin
 * Is build with
 *
 * @param $post_id
 * @return bool
 */
function wp_ng_elementor_is_built_with( $post_id ) {

  if (post_type_supports( get_post_type($post_id), 'elementor') &&
    Wp_Ng_Dependencies::Elementor_active_check() && class_exists('Elementor\\Plugin')
  ) {
    return Elementor\Plugin::instance()->db->is_built_with_elementor( $post_id );
  }

  return false;
}


/**
 * Elementor Plugin
 * Is edit mode
 *
 * @param $post_id
 * @return bool
 */
function wp_ng_elementor_is_edit_mode() {

  if (Wp_Ng_Dependencies::Elementor_active_check() && class_exists('Elementor\\Plugin')) {
    if(Wp_Ng_Public_Elementor::$is_edit_mode || Elementor\Plugin::instance()->editor->is_edit_mode()){
      return true;
    }
  }

  return false;
}


/**
 * Elementor Plugin
 * Is preview mode
 *
 * @param $post_id
 * @return bool
 */
function wp_ng_elementor_is_preview_mode() {

  if (Wp_Ng_Dependencies::Elementor_active_check() && class_exists('Elementor\\Plugin')) {
    if(Wp_Ng_Public_Elementor::$is_preview || Elementor\Plugin::instance()->preview->is_preview_mode()) {
      return true;
    }
  }

  return false;
}


/**
 * Get status of wp cache
 * @return bool
 */
function wp_ng_is_advanced_cache() {

  if ( WP_CACHE && apply_filters( 'enable_loading_advanced_cache_dropin', true ) ) {
    return true;
  }

  return false;
}
/**
 * Clean cache
 * For third party plugin
 */
function wp_ng_cache_clean () {

  if (function_exists('wp_cache_clear_cache') ) {
    wp_cache_clear_cache();
  }
}



