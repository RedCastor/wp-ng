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
  $dist_path = plugins_url( 'public/dist/', dirname( __FILE__ ) );
  $directory = dirname($filename) . '/';
  $file = basename($filename);
  static $manifest;

  if (empty($manifest)) {
    $manifest_path = plugin_dir_path( dirname( __FILE__ ) ) . 'public/dist/assets.json';
    $manifest = new Wp_Ng_JsonManifest($manifest_path);
  }

  if (array_key_exists($file, $manifest->get())) {
    return $dist_path . $directory . $manifest->get()[$file];
  } else {
    return $dist_path . $directory . $file;
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
add_filter('wp_ng_get_option', 'wp_ng_get_option',10, 3);


/**
 * Get Plugin Options section values
 */
function wp_ng_get_options( $section ) {

  $settings_page = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );
  $options = array();

  //Search Field for section option
  foreach ($settings_page->get_fields() as $key => $tab ){
    if ( isset($tab[$section]) ) {
      foreach ($tab[$section] as $field_key => $field) {
        $options[$field['name']] = $settings_page->get_option( $field['name'], $section, '', false );
      }
      break;
    }
  }

  return $options;
}
add_filter('wp_ng_get_options', 'wp_ng_get_options',10, 3);


/**
 * Get Default and current Language. Compatibility with WPML
 * @param $lang
 *
 * @return array
 */
function wp_ng_get_language ( $lang ) {

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

  if ( is_array($lang) ) {
    return array_merge( $lang, $_lang );
  }

  return $_lang;
}
add_filter('wp_ng_get_language', 'wp_ng_get_language',10, 3);


/**
 * Get Angular App Name
 */
function wp_ng_get_app_name() {

  return apply_filters( 'wp_ng_get_option', 'app_name', 'general' );
}

/**
 * Get Angular App Element
 */
function wp_ng_get_app_element() {

  return apply_filters( 'wp_ng_get_option', 'app_element', 'general' );
}

/**
 * Get Cache hours
 */
function wp_ng_get_cache_hours() {

  return intval( apply_filters( 'wp_ng_get_option', 'cache_hours', 'general' ) );

}


/**
 * Get is combine modules
 */
function wp_ng_is_combine_modules() {

  return (apply_filters( 'wp_ng_get_option', 'combine_ng_modules', 'general' ) === 'on') ? true : false;
}

/**
 * Get is ng-cloak
 */
function wp_ng_is_ng_cloak() {

  return (apply_filters( 'wp_ng_get_option', 'ng-cloak', 'general' ) === 'on') ? true : false;
}

/**
 * Get is ng-preload
 */
function wp_ng_is_ng_preload() {

  return (apply_filters( 'wp_ng_get_option', 'ng-preload', 'general' ) === 'on') ? true : false;
}

/**
 * Disbale WPAUTOP
 */
function wp_ng_disable_wpautop() {

  return (apply_filters( 'wp_ng_get_option', 'disable_wpautop', 'advanced' ) === 'on') ? true : false;
}


/**
 * Disbale Verify html tinymce
 */
function wp_ng_disable_tinymce_verify_html() {

  return (apply_filters( 'wp_ng_get_option', 'disable_tinymce_verify_html', 'advanced' ) === 'on') ? true : false;
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
  else {
    foreach ( $args as $arg_key => $arg_args) {

      if ( is_array($arg_key) && array_key_exists( $_wp_ng_plugin_features[$feature][$arg_key] ) ) {
        foreach ( $arg_key as $key => $value ) {
          if ( $value === 'on' ) {
            $_wp_ng_plugin_features[$feature][$arg_key][$key] = $value;
          }
        }
      }

      $_plugin_features = array_merge_recursive($_wp_ng_plugin_features[$feature][$arg_key], $arg_args);

      foreach ( $_plugin_features as $feature_key => $feature_value) {
        if ( is_string($feature_value) && !in_array($feature_value, $_wp_ng_plugin_features[$feature][$arg_key]) ) {
          $_wp_ng_plugin_features[$feature][$arg_key][] = $feature_value;
        }
      }
    }
  }



}


/**
 * Get active modules
 *
 * @return array
 */
function wp_ng_get_active_modules() {

  $modules = wp_ng_get_options( 'modules' );
  $modules_handles = array();

  if (is_array($modules)) {
    $settings = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );

    foreach ( $modules as $module => $module_settings ) {

      $module = str_replace('__dot__', '.', $module);
      $module_handle = $settings->get_option_prefix( $module );

      if ( isset($module_settings['active']) && $module_settings['active'] === 'on' ) {

        $module_settings['conditions']['options'] = isset($module_settings['conditions']['options']) ? $module_settings['conditions']['options'] : array();
        $module_settings['conditions']['value'] = isset($module_settings['conditions']['value']) ? $module_settings['conditions']['value'] : 'off';

        $condition_result = true;

        if ( $module_settings['conditions']['value'] === 'on' ) {
          $condition_check = new Wp_Ng_Conditional( $module_settings['conditions']['options'] );
          $condition_result = $condition_check->result;
        }

        if ( $condition_result === true ) {
          $modules_handles[$module_handle] = $module_settings;

          //Scripts module
          $module_scripts = array_filter($module_settings, function($value, $key) {
            return strpos($key, 'script') === 0;
          }, ARRAY_FILTER_USE_BOTH);


          foreach ( $module_scripts as $module_script_name => $module_script ) {

            $modules_handles[$module_handle][$module_script_name] = null;
            $handle_suffix = str_replace('script', '', $module_script_name);
            $handle_suffix = str_replace('_', '-', $handle_suffix);

            if ( $module_script === 'on' ) {
              $modules_handles[$module_handle][$module_script_name] = $module_handle . $handle_suffix;
            }
            else if ( $module_script !== 'off' && !empty( $module_script ) ) {
              $modules_handles[$module_handle][$module_script_name] = $settings->get_option_prefix( $module_script ) . $handle_suffix;;
            }

          }

          //Styles module
          $module_styles = array_filter($module_settings, function($value, $key) {
            return strpos($key, 'style') === 0;
          }, ARRAY_FILTER_USE_BOTH);


          foreach ( $module_styles as $module_style_name => $module_style ) {

            $modules_handles[$module_handle][$module_style_name] = null;
            $handle_suffix = str_replace('style', '', $module_style_name);
            $handle_suffix = str_replace('_', '-', $handle_suffix);

            if ( $module_style === 'on' ) {
              $modules_handles[$module_handle][$module_style_name] = $module_handle . $handle_suffix;
            }
            else if ( $module_style !== 'off' && !empty( $module_style ) ) {
              $modules_handles[$module_handle][$module_style_name] = $settings->get_option_prefix( $module_style ) . $handle_suffix;
            }

          }
        }
      }
    }
  }

  return $modules_handles;
}

