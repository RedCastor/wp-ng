<?php

/**
 * The admin-facing includes functionality gallery.
 *
 * @link       http://redcastor.io
 * @since      1.5.0
 *
 * @package    Wp-Ng
 * @subpackage Wp-Ng/admin/includes
 */







/**
 *
 * @package    Wp-Ng
 * @subpackage Wp-Ng/admin/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Admin_Gallery {


  /**
   * Init Gallery.
   */
  static public function init() {

    if ( wp_ng_is_admin_gallery() ) {

      add_action('print_media_templates', array(__CLASS__, 'gallery_print_media_templates'));
      add_action('wp_enqueue_media',      array(__CLASS__, 'gallery_enqueue_admin_scripts'), 100);

      add_filter( 'attachment_fields_to_edit', array(__CLASS__, 'attachment_fields'), 10, 2 );
      add_filter( 'attachment_fields_to_save', array(__CLASS__, 'attachment_fields_save'), 10, 2 );
    }

  }



  /**
   * Register the script for the admin.
   *
   * @since    1.5.0
   */
  static public function gallery_enqueue_admin_scripts() {
    global $pagenow;


    //Register style wp-ng-admin
    wp_register_style(WP_NG_PLUGIN_NAME . '-gallery', wp_ng_get_admin_asset_path('styles/' . WP_NG_PLUGIN_NAME . '-gallery.css'), array(), WP_NG_PLUGIN_VERSION, 'all');
    wp_enqueue_style(WP_NG_PLUGIN_NAME . '-gallery');


    if($pagenow === 'upload.php') {
      return;
    }

    //Register script wp-ng-gallery
    wp_register_script(WP_NG_PLUGIN_NAME . '-gallery', wp_ng_get_admin_asset_path('scripts/' . WP_NG_PLUGIN_NAME . '-gallery.js'), array('jquery'), WP_NG_PLUGIN_VERSION, false);
    wp_enqueue_script(WP_NG_PLUGIN_NAME . '-gallery');
  }


  /**
   * Display settings gallery in back-end
   *
   * @since    1.5.0
   */
  static public function gallery_print_media_templates() {

    $modules_options = wp_ng_get_active_modules( false );

    //Default module
    $module_builtin = array(
      'name' => 'builtin',
      'title' => __('Built-in', 'wp-ng'),
    );

    //Default
    $modules_gallery = array($module_builtin);

    foreach ( $modules_options as  $module_handle => $module_options) {

      if ( !empty($module_options['admin_gallery']) ) {

        $types = array();
        $themes = array();

        //Types Gallery
        if ( is_array($module_options['admin_gallery']) ) {
          $module_field = wp_ng_get_module_options_field( $module_handle, 'admin_gallery');

          foreach ($module_options['admin_gallery'] as $key => $name) {
            if ( !empty($module_field['options']) ) {
              $types[$name] = $module_field['options'][$name];
            }
          }
        }

        //Themes Gallery
        foreach ($module_options as $option_name => $options) {

          if ( strpos($option_name, 'admin_gallery_themes_') === 0 && is_array($options) ) {

            $theme_name = substr($option_name, strlen('admin_gallery_themes_'));

            $module_field = wp_ng_get_module_options_field( $module_handle, $option_name);
            $themes[$theme_name] = array();

            foreach ($options as $key => $name) {

              if ( !empty($module_field['options']) ) {
                $themes[$theme_name][$name] = $module_field['options'][$name];
              }
            }
          }

        }

        //Module gallery
        $module_gallery = array(
          'name'   => wp_ng_sanitize_name( 'handle', $module_handle ),
          'title'  => wp_ng_sanitize_name( 'handle', $module_handle ),
        );

        if ( !empty($types) ) {
          $module_gallery['types'] = $types;
        }

        if ( !empty($themes) ) {
          $module_gallery['themes'] = $themes;
        }

        $modules_gallery[] = $module_gallery;
      }
    }

    $modules_gallery = apply_filters('wp_ng_admin_gallery_modules', $modules_gallery);

    include plugin_dir_path( dirname(__FILE__) ) . '/partials/gallery-view.php';
  }


  /**
   * Add fields to attachment.
   *
   * @param $form_fields
   * @param $post
   * @return mixed
   */
  static public function attachment_fields( $form_fields, $post ) {


    $form_fields['video_url'] = array(
      'label' => __('Video Url', 'wp-ng'),
      'input' => 'text',
      'value' => get_post_meta( $post->ID, 'video_url', true ),
    );

    return $form_fields;
  }


  /**
   * Save attachment fields
   *
   * @param $post
   * @param $attachment
   * @return mixed
   */
  static public function attachment_fields_save( $post, $attachment ) {

    $form_fields = self::attachment_fields(array(), $post);

    foreach ($form_fields as $field_key => $field_values) {

      if( isset( $attachment[$field_key] ) ) {
        update_post_meta( $post['ID'], $field_key, $attachment[$field_key] );
      }
    }

    return $post;
  }


}
