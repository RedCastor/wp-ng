<?php

/**
 * The admin-specific includes functionality of the plugin.
 *
 * @link       http://redcastor.io
 * @since      1.6.2
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
class Wp_Ng_Admin_Metabox_Ng_Router {

  private $post_type;
  private $screen;

  /**
   * Initialize the class and set its properties.
   *
   * Wp_Ng_Admin_Metabox_Ng_Router constructor.
   *
   * @param $post_type
   * @param $screen
   */
  public function __construct( $post_type, $screen ) {

    $this->post_type  = $post_type;
    $this->screen     = $screen;

    //Only for options manager
    if ( current_user_can('manage_options') ) {

      add_action( 'add_meta_boxes_' . $this->post_type, array($this, 'add_meta_boxes'), 10 );

      add_action( 'save_post_' . $this->post_type,      array($this, 'save_options'), 20 );
    }
  }


  /**
   * Add the metaboxes
   *
   * @since 1.6.2
   */
  public function add_meta_boxes( $post ) {

    $post_id = absint($post->ID);

    add_meta_box(
      'wp_ng_router',
      __( 'Angular Router', 'wp-ng' ),
      array( $this, 'ng_router' ),
      $this->screen,
      'side',
      'high'
    );

  }


  /**
   * Include the metabox partial router
   *
   * @since 1.6.2
   * @param  object $post
   * @param  array $metabox full metabox items array
   */
  public function ng_router( $post, $metabox ) {

    $state = wp_ng_get_ng_router_state_fields( $post->ID );
    $is_routed = get_post_meta( $post->ID, '_is_ng_routed', true );

    $this->content_ng_router($is_routed, $state);
  }


  /**
   * Content meta box ng_router
   *
   * @param $is_routed
   * @param $state
   */
  public function content_ng_router ( $is_routed, $state ) {

    $controller_choices = Wp_Ng_Public_Ui_Router::get_ng_router_controller_list();
    $resolve_choices = Wp_Ng_Public_Ui_Router::get_ng_router_resolve_list();

    include plugin_dir_path( dirname( dirname( __FILE__ ) ) ) . 'partials/metaboxes/ng-router-view.php' ;

    //Add nonce
    wp_nonce_field( 'ng_router', 'ng_router_nonce' );
  }


  /**
   * Saves options meta
   *
   * @since 1.6.2
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
    if ((isset( $_POST['ng_router_nonce'] ) && wp_verify_nonce( $_POST['ng_router_nonce'], 'ng_router' ))) {

      //Delete cache
      wp_ng_delete_ng_router_cache();

      $is_routed = isset( $_POST['is_ng_routed'] ) ? true : false ;
      update_post_meta( $post_id, '_is_ng_routed', $is_routed );

      if ( isset( $_POST['ng_router_state'] ) ) {

        $state = $_POST['ng_router_state'];

        // Sanitize fields
        $state['controller'] = !empty($state['controller']) ? sanitize_text_field( $state['controller'] ) : '';
        $state['resolve'] = array(
          'service' => !empty($state['resolve']['service']) ? sanitize_text_field( $state['resolve']['service'] ) : '',
          'redirect' => !empty($state['resolve']['redirect']) ? wp_ng_trim_all(sanitize_text_field( $state['resolve']['redirect'] )) : '',
        );

        // save router
        update_post_meta( $post_id, '_ng_router_state', apply_filters( 'wp_ng_save_ng_router_state_sanitized', $state, $post_id ) );

      }

      //Hook after save router
      do_action('wp_ng_save_ng_router', $post_id, $this->post_type);
    }

  }



}
