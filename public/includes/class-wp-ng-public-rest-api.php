<?php

/**
 * The public-facing includes functionality rest api.
 *
 * @link       http://redcastor.io
 * @since      1.0.0
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
class Wp_Ng_Public_Rest_Api {


  /**
   * Initialize Rest API
   */
  static public function init() {

    add_action( 'init',                         array( __CLASS__, 'remove_option_rewrite_rules' ), 10 );
    add_action( 'rest_api_init',                array( __CLASS__, 'set_language'), 1 );

    add_filter( 'rest_authentication_errors',   array( __CLASS__, 'cookie_check_errors'), 90 );
    add_filter( 'rest_request_after_callbacks', array( __CLASS__, 'rest_request_after_callbacks'), 10, 3 );
    add_filter( 'rest_post_dispatch',           array( __CLASS__, 'rest_post_dispatch'), 10, 3);
  }



  /**
   * Check for errors when using cookie-based authentication.
   *
   * WordPress' built-in cookie authentication is always active
   * for logged in users. However, the API has to check nonces
   * for each request to ensure users are not vulnerable to CSRF.
   *
   * @since    1.0.0
   *
   * @global mixed $wp_rest_auth_cookie
   *
   * @param WP_Error|mixed $result Error from another authentication handler,
   *                               null if we should handle it, or another
   *                               value if not
   * @return WP_Error|mixed|bool WP_Error if the cookie is invalid, the $result,
   *                             otherwise true.
   */
  static public function cookie_check_errors( $result ) {
    if ( ! empty( $result ) ) {
      return $result;
    }

    global $wp_rest_auth_cookie, $wp_rest_server;

    /*
		 * Is cookie authentication being used? (If we get an auth
		 * error, but we're still logged in, another authentication
		 * must have been used.)
		 */
    if ( true !== $wp_rest_auth_cookie && is_user_logged_in() ) {
      return $result;
    }


    // Is there a nonce?
    $nonce = null;
    if ( isset( $_SERVER['HTTP_X_WP_NG_NONCE'] ) ) {
      $nonce = $_SERVER['HTTP_X_WP_NG_NONCE'];
    }

    if ( null === $nonce ) {
      return $result;
    }

    // Check the nonce.
    $result = wp_ng_verify_rest_nonce( $nonce );


    if ( ! $result ) {

      return new WP_Error( 'rest_cookie_invalid_nonce', __( 'Cookie nonce is invalid', 'wp-ng' ), array( 'status' => 406 ) );
    }

    return true;
  }

  /**
   * After rest request callback
   * @param $response
   * @param $handler
   * @param $request
   *
   * @return mixed
   */
  static public function rest_request_after_callbacks($response, $handler, $request) {

    if ( $response instanceof WP_HTTP_Response ) {

      // Update a refreshed nonce in header.
      $response->header( 'X-WP-NG-Nonce', wp_create_nonce( 'wp_ng_rest' ), true );
      $response->header( 'X-WP-Nonce', wp_create_nonce( 'wp_rest' ), true );
    }

    return $response;
  }


  /**
   * Set the wpml language based on header param
   */
  static public function set_language() {

    $is_wpml = false;
    $language_code = apply_filters('wp_ng_current_language', 'en');

    if (isset($_SERVER['HTTP_X_WP_NG_LANG']) && function_exists('icl_object_id')) {
      global $sitepress;

      $default_language = $sitepress->get_default_language();
      $active_langs = $sitepress->get_active_languages();
      $hidden_lang_codes = $sitepress->get_setting('hidden_languages', array());
      $active_lang_codes = array_keys($active_langs);
      $legal_lang_codes = array_merge($hidden_lang_codes, $active_lang_codes);


      $cur_lang = $_SERVER['HTTP_X_WP_NG_LANG'];

      if (!in_array($cur_lang, $legal_lang_codes)) {
        $cur_lang = $default_language;
      }

      $language_code = $cur_lang;

      $sitepress->switch_lang($language_code);

      $is_wpml = true;
    }

    do_action('wp_ng_rest_set_language', $language_code, $is_wpml);
  }

  /**
   * Remove wpml rewrite rules
   */
  static function remove_option_rewrite_rules () {

    if ( function_exists('icl_object_id') ) {
      global $sitepress;

      $current_language = $sitepress->get_current_language();
      $default_language = $sitepress->get_default_language();
      $directory_for_default_language = false;
      $setting_url = $sitepress->get_setting('urls');
      if ($setting_url) {
        $directory_for_default_language = $setting_url['directory_for_default_language'];
      }

      //remove rewrite rules filtering for PayPal IPN url
      if (isset($_SERVER['HTTP_X_WP_NG_LANG']) && ($current_language != $default_language || $directory_for_default_language)) {
        remove_filter('option_rewrite_rules', array($sitepress, 'rewrite_rules_filter'));
      }
    }
  }


  /**
   * Pre Serve request
   *
   * @param $result
   * @param $rest_server
   * @param $request
   * @return mixed
   */
  static function rest_post_dispatch ($result, $rest_server, $request) {

    //Set Fresh nonce on GET and error or success
    if ( !$result->is_error() || ($result->is_error() && $request->get_method() == $rest_server::READABLE) ) {

      $result->header( 'X-WP-NG-Nonce', wp_ng_create_rest_nonce(), true );
    }

    return $result;
  }


}
