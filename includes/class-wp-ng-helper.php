<?php

/**
 * The helper functionality of the plugin.
 *
 * @link       http://www.redcastor.io
 * @since      1.4.2
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */




/**
 * The helper plugin class.
 *
 * @since      1.4.2
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Helper {


  //** @var Wp_Ng_Helper The single instance of the class */
  protected static $_instance = null;


  /**
   * Initialize the class and set its properties.
   *
   * @since    1.4.2
   */
  public function __construct( ) {

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
   * Helper Instance.
   *
   * Ensures only one instance of helper is loaded or can be loaded.
   * @since 1.4.2
   *
   * @return null|Wp_Ng_Helper
   */
  public static function getInstance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }


  /**
   * Return the email options by id or default
   *
   * @since  1.4.2
   * @param  int $id object id
   * @return array metadata values
   */
  public function get_email_options( $object_id )
  {

    $email_options = get_post_meta( $object_id, 'email_options', true );

    $_email_options = array();

    if (!empty($email_options) && is_array($email_options)) {

      foreach ($email_options as $index => $email_option) {

        $email_opts = new Wp_Ng_Email_Options();
        $email_opts->set_properties($email_option);
        $_email_options[$index] = $email_opts;
      }
    }



    return $_email_options;
  }


  /**
   * Check email enabled
   */
  public function email_enabled ( $enabled, $object, $object_id, $index = 0 ) {

    if (!$object_id) {
      return $enabled;
    }

    $email_options = $this->get_email_options( $object_id );

    if ( array_key_exists($index, $email_options) ) {
      $enabled = $email_options[$index]->enabled;
    }

    return $enabled;
  }

  /**
   * Set email type
   */
  public function email_type ( $type, $object, $object_id, $index = 0 ) {

    if (!$object_id) {
      return $type;
    }

    $email_options = $this->get_email_options( $object_id );

    if ( array_key_exists($index, $email_options) ) {
      $type = $email_options[$index]->html ? 'html' : 'plain';
    }

    return $type;
  }


  /**
   * Set email recipient
   */
  public function email_recipient ( $recipient, $object, $object_id, $index = 0 ) {

    if (!$object_id) {
      return $recipient;
    }

    $email_options = $this->get_email_options( $object_id );

    if ( array_key_exists($index, $email_options) ) {
      $email_options_recipient = $email_options[$index]->recipient;
    }

    return !empty($email_options_recipient) ? $email_options_recipient : $recipient;
  }


  /**
   * Set email from name
   */
  public function email_from_name ( $from_name, $object, $object_id, $index = 0 ) {

    if (!$object_id) {
      return $from_name;
    }

    $email_options = $this->get_email_options( $object_id );

    if ( array_key_exists($index, $email_options) ) {
      $email_options_from_name = $email_options[$index]->from_name;
    }

    return !empty($email_options_from_name) ? $email_options_from_name : $from_name;
  }


  /**
   * Set email from address
   */
  public function email_from_address ( $from_address, $object, $object_id, $index = 0 ) {

    if (!$object_id) {
      return $from_address;
    }

    $email_options = $this->get_email_options( $object_id );

    if ( array_key_exists($index, $email_options) ) {
      $email_options_from_address = $email_options[$index]->from_address;
    }

    return !empty($email_options_from_address) ? $email_options_from_address : $from_address;
  }


  /**
   * Set email headers
   */
  public function email_headers ( $headers, $object, $object_id, $index = 0 ) {

    if (!$object_id) {
      return $headers;
    }

    $email_options = $this->get_email_options( $object_id );

    if ( array_key_exists($index, $email_options) ) {
      $email_options_headers = $email_options[$index]->headers;
    }

    return !empty($email_options_headers) ? $email_options_headers : $headers;
  }


  /**
   * Set email subject
   */
  public function email_subject ( $subject, $object, $object_id, $index = 0 ) {

    if (!$object_id) {
      return $subject;
    }

    $email_options = $this->get_email_options( $object_id );

    if ( array_key_exists($index, $email_options) ) {
      $email_options_subject = $email_options[$index]->subject;
    }

    return !empty($email_options_subject) ? $email_options_subject : $subject;
  }

  /**
   * Set email heading
   */
  public function email_heading ( $heading, $object, $object_id, $index = 0 ) {

    if (!$object_id) {
      return $heading;
    }

    $email_options = $this->get_email_options( $object_id );

    if ( array_key_exists($index, $email_options) ) {
      $email_options_heading = $email_options[$index]->heading;
    }

    return !empty($email_options_heading) ? $email_options_heading : $heading;
  }


  /**
   * Check email woocommerce template style
   */
  public function is_email_woocommerce_style ( $enabled ) {

    $email_option = wp_ng_get_email_template_option('woocommerce_style');

    if ($email_option === 'on' ) {
      $enabled = true;
    }

    return $enabled;
  }

  /**
   * Check email woocommerce template header and footer
   */
  public function is_email_woocommerce_hf ( $enabled ) {

    $email_option = wp_ng_get_email_template_option('woocommerce_hf');

    if ($email_option === 'on' ) {
      $enabled = true;
    }

    return $enabled;
  }



  /**
   * Hex darker/lighter/contrast functions for colours.
   *
   * @param mixed $color
   * @return string
   */
  public function rgb_from_hex( $color ) {
    $color = str_replace( '#', '', $color );
    // Convert shorthand colors to full format, e.g. "FFF" -> "FFFFFF"
    $color = preg_replace( '~^(.)(.)(.)$~', '$1$1$2$2$3$3', $color );

    $rgb      = array();
    $rgb['R'] = hexdec( $color{0}.$color{1} );
    $rgb['G'] = hexdec( $color{2}.$color{3} );
    $rgb['B'] = hexdec( $color{4}.$color{5} );

    return $rgb;
  }

  /**
   * Hex darker/lighter/contrast functions for colours.
   *
   * @param mixed $color
   * @param int $factor (default: 30)
   * @return string
   */
  public function hex_darker( $color, $factor = 30 ) {
    $base  = $this->rgb_from_hex( $color );
    $color = '#';

    foreach ( $base as $k => $v ) {
      $amount      = $v / 100;
      $amount      = round( $amount * $factor );
      $new_decimal = $v - $amount;

      $new_hex_component = dechex( $new_decimal );
      if ( strlen( $new_hex_component ) < 2 ) {
        $new_hex_component = "0" . $new_hex_component;
      }
      $color .= $new_hex_component;
    }

    return $color;
  }

  /**
   * Hex darker/lighter/contrast functions for colours.
   *
   * @param mixed $color
   * @param int $factor (default: 30)
   * @return string
   */
  public function hex_lighter( $color, $factor = 30 ) {
    $base  = $this->rgb_from_hex( $color );
    $color = '#';

    foreach ( $base as $k => $v ) {
      $amount      = 255 - $v;
      $amount      = $amount / 100;
      $amount      = round( $amount * $factor );
      $new_decimal = $v + $amount;

      $new_hex_component = dechex( $new_decimal );
      if ( strlen( $new_hex_component ) < 2 ) {
        $new_hex_component = "0" . $new_hex_component;
      }
      $color .= $new_hex_component;
    }

    return $color;
  }

  /**
   * Detect if we should use a light or dark colour on a background colour.
   *
   * @param mixed $color
   * @param string $dark (default: '#000000')
   * @param string $light (default: '#FFFFFF')
   * @return string
   */
  public function light_or_dark( $color, $dark = '#000000', $light = '#FFFFFF' ) {

    $hex = str_replace( '#', '', $color );

    $c_r = hexdec( substr( $hex, 0, 2 ) );
    $c_g = hexdec( substr( $hex, 2, 2 ) );
    $c_b = hexdec( substr( $hex, 4, 2 ) );

    $brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

    return $brightness > 155 ? $dark : $light;
  }


  /**
   * Format string as hex.
   *
   * @param string $hex
   * @return string
   */
  public function format_hex( $hex ) {

    $hex = trim( str_replace( '#', '', $hex ) );

    if ( strlen( $hex ) == 3 ) {
      $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }

    return $hex ? '#' . $hex : null;
  }

}
