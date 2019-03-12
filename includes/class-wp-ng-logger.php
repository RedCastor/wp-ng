<?php

/**
 * Logger class
 *
 * Logging rollbar load library rollbar-php provide by Rollbar (dependency PSR for error php standard).
 *
 *
 * rollbar-php: https://github.com/rollbar/rollbar-php
 *
 * @link       http://redcastor.io
 * @since      1.4.1
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */

use \Rollbar\Rollbar;
use \Rollbar\Payload\Level;


defined('WP_NG_LOG_EMERGENCY')  or define('WP_NG_LOG_EMERGENCY',  0b00000001);
defined('WP_NG_LOG_CRITICAL')   or define('WP_NG_LOG_CRITICAL',   0b00000010);
defined('WP_NG_LOG_ERROR')      or define('WP_NG_LOG_ERROR',      0b00000100);
defined('WP_NG_LOG_WARNING')    or define('WP_NG_LOG_WARNING',    0b00001000);
defined('WP_NG_LOG_DEBUG')      or define('WP_NG_LOG_DEBUG',      0b00010000);
defined('WP_NG_LOG_INFO')       or define('WP_NG_LOG_INFO',       0b00100000);
defined('WP_NG_LOG_NOTICE')     or define('WP_NG_LOG_NOTICE',     0b01000000);
defined('WP_NG_LOG_ALERT')      or define('WP_NG_LOG_ALERT',      0b10000000);

