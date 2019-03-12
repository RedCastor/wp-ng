<?php

/**
 * The admin-specific includes functionality of the plugin.
 *
 * @link       http://redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/admin/includes/metaboxes
 */


/**
 * The admin-specific includes functionality of the plugin.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/admin/includes/metaboxes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Admin_Metabox_Email_Options {

  private $post_type;
  private $screen;
  private $email_id;
  private $number;
  private $simple;

  /**
   * Initialize the class and set its properties.
   *
   * Wp_Ng_Admin_Metabox_Email_Options constructor.
   *
   * @param $post_type
   * @param $screen
   * @param string $email_id
   * @param int $number
   */
  public function __construct( $post_type, $screen, $email_id = '', $number = 1, $simple = false ) {

    $this->post_type  = $post_type;
    $this->screen     = $screen;
    $this->email_id   = $email_id;
    $this->number     = $number;
    $this->simple     = $simple;

    add_action( 'add_meta_boxes_' . $this->post_type, array($this, 'add_meta_boxes'), 10 );
    add_action( 'admin_head',                         array($this, 'remove_media_buttons') );
    add_action( 'save_post_' . $this->post_type,      array($this, 'save_options'), 20 );

    add_filter( 'wp_ng_email_tiny_mce_mail_init',  array($this, 'tinymce_settings') );
    add_filter( 'wp_ng_email_wpeditor_email_init', array($this, 'wpeditor_settings') );

  }


  /**
   * Remove Media Button TinyMce
   */
  public function remove_media_buttons() {
    $current_screen = get_current_screen();

    if( $current_screen && $current_screen->post_type === $this->post_type ) {
      remove_action('media_buttons', 'media_buttons');
    }
  }


  /**
   * Email TinyMce settings init
   *
   * @param $settings
   *
   * @return $settings
   */
  public function tinymce_settings( $settings ) {

    $settings['fix_list_elements'] = FALSE;
    $settings['remove_linebreaks'] = FALSE;
    $settings['remove_trailing_brs'] = FALSE;
    $settings['apply_source_formatting'] = FALSE;
    $settings['verify_html'] = TRUE;

    return $settings;
  }


  /**
   * Email wpeditor settings init
   *
   * @param $settings
   *
   * @return $settings
   */
  public function wpeditor_settings( $settings ) {

    $settings['media_buttons'] = FALSE;
    $settings['wpautop'] = FALSE;

    return $settings;
  }


  /**
   * Add the metaboxes
   *
   * @since 1.5.0
   */
  public function add_meta_boxes( $post ) {


    //WPML Compatibility not add metabox on translation.
    $post_id = absint($post->ID);
    $element_language = apply_filters( 'wpml_element_language_details', null, array('element_id' => $post->ID, 'element_type' => $post->post_type ) );

    if ($element_language) {
      $post_id = apply_filters('wpml_object_id', $post->ID, $post->post_type, true, $element_language->source_language_code);
    }

    add_meta_box(
      'wp_ng_email_options',
      __( 'Email Settings', 'wp-ng' ),
      array( $this, 'email_options' ),
      $this->screen,
      'normal',
      'high'
    );

  }

  /**
   * Content meta box email options
   *
   * @param array $email_options
   * @param bool $simple
   */
  public function content_email_options ( $email_options, $simple = false ) {


    //Help email variable.
    $email = new Wp_Ng_Email();
    $email_help_vars = apply_filters('wp_ng_email_options_help', array(
      array(
        'title' => __('Default fields', 'wp-rc-form'),
        'desc' => implode(', ', $email->find),
      ),
    ));


    include plugin_dir_path( dirname( dirname( __FILE__ ) ) ) . 'partials/metaboxes/email-help-view.php' ;

    //Email options list
    foreach ($email_options as $index => $email_option) {

      if (is_a($email_option, 'Wp_Ng_Email_Options')) {

        echo '<div id="wp_ng_email_options_' .  $index. '" class="wp-ng-box">';

        $opts = $email_option->get_properties();
        $opts['id'] = $index;
        $opts['simple'] = $simple;

        include plugin_dir_path( dirname( dirname( __FILE__ ) ) ) . 'partials/metaboxes/email-options-view.php' ;

        echo '</div>';
      }
    }

    //Add nonce
    wp_nonce_field( 'email_options', 'email_options_nonce' );
  }


  /**
   * Include the metabox partial email options
   *
   * @since 1.0.0
   * @param  object $post
   * @param  array $metabox full metabox items array
   */
  public function email_options( $post, $metabox ) {

    $email_options = apply_filters('wp_ng_metabox_email_options', wp_ng_get_email_options( $post->ID ), $post->ID );

    if (empty($email_options)) {
      $email_options = array();
    }

    $count_email_options = count($email_options);

    if ($count_email_options < $this->number) {

      for ($index = $count_email_options; $index < $this->number; $index++) {
        $email_options[] = new Wp_Ng_Email_Options();
      }
    }

    $this->content_email_options($email_options, $this->simple);
  }


  /**
   * Saves email options meta
   *
   * @since 1.5.0
   * @param $post_id
   * @return mixed
   */
  public function save_options( $post_id ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return $post_id;
    }
    // same for ajax
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
      return $post_id;
    }
    // same for cron
    if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
      return $post_id;
    }
    // same for posts revisions
    if ( wp_is_post_revision( $post_id ) ) {
      return $post_id;
    }

    // can user edit this post?
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return $post_id;
    }


    if ( !get_post_type($post_id) === $this->post_type ) {
      return $post_id;
    }

    // Verify the nonce.
    if ( isset( $_POST['email_options'] ) && (isset( $_POST['email_options_nonce'] ) && wp_verify_nonce( $_POST['email_options_nonce'], 'email_options' )) ) {

      $post_email_options = $_POST['email_options'];

      $meta_email_options = array();

      foreach ($post_email_options as $post_email_option) {

        $email_option_instance = new Wp_Ng_Email_Options();

        // sanitize settings
        $email_option_instance->enabled = absint( sanitize_text_field( $post_email_option['enabled'] ) );
        $email_option_instance->html = absint( sanitize_text_field( $post_email_option['html'] ) );

        if ( !$this->simple ) {
          $email_option_instance->recipient = sanitize_text_field( $post_email_option['recipient'] );
          $email_option_instance->from_name = sanitize_text_field( $post_email_option['from_name'] );
          $email_option_instance->from_address = sanitize_text_field( $post_email_option['from_address'] );
        }

        $email_option_instance->headers = sanitize_textarea_field( $post_email_option['headers'] );
        $email_option_instance->heading = sanitize_text_field( $post_email_option['heading'] );
        $email_option_instance->subject = sanitize_text_field( $post_email_option['subject'] );
        $email_option_instance->content_html = wp_kses_post( $post_email_option['content_html'] );
        $email_option_instance->content_plain = sanitize_textarea_field( $post_email_option['content_plain'] );


        //Set default email heading and subject.
        $wp_ng_emails = wp_ng_emails();
        $emails = $wp_ng_emails->get_emails();
        $email_index = array_search(apply_filters('wp_ng_save_email_options_get_email_id', $this->email_id, $post_id), array_column($emails, 'id'));

        if( $email_index !== false) {
          $emails_keys = array_keys($emails);
          $email = $emails[$emails_keys[$email_index]];

          if ( $email_option_instance->heading === '' ) $email_option_instance->heading = $email->heading;
          if ( $email_option_instance->subject === '' ) $email_option_instance->subject = $email->subject;
          if ( $email_option_instance->content_html === '' ) $email_option_instance->content_html = $email->content_html;
          if ( $email_option_instance->content_plain === '' ) $email_option_instance->content_plain = $email->content_plain;
        }

        $meta_email_options[] = $email_option_instance->get_properties();
      }

      // save email options
      update_post_meta( $post_id, 'email_options', apply_filters( 'wp_ng_save_email_options_sanitized', $meta_email_options, $post_id ) );

    }

    //Hook after save email options
    do_action('wp_ng_save_email_options_' . $this->post_type, $post_id);

  }



}
