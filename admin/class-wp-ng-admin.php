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

    /* Init Gallery */
    add_action( 'admin_init', array( 'Wp_Ng_Admin_Gallery', 'init' ) );
	}


  /**
   * Load Dependencies
   */
  private function load_dependencies() {

    require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng-admin-fields-action.php';
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ng-admin-gallery.php';

    /**
     * Metaboxes
     */
    require_once plugin_dir_path( __FILE__ ) . 'includes/metaboxes/class-metabox-email-options.php';
    require_once plugin_dir_path( __FILE__ ) . 'includes/metaboxes/class-metabox-ng-router.php';

  }


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

    global $pagenow;


    //Register style wp-ng-metabox
    if ( in_array( $pagenow, array( 'post-new.php', 'post.php', 'edit.php' ) ) ) {
      wp_register_style($this->plugin_name . '-metabox', wp_ng_get_admin_asset_path('styles/' . $this->plugin_name . '-metabox.css'), array(), $this->version, 'all');
      wp_enqueue_style($this->plugin_name . '-metabox');
    }

    if ( !in_array( $pagenow, array( 'options-general.php' ) ) || !isset($_GET['page']) || $_GET['page'] !== 'settings_' . $this->plugin_name ) {
      return;
    }

    //Register style wp-ng-admin
    wp_register_style($this->plugin_name . '-admin', wp_ng_get_admin_asset_path('styles/' . $this->plugin_name . '-admin.css'), array(), $this->version, 'all');
    wp_enqueue_style($this->plugin_name . '-admin');

    //Dequeue jquery chosen load by third party plugin on wn ng settings page.
    wp_dequeue_style('jquery-chosen');
	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

    global $pagenow;


    if ( !in_array( $pagenow, array( 'options-general.php' ) ) && isset($_GET['page']) && $_GET['page'] === 'settings_' . $this->plugin_name ) {
      return;
    }

    //Register settings
    Wp_Ng_Settings::admin_enqueue_scripts();

    //Register script wp-ng-admin
    wp_register_script($this->plugin_name . '-admin', wp_ng_get_admin_asset_path('scripts/' . $this->plugin_name . '-admin.js'), array(), $this->version, false);
    wp_enqueue_script($this->plugin_name . '-admin');

    //Dequeue jquery chosen load by third party plugin on wn ng settings page.
    wp_dequeue_script('jquery-chosen');

	}


  /**
   * Admin Init
   */
  public function init() {

    /* Custom Meta Box */
    $routed_post_types = wp_ng_get_module_option( 'routed_post_types', 'wp-ng_ui.router', array() );

    foreach ($routed_post_types as $routed_post_type) {
      wp_ng_add_meta_box_ng_router( $routed_post_type, $routed_post_type);
    }
  }


  /**
   * Settings Admin Init
   *
   */
  public function settings_init() {

    $settings_page = Wp_Ng_Settings::getInstance( $this->plugin_name );

    //Action for fields !only for global.
    foreach ( $settings_page->get_fields() as $tab_key => $sections ) {
      foreach ($sections as $section_key => $field) {
        foreach ($field as $option) {
          if ( (!empty($option['action'] || !empty($option['actions'])) && !empty($option['name']) && $option['global'] === true) ) {
            $_actions = !empty($option['actions'] ) ? $option['actions'] : array();

            if ( !empty($option['action'] ) ) {
              $_actions[] = array(
                'function_to_add' => $option['action'],
                'priority' => 10
              );
			      }

            $option_name = $settings_page->get_option_prefix( $option['name'] );

            foreach ( $_actions as $_action) {
              add_filter( 'pre_update_option_' . $option_name, $_action['function_to_add'], (!empty($_action['priority']) ? $_action['priority'] : 10), 3 );
            }
          }
        }
      }
    }

    //Action for section
    foreach ( $settings_page->get_sections() as $tab_key => $sections ) {
      foreach ($sections as $section) {
        if ( !empty($section['action']) || !empty($section['actions']) ) {

          $_actions = !empty($section['actions'] ) ? $section['actions'] : array();

          if ( !empty($section['action'] ) ) {
            $_actions[] = array(
              "function_to_add" => $section['action'],
              "priority" => 10
            );
          }

          $option_name = $settings_page->get_option_prefix( $section['id'] );

          foreach ( $_actions as $_action) {
            add_filter( 'pre_update_option_' . $option_name, $_action['function_to_add'], (!empty($_action['priority']) ? $_action['priority'] : 10), 2 );
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
      $init['verify_html'] = FALSE;
    }

    return $init;
  }



}