/**
 * Logger for the plugin.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Logger {

  /**
   * Stores open file _handles.
   *
   * @var array
   * @access private
   */
  private $_handles;

  public $file_path;

  public $level;
  public $level_type_file;
  public $level_type_rollbar;

  const LOG_FILE    = 0b001;
  const LOG_ROLLBAR = 0b010;


  /** @var Wp_Ng_Logger The single instance of the class */
  protected static $_instance = null;


  /**
   * Main Wp_Ng_Emails Instance.
   *
   * Ensures only one instance of Wp_Ng_Logger is loaded or can be loaded.
   *
   * @since 1.4.2
   * @static
   * @return Wp_Ng_Logger Main instance
   */
  public static function getInstance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  /**
   * Cloning is forbidden.
   *
   * @since 1.4.2
   */
  public function __clone() {
    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wp-ng' ), '1.4.2' );
  }

  /**
   * Unserializing instances of this class is forbidden.
   *
   * @since 1.4.2
   */
  public function __wakeup() {
    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wp-ng' ), '1.4.2' );
  }



  /**
   * Constructor for the logger.
   */
  public function __construct() {
    $this->_handles = array();
    $this->file_path = null;

    add_action('wp_ng_log_clear',     array($this, 'clear') );
    add_action('wp_ng_log',           array($this, 'log'), 10, 3);
    add_action('wp_ng_log_emergency', array($this, 'log_emergency'), 10, 2);
    add_action('wp_ng_log_critical',  array($this, 'log_critical'), 10, 2);
    add_action('wp_ng_log_error',     array($this, 'log_error'), 10, 2);
    add_action('wp_ng_log_warning',   array($this, 'log_warning'), 10, 2);
    add_action('wp_ng_log_debug',     array($this, 'log_debug'), 10, 2);
    add_action('wp_ng_log_info',      array($this, 'log_info'), 10, 2);
    add_action('wp_ng_log_notice',    array($this, 'log_notice'), 10, 2);
    add_action('wp_ng_log_alert',     array($this, 'log_alert'), 10, 2);
  }


  /**
   * Destructor.
   */
  public function __destruct() {
    if ( $this->level & self::LOG_FILE ) {
      $this->close_log_file();
    }
  }

  /**
   * Get code version
   */
  public function get_code_version( $code_version = null ) {

    if ( empty($code_version) ) {
      $code_version = get_bloginfo('version');
      $_theme = wp_get_theme();
      $code_version = sprintf('WP-v%s | %s-v%s', $code_version, $_theme->get('Name'), $_theme->get('Version'));
    }

    return apply_filters( 'wp_ng_log_rollbar_code_version', $code_version);
  }

  public function get_log_level_int( $levels ) {

    if (!is_array($levels)) {
      $levels = array($levels);
    }

    //Get Bit mask level from array
    return (int)array_reduce($levels, function ($reduced, $current) {
      $reduced = (int)$reduced;
      $current = (int)$current;
      $reduced |= $current;
      return $reduced;
    });
  }

  /**
   * Get level name by level integer
   * @param $level
   *
   * @return string
   */
  public function get_log_type_name ( $log_type ) {

    switch ((int)$log_type) {
      case WP_NG_LOG_EMERGENCY:
        return 'EMERGENCY';
      case WP_NG_LOG_CRITICAL:
        return 'CRITICAL';
      case WP_NG_LOG_ERROR:
        return 'ERROR';
      case WP_NG_LOG_WARNING:
        return 'WARNING';
      case WP_NG_LOG_DEBUG:
        return 'DEBUG';
      case WP_NG_LOG_INFO:
        return 'INFO';
      case WP_NG_LOG_NOTICE:
        return 'NOTICE';
      case WP_NG_LOG_ALERT:
        return 'ALERT';
      default:
        return '';
    }
  }


  /**
   * Return the log file path
   *
   * @param $handle
   *
   * @return string
   */
  public function get_log_file_path( $handle ) {

    return trailingslashit( $this->file_path ) . sanitize_file_name( $handle . '-' . wp_hash( $handle ) ) . '.log';
  }

  /**
   * Add a log entry to chosen file.
   *
   * @param string $handle
   * @param string $message
   */
  public function log( $log_handle, $log_msg, $log_type ) {

    $this->log_file($log_handle, (string)$log_msg, $log_type);
    $this->log_rollbar($log_handle, (string)$log_msg, $log_type);
  }


  /**
   * Clear entries from chosen file.
   *
   * @param mixed $handle
   */
  public function clear( $handle ) {
    $this->clear_file($handle);
  }

  public function log_emergency ( $log_handle, $log_msg ) {
    $this->log( $log_handle, $log_msg, WP_NG_LOG_EMERGENCY);
  }

  public function log_critical ( $log_handle, $log_msg ) {
    $this->log( $log_handle, $log_msg, WP_NG_LOG_CRITICAL);
  }

  public function log_error ( $log_handle, $log_msg ) {
    $this->log( $log_handle, $log_msg, WP_NG_LOG_ERROR);
  }

  public function log_warning ( $log_handle, $log_msg ) {
    $this->log( $log_handle, $log_msg, WP_NG_LOG_WARNING);
  }

  public function log_debug ( $log_handle, $log_msg ) {
    $this->log( $log_handle, $log_msg, WP_NG_LOG_DEBUG);
  }

  public function log_info ( $log_handle, $log_msg ) {
    $this->log( $log_handle, $log_msg, WP_NG_LOG_INFO);
  }

  public function log_notice ( $log_handle, $log_msg ) {
    $this->log( $log_handle, $log_msg, WP_NG_LOG_NOTICE);
  }

  public function log_alert ( $log_handle, $log_msg ) {
    $this->log( $log_handle, $log_msg, WP_NG_LOG_ALERT);
  }


  /**
   * Initialize file logging
   *
   * @param null $path
   * @param string $dir_name
   */
  public function init_log_file ( $log_level = 0, $log_path = null ) {
    $this->file_path = $log_path;


    //If file path empty create default log file path
    if( empty($this->file_path) ) {
      if ( ! defined( 'WP_NG_LOG_DIR' ) ) {
        $upload_dir = wp_upload_dir();
        define('WP_NG_LOG_DIR', $upload_dir['basedir'] . '/' . WP_NG_PLUGIN_NAME . '/logs/');
      }

      wp_mkdir_p( WP_NG_LOG_DIR );
      $this->file_path = WP_NG_LOG_DIR;
    }

    $this->file_path = apply_filters('wp_ng_log_file_path', $this->file_path);

    $this->level |= self::LOG_FILE;
    $this->level_type_file = (int)$log_level;
  }


  /**
   * Initialize rollbar logging
   *
   * @param string $access_token
   * @param string $env
   * @param null $track_level
   * @param null $root
   * @param null $code_version
   * @param array $extra_config
   *
   * @return bool|WP_Error
   */
  public function init_log_rollbar( $log_level = 0, $access_token = '', $env = '', $enable_php_error = false, $enable_track_php = false, $track_level = 0, $root = null, $code_version = null, $extra_config = array() ) {

    if ($root === null) {
      $root = ABSPATH;
    }


    $code_version = $this->get_code_version($code_version);
    $framework = apply_filters('wp_ng_log_rollbar_framework', 'WordPress');

    //Get Bit mask level from array
    $included_errno = $this->get_log_level_int($track_level);

    //Configuration
    $config = array(
      'access_token' => (string) $access_token,
      'environment' => (string) $env,
      'framework' => (string) $framework,
      'code_version' => (string) $code_version,
      'root' => $root,
      'included_errno' => (int)$included_errno,
      'use_error_reporting' => (bool)$enable_track_php,
    );

    //Set log to logged user
    if ( is_user_logged_in() ) {
      $user = wp_get_current_user();

      $config['person'] = array(
        'id' => (string) $user->ID,
        'username' => $user->user_login,
        'email' => $user->user_email,
      );
    }

    $this->level_type_rollbar = (int)$log_level;

    try {

      $config = array_merge($config, $extra_config);

      if ( $enable_php_error === true ) {
        error_reporting( (int)$included_errno );

        if ( WP_DEBUG_DISPLAY ) {
          ini_set( 'display_errors', 1 );
        }
        elseif ( null !== WP_DEBUG_DISPLAY ) {
          ini_set( 'display_errors', 0 );
        }

        $test = ini_get('display_errors');
      }

      Rollbar::init($config);

      $this->level |= self::LOG_ROLLBAR;
    } catch (Exception $e) {
      return new WP_Error( 'wp_ng_log_rollbar_init', $e->getMessage() );
    }

    return true;
  }





  /**
   * Open log file for writing.
   *
   * @access private
   * @param mixed $handle
   * @return bool success
   */
  private function open_log_file( $handle ) {
    if ( isset( $this->_handles[ $handle ] ) ) {
      return true;
    }

    if ( $this->_handles[ $handle ] = @fopen( $this->get_log_file_path( $handle ), 'a' ) ) {
      return true;
    }

    return false;
  }


  /**
   * Close log file handle
   */
  private function close_log_file () {
    foreach ( $this->_handles as $handle ) {
      @fclose( $handle );
    }
  }

  /**
   * Add log to file
   *
   * @param $handle
   * @param $message
   */
  public function log_file ( $log_handle, $log_msg, $log_type ) {

    if ( $this->level & self::LOG_FILE && $this->level_type_file & $log_type ) {

      if ( $this->open_log_file( $log_handle ) && is_resource( $this->_handles[ $log_handle ] ) ) {
        $time = date_i18n( 'm-d-Y @ H:i:s' ); // Grab Time
        @fwrite( $this->_handles[ $log_handle ], sprintf("%s --%s-- %s\n", $time, $this->get_log_type_name($log_type), $log_msg ) );
      }
    }
  }

  /**
   * Clear log handle file
   *
   * @param $handle
   */
  public function clear_file ( $handle ) {

    if ( $this->level & self::LOG_FILE ) {

      if ( $this->open_log_file( $handle ) && is_resource( $this->_handles[ $handle ] ) ) {
        @ftruncate( $this->_handles[ $handle ], 0 );
      }
    }
  }


  /**
   * Logging Add
   * if handle is same as level name, it call the level method.
   * example handle is error, log is made on level error.
   *
   * @param $handle
   * @param $message
   */
  public function log_rollbar ( $log_handle, $log_msg, $log_type ) {

    if ( $this->level & self::LOG_ROLLBAR && $this->level_type_rollbar & $log_type ) {

      $method = 'log_rollbar_' . strtolower($this->get_log_type_name($log_type));
      $log_msg = sprintf('--%s-- %s', $log_handle, $log_msg);

      if (method_exists($this, $method)) {
        call_user_func( array($this, $method), $log_msg );
      }
      else {
        $this->log_rollbar_notice($log_msg);
      }
    }
  }

  /**
   * Critical log
   *
   * @param $message
   */
  private function log_rollbar_critical ( $message ) {

    Rollbar::log(Level::CRITICAL, $message);
  }

  /**
   * Emergency log
   *
   * @param $message
   */
  private function log_rollbar_emergency ( $message ) {

    Rollbar::log(Level::EMERGENCY, $message);
  }

  /**
   * Error log
   *
   * @param $message
   */
  private function log_rollbar_error ( $message ) {

    Rollbar::log(Level::ERROR, $message);
  }

  /**
   * Warning log
   *
   * @param $message
   */
  private function log_rollbar_warning ( $message ) {

    Rollbar::log(Level::WARNING, $message);
  }

  /**
   * Debug log
   *
   * @param $message
   */
  private function log_rollbar_debug ( $message ) {

    Rollbar::log(Level::DEBUG, $message);
  }

  /**
   * Notice log
   *
   * @param $message
   */
  private function log_rollbar_notice ( $message ) {

    Rollbar::log(Level::NOTICE, $message);
  }

  /**
   * Alert log
   *
   * @param $message
   */
  private function log_rollbar_alert ( $message ) {

    Rollbar::log(Level::ALERT, $message);
  }
}
