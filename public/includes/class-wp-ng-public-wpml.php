<?php

/**
 * The public-facing includes functionality wpml.
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
class Wp_Ng_Public_wpml {


  /**
   * Init wpml.
   */
  public static function init() {


    //Hook Rest Api for delete translated attachment
    add_action( 'rest_delete_attachment', array( __CLASS__, 'rest_delete_attachment_post'), 10, 3 );
    //Hook Rest Api for insert translated attachment
    add_action( 'rest_insert_attachment', array( __CLASS__, 'rest_insert_attachment_post'), 10, 3 );

    //Hook filter for get a translation by id
    add_filter( 'wp_ng_translate_id', 	  array(__CLASS__, 'get_translate_id'), 10, 3 );
  }


  /**
   * Delete translate post attachement on delete by rest api
   *
   * @param $post
   * @param $response
   * @param $request
   */
  public static function rest_delete_attachment_post($post, $response, $request) {

    $translated_ids = self::get_translated_ids($post->ID);

    foreach ( $translated_ids as $lang_code => $translated_pid ) {
      wp_delete_post( $translated_pid );
    }
  }


  /**
   * Insert translate post attachement on create by rest api
   *
   * @param $post
   * @param $request
   * @param $update
   */
  public static function rest_insert_attachment_post($post, $request, $update) {

    $translated_ids = self::get_translated_ids($post->ID);

    //insert alt text for translation
    if ( !empty( $request['alt_text'] ) ) {

      foreach ($translated_ids as $lang_code => $translated_pid) {

        //Insert only if empty not override existing.
        if ( empty(get_post_meta($translated_pid, '_wp_attachment_image_alt', true)) ) {

          update_post_meta($translated_pid, '_wp_attachment_image_alt', sanitize_text_field($request['alt_text']));
        }
      }
    }
  }


  /**
   * Get translated ids
   *
   * @param $post_id
   *
   * @return mixed|void
   */
  public static function get_translated_ids ($post_id) {

    $lang_array = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code');

    $translated_ids = array();

    if( $lang_array !== NULL ){

      foreach ( $lang_array as $lang ) {

        $translated_pid = apply_filters('wpml_object_id', $post_id, 'attachment', false, $lang['language_code']);

        if ($post_id !== null && $translated_pid !== $post_id ) {
          $translated_ids[$lang['language_code']] = $translated_pid;
        }
      }
    }

    return $translated_ids;
  }


  /**
   * Get translate id
   *
   * @param $post_id
   * @param $post_type
   * @param $original
   * @return mixed|void
   */
  public static function get_translate_id ( $post_id, $post_type, $original = false ) {

    return apply_filters( 'wpml_object_id', $post_id, $post_type, $original );
  }

}
