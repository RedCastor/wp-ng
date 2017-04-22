<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/admin
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Admin {


  /**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

    $this->load_dependencies();

    add_action( 'admin_menu', array( $this, 'settings'), 100 );
    add_action( 'admin_init', array( $this, 'settings_init') );

    add_filter( 'tiny_mce_before_init', array($this, 'tiny_mce_before_init'), 100 );

	}


  private function load_dependencies() {

    require_once plugin_dir_path( __FILE__ ) . '/includes/class-wp-ng-admin-fields-action.php';
  }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

    //Register style wp-ng-admin
    wp_register_style($this->plugin_name . '-admin', wp_ng_get_admin_asset_path('styles/' . $this->plugin_name . '-admin.css'), array(), $this->version, 'all');
    wp_enqueue_style($this->plugin_name . '-admin');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

    //Register script wp-ng-admin
    wp_register_script($this->plugin_name . '-admin', wp_ng_get_admin_asset_path('scripts/' . $this->plugin_name . '-admin.js'), array(), $this->version, false);
    wp_enqueue_script($this->plugin_name . '-admin');

	}

  /**
   * Settings Admin Init
   *
   */
  public function settings_init() {

    $settings_page = Wp_Ng_Settings::getInstance( $this->plugin_name );

    foreach ( $settings_page->get_fields() as $tab_key => $sections ) {
      foreach ($sections as $section_key => $field) {
        foreach ($field as $option) {
          if ( isset($option['action']) && isset($option['name']) && !empty($option['action']) ) {
            add_filter( 'pre_update_option_' . $settings_page->get_option_prefix( $option['name'] ), $option['action'], 10, 2 );
          }
        }
      }
    }

    $settings_page->admin_init();
  }


  /**
   * Add Options Page Plugin settings
   */
  public function settings() {
    $page_title = 'WP NG Angular';
    $menu_title = $page_title;
    $menu_slug  = 'settings_' . $this->plugin_name;

    add_options_page( $page_title, $menu_title, 'manage_options', $menu_slug, array( Wp_Ng_Settings::getInstance( $this->plugin_name ), 'render_settings_page') );
  }


  /**
   * Tiny MCE Init
   * @param $init
   *
   * @return mixed
   */
  public function tiny_mce_before_init( $init ) {

    if( wp_ng_disable_tinymce_verify_html() === true) {
      $init['verify_html  '] = FALSE;
    }

    if( wp_ng_disable_wpautop() === true) {
      //$init['wpautop'] = FALSE;
    }

    return $init;
  }

}
