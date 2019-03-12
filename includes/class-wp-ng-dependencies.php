<?php

/**
 * The file that defines the dependency Checker
 *
 *
 * @link       http://redcastor.io
 * @since      1.5.1
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */

/**
 * The core plugin class.
 *
 * @since      1.5.1
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Dependencies {

	private static $active_plugins;

	public static function init() {

		self::$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
	    self::$active_plugins = array_merge( self::$active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
	  }
	}


  //Check plugin Elementor active
  public static function Elementor_active_check() {

    if ( ! self::$active_plugins ) {
      self::init();
    }

    return in_array( 'elementor/elementor.php', self::$active_plugins ) || array_key_exists( 'elementor/elementor.php', self::$active_plugins );
  }


  //Check plugin Elementor active
  public static function Wpml_active_check() {

    if ( ! self::$active_plugins ) {
      self::init();
    }

    return in_array( 'sitepress-multilingual-cms/sitepress.php', self::$active_plugins ) || array_key_exists( 'sitepress-multilingual-cms/sitepress.php', self::$active_plugins );
  }


  //Check plugin Woocommerce active
  public static function Woocommerce_active_check() {

    if ( ! self::$active_plugins ) {
      self::init();
    }

    return in_array( 'woocommerce/woocommerce.php', self::$active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', self::$active_plugins );
  }


  //Check plugin Stag Catalog active
  public static function StagCatalog_active_check() {

    if ( ! self::$active_plugins ) {
      self::init();
    }

    return in_array( 'stag-catalog/stag-catalog.php', self::$active_plugins ) || array_key_exists( 'stag-catalog/stag-catalog.php', self::$active_plugins );
  }

}


