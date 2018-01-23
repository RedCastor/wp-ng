<?php

/**
 *  Wp Ng Emails
 *  Class that will manage emails compatible with woocommerce style and header footer email
 *
 * Based on source from woocommerce https://github.com/woocommerce/woocommerce
 *
 * @link       http://www.redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public
 */

/**
 * Define the email manager.
 *
 * @since      1.4.2
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Emails {

	/** @var array Array of email notification classes */
	public $emails = array();

	/** @var Wp_Ng_Emails The single instance of the class */
  private static $_instance = null;

	/**
	 * Main Wp_Ng_Emails Instance.
	 *
	 * Ensures only one instance of Wp_Ng_Emails is loaded or can be loaded.
	 *
	 * @since 1.4.2
	 * @static
	 * @return Wp_Ng_Emails Main instance
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
	 * Hook in all transactional emails.
	 */
	public static function init_transactional_emails() {
    $instance = self::getInstance();

    // Include email classes
    $instance->emails = apply_filters( 'wp_ng_email_classes', $instance->emails );

    // Add Email IDs Hook for enabled and type
    foreach ( $instance->emails as $email_id => $email ) {

      //Email Enabled Hook by ID
      add_filter( 'wp_ng_email_enabled_' . $email->id, array(Wp_Ng_Helper(), 'email_enabled'), 10, 4);

      //Email Type Hook by ID
      add_filter( 'wp_ng_email_type_' . $email->id, array(Wp_Ng_Helper(), 'email_type'), 10, 4);

      //Email Recipient Hook by ID
      add_filter( 'wp_ng_email_recipient_' . $email->id, array(Wp_Ng_Helper(), 'email_recipient'), 10, 4);

      //Email From Name Hook by ID
      add_filter( 'wp_ng_email_from_name_' . $email->id, array(Wp_Ng_Helper(), 'email_from_name'), 10, 4);

      //Email From Address Hook by ID
      add_filter( 'wp_ng_email_from_address_' . $email->id, array(Wp_Ng_Helper(), 'email_from_address'), 10, 4);

      //Email Headers Hook by ID
      add_filter( 'wp_ng_email_headers_' . $email->id, array(Wp_Ng_Helper(), 'email_headers'), 10, 4);

      //Email Subject Hook by ID
      add_filter( 'wp_ng_email_subject_' . $email->id, array(Wp_Ng_Helper(), 'email_subject'), 10, 4);

      //Email Heading Hook by ID
      add_filter( 'wp_ng_email_heading_' . $email->id, array(Wp_Ng_Helper(), 'email_heading'), 10, 4);
    }

    //Add Actions
	  $email_actions = apply_filters( 'wp_ng_email_actions', array() );

		foreach ( $email_actions as $action ) {
			add_action( $action, array( __CLASS__, 'send_transactional_email' ), 10, 10 );
		}

    // Let 3rd parties unhook the above via this hook
    do_action( 'wp_ng_init_emails', $instance );
	}

	/**
	 * Init the mailer instance and call the notifications for the current filter.
	 * @internal param array $args (default: array())
	 */
	public static function send_transactional_email() {

	  self::getInstance();

		$args = func_get_args();
		do_action_ref_array( current_filter() . '_notification', $args );
	}

	/**
	 * Constructor for the email class hooks in all emails that can be sent.
	 *
	 */
	public function __construct() {

    require_once ('emails/class-wp-ng-email.php');

    //Email Woocommerce Style
    add_filter( 'wp_ng_woocommerce_style', array(Wp_Ng_Helper(), 'is_email_woocommerce_style'));
    //Email Woocommerce Header Footer
    add_filter( 'wp_ng_woocommerce_hf', array(Wp_Ng_Helper(), 'is_email_woocommerce_hf'));

    // Email Header, Footer and content hooks
    add_action( 'wp_ng_email_header', array( $this, 'email_header' ), 10, 2 );
    add_action( 'wp_ng_email_footer', array( $this, 'email_footer' ), 10 );
	}


  /**
   * Register a email class
   * @param $email_id
   * @param $email_instance
   */
	public function register_email( $email_id, $email_instance ) {

	  //Register email if is not registered
	  if ( !array_key_exists($email_id, $this->emails) ) {
      $this->emails[$email_id] = $email_instance;

      return true;
    }

    return false;
  }


	/**
	 * Return the email classes - used in admin to load settings.
	 *
	 * @return array
	 */
	public function get_emails() {
		return $this->emails;
	}

	/**
	 * Get from name for email.
	 *
	 * @return string
	 */
	public function get_from_name() {
		return wp_specialchars_decode( wp_ng_get_email_sender_option( 'from_name' ), ENT_QUOTES );
	}

	/**
	 * Get from email address.
	 *
	 * @return string
	 */
	public function get_from_address() {
		return sanitize_email( wp_ng_get_email_sender_options( 'from_address' ) );
	}

	/**
	 * Get the email header.
	 *
	 * @param mixed $email_heading heading for the email
   * @param Wp_Ng_Email $email
	 */
	public function email_header( $email_heading, $email ) {

    if ( $email->is_woocommerce_hf() === true && function_exists('wc_get_template') ) {
      wc_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading ) );
    }
    else {
      wp_ng_get_template( 'emails/email-header.php', null, array( 'email_heading' => $email_heading ) );
    }
	}

	/**
	 * Get the email footer.
   *
   * @param mixed $email_footer footer for the email
   * @param Wp_Ng_Email $email
	 */
	public function email_footer( $email ) {

    if ( $email->is_woocommerce_hf() === true && function_exists('wc_get_template') ) {
      wc_get_template( 'emails/email-footer.php', '');
    }
    else {
      wp_ng_get_template( 'emails/email-footer.php' );
    }
	}

	/**
	 * Wraps a message in the wp ng mail template.
	 *
	 * @param mixed $email_heading
	 * @param string $message
	 * @return string
	 */
	public function wrap_message( $email_heading, $message, $plain_text = false ) {
		// Buffer
		ob_start();

		do_action( 'wp_ng_email_header', $email_heading  );

		echo wpautop( wptexturize( $message ) );

		do_action( 'wp_ng_email_footer' );

		// Get contents
		$message = ob_get_clean();

		return $message;
	}

	/**
	 * Send the email.
	 *
	 * @param mixed $to
	 * @param mixed $subject
	 * @param mixed $message
	 * @param string $headers (default: "Content-Type: text/html\r\n")
	 * @param string $attachments (default: "")
	 * @return bool
	 */
	public function send( $to, $subject, $message, $headers = "Content-Type: text/html\r\n", $attachments = "" ) {
		// Send
		$email = new Wp_Ng_Email();
		return $email->send( $to, $subject, $message, $headers, $attachments );
	}


  public function send_error_message() {

    $admin_email = get_bloginfo('admin_email');
    $message = __( 'An error appears to send email.', 'wp-ng');
    $message .= ' ' . __( 'Please contact the site administrator at', 'wp-ng');
    $message .= ' ' . sprintf('<a href="mailto:%1$s?subject=Email not send">%1$s</a>', $admin_email);

    return $message;
  }


	/**
	 * Get blog name formatted for emails.
	 * @return string
	 */
	private function get_blogname() {
		return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}


}
