<?php

/**
 * The file that defines the email class
 * Email Class which is extended by specific email template classes to add emails to Wp Ng
 *
 * Based on source from woocommerce https://github.com/woocommerce/woocommerce
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Email {

	/**
	 * Email method ID.
	 * @var String
	 */
	public $id;

	/**
	 * Email method title.
	 * @var string
	 */
	public $title;

	/**
	 * 'yes' if the method is enabled.
	 * @var string yes, no
	 */
	public $enabled;

	/**
	 * Description for the email.
	 * @var string
	 */
	public $description;

	/**
	 * Plain text template path.
	 * @var string
	 */
	public $template_plain;

	/**
	 * HTML template path.
	 * @var string
	 */
	public $template_html;

	/**
	 * Template path.
	 * @var string
	 */
	public $template_base;

  /**
   * From name
   * @var
   */
  public $from_name;

  /**
   * From email address
   * @var
   */
	public $from_address;

	/**
	 * Recipients for the email.
	 * @var string
	 */
	public $recipient;

  /**
   * Headers
   * @var string
   */
  public $headers;

	/**
	 * Heading for the email content.
	 * @var string
	 */
	public $heading;

	/**
	 * Subject for the email.
	 * @var string
	 */
	public $subject;

  /**
   * Content html for the email.
   * @var string
   */
  public $content_html;

  /**
   * Content Plain Text for the email.
   * @var string
   */
  public $content_plain;

	/**
	 * Object this email is for, for example a user, post, or email.
	 * @var object|bool
	 */
	public $object;

  /**
   * oject id, for example a post id;
   * @var integer
   */
  public $object_id = 0;

	/**
	 * Strings to find in subjects/headings.
	 * @var array
	 */
	public $find = array();

	/**
	 * Strings to replace in subjects/headings.
	 * @var array
	 */
	public $replace = array();

	/**
	 * Mime boundary (for multipart emails).
	 * @var string
	 */
	public $mime_boundary;

	/**
	 * Mime boundary header (for multipart emails).
	 * @var string
	 */
	public $mime_boundary_header;

	/**
	 * True when email is being sent.
	 * @var bool
	 */
	public $sending;

  /**
   * Default_Headers
   * @var string
   */
  protected $default_headers;

	/**
	 * True when the email notification is sent manually only.
	 * @var bool
	 */
	protected $manual = false;

	/**
	 * True when the email notification is sent to user.
	 * @var bool
	 */
	protected $user_email_enable = false;

  /**
   * email list index.
   * @var bool
   */
  protected $index = 0;

  /**
   * True when the email template style is from woocommerce.
   * @var bool
   */
  protected $woocommerce_style;

  /**
   * True when the email template header and footer is from woocommerce.
   * @var bool
   */
  protected $woocommerce_hf;


	/**
	 *  List of preg* regular expression patterns to search for,
	 *  used in conjunction with $plain_replace.
	 *  https://raw.github.com/ushahidi/wp-silcc/master/class.html2text.inc
	 *  @var array $plain_search
	 *  @see $plain_replace
	 */
	public $plain_search = array(
		"/\r/",                                          // Non-legal carriage return
		'/&(nbsp|#160);/i',                              // Non-breaking space
		'/&(quot|rdquo|ldquo|#8220|#8221|#147|#148);/i', // Double quotes
		'/&(apos|rsquo|lsquo|#8216|#8217);/i',           // Single quotes
		'/&gt;/i',                                       // Greater-than
		'/&lt;/i',                                       // Less-than
		'/&#38;/i',                                      // Ampersand
		'/&#038;/i',                                     // Ampersand
		'/&amp;/i',                                      // Ampersand
		'/&(copy|#169);/i',                              // Copyright
		'/&(trade|#8482|#153);/i',                       // Trademark
		'/&(reg|#174);/i',                               // Registered
		'/&(mdash|#151|#8212);/i',                       // mdash
		'/&(ndash|minus|#8211|#8722);/i',                // ndash
		'/&(bull|#149|#8226);/i',                        // Bullet
		'/&(pound|#163);/i',                             // Pound sign
		'/&(euro|#8364);/i',                             // Euro sign
		'/&#36;/',                                       // Dollar sign
		'/&[^&\s;]+;/i',                                 // Unknown/unhandled entities
		'/[ ]{2,}/'                                      // Runs of spaces, post-handling
	);

	/**
	 *  List of pattern replacements corresponding to patterns searched.
	 *  @var array $plain_replace
	 *  @see $plain_search
	 */
	public $plain_replace = array(
		'',                                             // Non-legal carriage return
		' ',                                            // Non-breaking space
		'"',                                            // Double quotes
		"'",                                            // Single quotes
		'>',                                            // Greater-than
		'<',                                            // Less-than
		'&',                                            // Ampersand
		'&',                                            // Ampersand
		'&',                                            // Ampersand
		'(c)',                                          // Copyright
		'(tm)',                                         // Trademark
		'(R)',                                          // Registered
		'--',                                           // mdash
		'-',                                            // ndash
		'*',                                            // Bullet
		'£',                                            // Pound sign
		'EUR',                                          // Euro sign. € ?
		'$',                                            // Dollar sign
		'',                                             // Unknown/unhandled entities
		' '                                             // Runs of spaces, post-handling
	);

	/**
	 * Constructor.
	 */
	public function __construct() {

    // Default template base if not declared in child constructor
    if ( is_null( $this->template_base ) ) {
      $this->template_base = WP_NG_PLUGIN_DIR . 'public/templates/';
    }

    // Woocommerce style
    if ( is_null( $this->woocommerce_style ) ) {
      $this->woocommerce_style = apply_filters( 'wp_ng_woocommerce_style', false );;
    }

    // Woocommerce header and footer
    if ( is_null( $this->woocommerce_hf ) ) {
      $this->woocommerce_hf = apply_filters( 'wp_ng_woocommerce_hf', false );;
    }

    // Settings
    $this->heading        = (!empty($this->heading) ? $this->heading : $this->get_blogname());
    $this->subject        = (!empty($this->subject) ? $this->subject : $this->get_blogname());
    $this->content_html   = (!empty($this->content_html) ? $this->content_html : '');
    $this->content_plain  = (!empty($this->content_plain) ? $this->content_plain : '');
    $this->email_type     = (!empty($this->email_type) ? $this->email_type : 'html');
    $this->enabled        = (!empty($this->enabled) ? $this->enabled : false);

    $this->from_name       = wp_ng_get_email_sender_option( 'from_name' );
    $this->from_address    = wp_ng_get_email_sender_option( 'from_address' );
    $this->default_headers = "Content-Type: " . $this->get_content_type() . PHP_EOL;
    $this->headers         = (!empty($this->headers) ? $this->headers : '');

    // Find/replace
    $this->find['blogname']      = '{blogname}';
    $this->find['site_title']    = '{site_title}';
    $this->find['site_url']      = '{site_url}';
    $this->find['ip_address']    = '{ip_address}';
    $this->find['user_agent']    = '{user_agent}';
    $this->replace['blogname']   = $this->get_blogname();
    $this->replace['site_title'] = $this->get_blogname();
    $this->replace['site_url']   = esc_url( network_site_url() );
    $this->replace['ip_address'] = wp_ng_get_ip_address();
    $this->replace['user_agent'] = wp_ng_get_user_agent();



    // For multipart messages
    add_action( 'phpmailer_init', array( $this, 'handle_multipart' ) );

	}

	/**
	 * Handle multipart mail.
	 *
	 * @param PHPMailer $mailer
	 * @return PHPMailer
	 */
	public function handle_multipart( $mailer )  {
		if ( $this->sending && 'multipart' === $this->get_email_type() ) {
			$mailer->AltBody = wordwrap( preg_replace( $this->plain_search, $this->plain_replace, strip_tags( $this->get_content_plain() ) ) );
			$this->sending   = false;
		}
		return $mailer;
	}

	/**
	 * Format email string.
	 *
	 * @param mixed $string
	 * @return string
	 */
	public function format_string( $string ) {

	  $find = apply_filters( 'wp_ng_email_format_string_find', $this->find, $this );
    $replace = apply_filters( 'wp_ng_email_format_string_replace', $this->replace, $this );

    //Transaltion for boolean.
    if($replace === 'true') { $replace = __('True', 'wp-ng'); }
    if($replace === 'false') { $replace = __('False', 'wp-ng'); }

    return $this->clean_string(str_replace( $find, $replace,  $string ));
	}


  /**
   * Cleaning all brakets not in find replace.
   *
   * @param $string
   * @return mixed
   */
	public function clean_string( $string ) {

    return preg_replace('/\{.*\}/', '', $string);
  }

	/**
	 * Get email subject.
	 *
	 * @return string
	 */
	public function get_subject() {


		return $this->format_string( apply_filters( 'wp_ng_email_subject_' . $this->id, $this->subject, $this->object, $this->object_id, $this->index ));
	}

	/**
	 * Get email heading.
	 *
	 * @return string
	 */
	public function get_heading() {
		return $this->format_string( apply_filters( 'wp_ng_email_heading_' . $this->id, $this->heading, $this->object, $this->object_id, $this->index ));
	}

	/**
	 * Get valid recipients.
	 * @return string
	 */
	public function get_recipient() {
		$recipient  = $this->format_string( apply_filters( 'wp_ng_email_recipient_' . $this->id, $this->recipient, $this->object, $this->object_id, $this->index ));
		$recipients = array_map( 'trim', explode( ',', $recipient ) );
		$recipients = array_filter( $recipients, 'is_email' );
		return implode( ', ', $recipients );
	}

	/**
	 * Get email headers.
	 *
	 * @return string
	 */
	public function get_headers() {

	  $headers_attribute = array();

	  $headers = $this->format_string( apply_filters( 'wp_ng_email_headers_' . $this->id, $this->headers, $this->object, $this->object_id, $this->index ));

	  if (!empty($headers)) {
      preg_match_all('/(.*?):\s?(.*?)(\r\n|$)/', $headers, $matches);
      $headers_attribute = array_combine(array_map('trim', $matches[1]), $matches[2]);
    }

    preg_match_all('/(.*?):\s?(.*?)(\r\n|$)/', $this->default_headers, $matches);
    $default_headers_attribute = array_combine(array_map('trim', $matches[1]), $matches[2]);

    foreach ( $default_headers_attribute as $key => $value ) {

      if (!array_key_exists($key, $headers_attribute)) {
        $headers_attribute[$key] = $value;
      }
    }

    $headers = '';
    foreach ($headers_attribute as $key => $value ) {
      $headers .= sprintf('%s: %s%s', $key, $value, PHP_EOL);
    }


		return $headers;
	}

	/**
	 * Get email attachments.
	 *
	 * @return string
	 */
	public function get_attachments() {
		return apply_filters( 'wp_ng_email_attachments_' . $this->id, array(), $this->id, $this->object, $this->object_id, $this->index );
	}

	/**
	 * get_type function.
	 *
	 * @return string
	 */
	public function get_email_type() {
    $email_type = $this->email_type && class_exists( 'DOMDocument' ) ? $this->email_type : 'plain';

    return apply_filters( 'wp_ng_email_type_' . $this->id, $email_type, $this->object, $this->object_id, $this->index );
	}

	/**
	 * Get email content type.
	 *
	 * @return string
	 */
	public function get_content_type() {
		switch ( $this->get_email_type() ) {
			case 'html' :
				return 'text/html';
			case 'multipart' :
				return 'multipart/alternative';
			default :
				return 'text/plain';
		}
	}

	/**
	 * Return the email's title
	 * @return string
	 */
	public function get_title() {
		return apply_filters( 'wp_ng_email_title', $this->title, $this );
	}

	/**
	 * Return the email's description
	 * @return string
	 */
	public function get_description() {
		return apply_filters( 'wp_ng_email_description', $this->description, $this );
	}

	/**
	 * Checks if this email is enabled and will be sent.
	 * @return bool
	 */
	public function is_enabled() {

		return apply_filters( 'wp_ng_email_enabled_' . $this->id, ('on' === $this->enabled || true === $this->enabled), $this->object, $this->object_id, $this->index );
	}

	/**
	 * Checks if this email is manually sent
	 * @return bool
	 */
	public function is_manual() {
		return $this->manual;
	}

	/**
	 * Checks if this email is user focussed.
	 * @return bool
	 */
	public function is_user_email() {
		return $this->user_email_enable;
	}

  /**
   * Checks if this email will be sent with woocommerce style.
   * @return bool
   */
  public function is_woocommerce_style() {

    return $this->woocommerce_style;
  }

  /**
   * Checks if this email be sent with woocommerce header and footer
   * @return bool
   */
  public function is_woocommerce_hf() {

    return $this->woocommerce_hf;
  }

	/**
	 * Get WordPress blog name.
	 *
	 * @return string
	 */
	public function get_blogname() {
		return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}

	/**
	 * Get email content.
	 *
	 * @return string
	 */
	public function get_content() {
		$this->sending = true;

		if ( 'plain' === $this->get_email_type() ) {
			$email_content = $this->clean_string(preg_replace( $this->plain_search, $this->plain_replace, strip_tags( $this->get_content_plain() ) ));
		} else {
			$email_content = $this->clean_string($this->get_content_html());
		}

		return wordwrap( $email_content, 70 );
	}

	/**
	 * Apply inline styles to dynamic content.
	 *
	 * @param string|null $content
	 * @return string
	 */
	public function style_inline( $content ) {
		// make sure we only inline CSS for html emails
		if ( in_array( $this->get_content_type(), array( 'text/html', 'multipart/alternative' ) ) && class_exists( 'DOMDocument' ) ) {

		  //Woocommerce Style
      if ( $this->is_woocommerce_style() === true && function_exists('wc_get_template') ) {
        ob_start();
        wc_get_template( 'emails/email-styles.php' );
        $css = apply_filters( 'woocommerce_email_styles', ob_get_clean() );
      }
      else {
        $css = wp_ng_get_template( 'emails/email-styles.php', null, null, false );
      }

			$css = apply_filters( 'wp_ng_email_styles', $css );

			// apply CSS styles inline for picky email clients
			try {
				$emogrifier = new Pelago\Emogrifier( $content, $css );
				$content    = $emogrifier->emogrify();
			} catch ( Exception $e ) {
        do_action('wp_ng_log_error', 'emogrifier', $e->getMessage() );
			}
		}
		return $content;
	}

	/**
	 * Get the email content in plain text format.
	 * @return string
	 */
	public function get_content_plain() {
	  return apply_filters( 'wp_ng_email_content_plain', $this->content_plain, $this );
	}

	/**
	 * Get the email content in HTML format.
	 * @return string
	 */
	public function get_content_html() {
    return apply_filters( 'wp_ng_email_content_html', $this->content_html, $this );
	}

	/**
	 * Get the from name for outgoing emails.
	 * @return string
	 */
	public function get_from_name() {
		$from_name = $this->format_string( apply_filters( 'wp_ng_email_from_name_' . $this->id, $this->from_name, $this->object, $this->object_id, $this->index ));
		return wp_specialchars_decode( esc_html( $from_name ), ENT_QUOTES );
	}

	/**
	 * Get the from address for outgoing emails.
	 * @return string
	 */
	public function get_from_address() {
		$from_address = $this->format_string( apply_filters( 'wp_ng_email_from_address_' . $this->id, $this->from_address, $this->object, $this->object_id, $this->index ));
		return sanitize_email( $from_address );
	}

	/**
	 * Send an email.
	 * @param string $to
	 * @param string $subject
	 * @param string $message
	 * @param string $headers
	 * @param string $attachments
	 * @return bool success
	 */
	public function send( $to, $subject, $message, $headers, $attachments ) {
		add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		add_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );

		$message = apply_filters( 'wp_ng_mail_content', $this->style_inline( $message ) );
		$return  = wp_mail( $to, $subject, $message, $headers, $attachments );

		remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		remove_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );

		return $return;
	}

}
