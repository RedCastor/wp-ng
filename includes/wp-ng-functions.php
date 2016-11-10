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
 * Get Plugin Option value
 */
function wp_ng_get_option( $option, $section , $default = '' ) {

  $settings_page = Wp_Ng_Settings::getInstance( WP_NG_PLUGIN_NAME );

  //Search Field for section option
  foreach ($settings_page->get_fields() as $key => $tab ){
    if ( isset($tab[$section]) ) {
      $section_fields = $tab[$section];
      $field_key = array_search($option, array_column($section_fields, 'name'));
      break;
    }
  }

  //Set the default value if exist
  $default = ( empty($default) && isset($section_fields[$field_key]['default']) ) ? $section_fields[$field_key]['default'] : $default;

  //Is option global
  $global = boolval( isset($section_fields[$field_key]['global']) && $section_fields[$field_key]['global'] === true );

  return $settings_page->get_option( $option, $section, $default, $global );
}
add_filter('wp_ng_get_option', 'wp_ng_get_option',10, 3);


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
add_filter('wp_ng_get_langguage', 'wp_ng_get_language',10, 3);


/**
 * Get Angular App Name
 */
function wp_ng_get_app_name() {

  return apply_filters( 'wp_ng_get_option', 'app_name', 'general' );
}

/**
 * Get Angular App Name
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
 * Get bower instance
 */
function wp_ng_bower( $filename, $path ) {

  return new Wp_Ng_Bower( $filename, $path );
}

