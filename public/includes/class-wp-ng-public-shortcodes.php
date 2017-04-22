<?php

/**
 * The public-facing includes functionality of the plugin.
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
class Wp_Ng_Public_Shortcodes {

  /**
   * Init shortcodes.
   */
  public static function init() {

    self::load_dependencies();

    add_shortcode( 'ng-form-input', 'Wp_Ng_Shortcodes_Form::input' );
    add_shortcode( 'ng-form-checkbox', 'Wp_Ng_Shortcodes_Form::checkbox' );
    add_shortcode( 'ng-form-select', 'Wp_Ng_Shortcodes_Form::select' );
    add_shortcode( 'ng-form-submit','Wp_Ng_Shortcodes_Form::submit' );
    add_shortcode( 'ng-form-locale','Wp_Ng_Shortcodes_Form::locale' );

    add_shortcode( 'ng-alert',       'Wp_Ng_Shortcodes_Directive::alert' );

    add_shortcode( 'ng-socialshare','Wp_Ng_Shortcodes_720kbSocialShare::socialshare' );
  }


  private static function load_dependencies() {

    /**
     * Include shortcode form class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-directive.php';

    /**
     * Include shortcode form class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-form.php';

    /**
     * Include shortcode 720kb Social Share class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-720kb.socialshare.php';

  }

}
