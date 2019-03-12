<?php

/**
 * The public-facing includes functionality Compatibility For Elementor Plugin.
 *
 * @link       http://redcastor.io
 * @since      1.5.0
 *
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes
 */







/**
 *
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Public_Elementor {

  public static $post_id;
  public static $is_preview = false;
  public static $is_edit_mode = false;
  public static $is_query_page = false;


  /**
   * Init Elementor.
   */
  public static function init() {


    add_action( 'template_redirect',                        array(__CLASS__, 'template_redirect'), -1 );
    add_action( 'elementor/editor/before_enqueue_scripts',  array(__CLASS__, 'elementor_editor_enqueue_scripts') );
    add_action( 'elementor/frontend/after_enqueue_scripts', array(__CLASS__, 'elementor_frontend_enqueue_scripts'), 890 );

    if ( ! version_compare( ELEMENTOR_VERSION, '2.0', '>=' ) ) {
      add_action( 'wp_ajax_elementor_render_widget',          array(__CLASS__, 'elementor_ajax_render_widget'), 5 );
    }
    else {
      add_action( 'elementor/ajax/register_actions',          array(__CLASS__, 'elementor_ajax_render_widget'), 5 );
    }

    add_action( 'wp_enqueue_scripts',                       array(__CLASS__, 'elementor_enqueue_scripts'), 900 );

    add_filter( 'wp_ng_add_handles_process_scripts',        array(__CLASS__, 'add_handles_process_scripts') );
    add_filter( 'wp_ng_add_handles_process_styles',         array(__CLASS__, 'add_handles_process_styles') );
  }

  /**
   * Template redirect
   */
  public static function template_redirect () {
    global $post;

    self::$post_id = get_the_ID();
    $query_obj = get_queried_object();

    if ( !empty($query_obj->ID) && $query_obj->ID !== get_the_ID() && wp_ng_elementor_is_built_with( $query_obj->ID ) ) {

      self::$post_id = $query_obj->ID;
      self::$is_preview = Elementor\Plugin::instance()->preview->is_preview_mode(self::$post_id);
      self::$is_edit_mode = Elementor\Plugin::instance()->editor->is_edit_mode(self::$post_id);

      //Fix Woocommerce shop page and stag-catalog catalog page.
      if ( is_page() ) {
        self::$is_query_page = true;

        //set global post
        $post = get_post(self::$post_id);

        add_action( 'wp_enqueue_scripts', [ Elementor\Plugin::instance()->frontend, 'enqueue_styles' ] );
      }
    }
  }


  /**
   * Elementor Editor Enqueue Scripts.
   */
  public static function elementor_editor_enqueue_scripts () {

    do_action( 'wp_ng_enqueue_scripts' );
  }


  /**
   * Elementor Frontend enqueue script.
   *
   * @since 1.5.1
   */
  public static function elementor_frontend_enqueue_scripts () {

    if ( wp_ng_elementor_is_preview_mode() ) {

      wp_register_script('wp-ng_elementor', wp_ng_get_asset_path('scripts/wp-ng-elementor.js'), array('angular'), WP_NG_PLUGIN_VERSION, true );
      wp_enqueue_script('wp-ng_elementor');

      wp_dequeue_script('wp-ng_animsition');
      wp_dequeue_style('wp-ng_animsition');

      //Save transient active modules for later ajax render widget to resolve lazyload modules.
      $post_id = self::$post_id;
      set_transient("wp_ng_post_{$post_id}_modules_loaded", wp_ng_get_active_modules());
    }

  }

  /**
   *
   */
  public static function elementor_enqueue_scripts () {

    //Add wp-ng elementor frontend
    wp_register_style('wp-ng_elementor-frontend-fix', wp_ng_get_asset_path('styles/elementor-frontend.css'), array(), WP_NG_PLUGIN_VERSION, 'all' );
    wp_enqueue_style('wp-ng_elementor-frontend-fix');

    if ( !wp_ng_elementor_is_preview_mode() &&  self::$is_query_page == true ) {

      $scheme_css_file = new Elementor\Global_CSS_File('global.css');
      $scheme_css_file->enqueue();

      $css_file = new Elementor\Post_CSS_File( self::$post_id );
      $css_file->enqueue();

      wp_dequeue_style('elementor-post-' . get_the_ID());
    }
  }


  /**
   * Before Process wp-ng scripts
   *
   * @since 1.5.1
   */
  public static function add_handles_process_scripts ( $handles ) {

    if ( !wp_ng_elementor_is_edit_mode() && wp_ng_is_combine_modules() && wp_ng_get_option( 'combine_elementor', 'advanced' ) === 'on' ) {

      $handles['elementor'] = true;
    }

    return $handles;
  }


  /**
   * Before Process wp-ng styles
   *
   * @since 1.5.1
   */
  public static function add_handles_process_styles ( $handles ) {

    if ( !wp_ng_elementor_is_edit_mode() && wp_ng_is_combine_modules() && wp_ng_get_option( 'combine_elementor', 'advanced' ) === 'on' ) {

      $handles['font-awesome'] = false;
      $handles['elementor'] = true;
    }

    return $handles;
  }


  /**
   * Elementor Ajax render widget.
   *
   * @since 1.5.1
   */
  public static function elementor_ajax_render_widget () {

    $post_id = absint(!empty( $_POST['editor_post_id'] ) ? $_POST['editor_post_id'] : $_POST['post_id']);

    if ( empty( $post_id ) ) {
      return;
    }

    //Get module handles from transient for the current post in edit mode to resolve lazyload modules.
    $module_handles = get_transient("wp_ng_post_{$post_id}_modules_loaded");

    do_action( 'wp_ng_enqueue_scripts', $module_handles );
  }


}
