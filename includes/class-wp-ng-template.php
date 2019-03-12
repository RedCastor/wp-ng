<?php

/**
 *  Wp NG Template
 *  Class that will manage template
 *
 * @link       http://www.redcastor.io
 * @since      1.4.2
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public
 */

/**
 * Define the template manager.
 *
 * @since      1.4.2
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Template
{

  /** @var Wp_Ng_Template The single instance of the class */
  protected static $_instance = null;


  private $template_path;   // <theme>/<plugin>/
  private $template_default_path;  // <plugin>/templates/

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.4.2
   */
  public function __construct( ) {

    $this->template_path =  WP_NG_PLUGIN_NAME . '/';
    $this->template_default_path = 'public/templates/';
  }

  /**
   * Cloning is forbidden.
   * @since 1.4.2
   */
  public function __clone() {
    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wp-ng' ), '1.4.2' );
  }

  /**
   * Unserializing instances of this class is forbidden.
   * @since 1.4.2
   */
  public function __wakeup() {
    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wp-ng' ), '1.4.2' );
  }

  /**
   * Template Instance.
   *
   * Ensures only one instance of template is loaded or can be loaded.
   *
   * @since 1.4.2
   * @static
   * @see ()
   * @return Wp_Ng_Template - Main instance.
   */
  public static function getInstance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }


  /**
   * Locate the templates and return the path of the file found
   *
   * @since    1.4.2
   *
   * @param $template_name
   * @param null $plugin_name
   *
   * @return mixed|void
   */
  public function locate_template( $template_name, $plugin_name = null ){

    if ( $plugin_name ) {
      $default_path = trailingslashit( trailingslashit(WP_PLUGIN_DIR)  . $plugin_name ) . $this->template_default_path . $template_name;  // Search in <plugin>/templates/
      $template_path = trailingslashit( $plugin_name ) . $template_name; // Search in <theme>/<plugin>/
    }
    else {
      $template_path = $this->template_path . $template_name; // Search in <theme>/<plugin>/
      $default_path = trailingslashit( WP_PLUGIN_DIR ) . $this->template_path  . $this->template_default_path . $template_name;  // Search in <plugin>/templates/
    }


    $located = locate_template( array(
      $template_path,
      $default_path
    ) );

    if( ! $located && file_exists( $default_path ) ) {
      return apply_filters( 'wp_ng_locate-template', $default_path, $template_name );
    }

    return apply_filters( 'wp_ng_locate-template', $located, $template_name );
  }


  /**
   * Get template part.
   *
   * @since    1.7.7
   *
   * @access public
   * @param mixed  $slug Template slug.
   * @param string $name Template name (default: '').
   */
  public function get_template_part( $slug, $name = '', $plugin_name = null ) {

    $template = '';

    if ( $name ) {
      $template = $this->locate_template("{$slug}-{$name}.php", $plugin_name);
    }

    if ( ! $template ) {
      $template = $this->locate_template( "{$slug}.php", $plugin_name);
    }


    // Allow 3rd party plugins to filter template file from their plugin.
    $template = apply_filters( 'wp_ng_get_template_part', $template, $slug, $name );

    if ( $template ) {
      load_template( $template, false );
    }
  }


  /**
   * Retrieve a template file.
   *
   * @since    1.4.2
   *
   * @param string $path
   * @param string $plugin_path
   * @param array $args
   * @param bool $return
   * @return output template
   */
  public function get_template( $template_name, $plugin_name = null, $args = null, $return = true ) {

    $located = $this->locate_template( $template_name, $plugin_name );

    if ( ! file_exists( $located ) ) {

      _doing_it_wrong( __FUNCTION__, sprintf( __( '%s does not exist.', 'woocommerce-ng' ), '<code>' . $located . '</code>' ), '1.7.7' );

      return $return ? '' : false;
    }

    if (empty($located)) {
      return false;
    }

    if ( ! empty( $args ) && is_array( $args ) ) {
      extract( $args );
    }

    if( $return ) {
      ob_start();
    }

    do_action( 'wp_ng_before_template_part', $template_name, $located, $args );

    // include file located
    include($located);

    do_action( 'wp_ng_after_template_part', $template_name, $located, $args );

    if( $return ) {
      return wp_ng_trim_all(ob_get_clean());
    }

    return true;
  }


  /**
   * Get a list of template.
   *
   * @since    1.4.2
   *
   * @param string $path
   * @param bool   $only_dir
   *
   * @return mixed|void
   */
  public function get_template_list( $path = '', $plugin_name = null, $only_dir = false ) {

    if ( $plugin_name ) {
      $template_path = trailingslashit( trailingslashit(WP_PLUGIN_DIR)  . $plugin_name );  // Search in <plugin>/templates/
    }
    else {
      $template_path = trailingslashit( WP_PLUGIN_DIR ) . $this->template_path; // Search in <theme>/<plugin>/
    }

    $list_theme = glob( trailingslashit( get_stylesheet_directory() ) . ($plugin_name ? trailingslashit($plugin_name) : trailingslashit($this->template_path)) . $path );
    $list_plugin = glob( $template_path . $this->template_default_path . $path );

    if (is_array($list_theme) && is_array($list_plugin)) {
      $list_files = array_merge($list_plugin, $list_theme);
    }
    else if (is_array($list_theme)) {
      $list_files = $list_theme;
    }
    else {
      $list_files = $list_plugin;
    }

    if ($only_dir) {
      $list_files = array_filter($list_files, function($dir) {
        return is_dir($dir);
      });
    }

    $list_names = array();

    foreach ($list_files as $file) {
      $name = pathinfo($file, PATHINFO_FILENAME);
      $list_names[] = $name;
    }

    return apply_filters( 'wp_ng_template-list', $list_names);
  }



}
