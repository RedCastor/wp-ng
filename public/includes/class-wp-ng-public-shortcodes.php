<?php

/**
 * The public-facing includes functionality shortcodes.
 *
 * @link       http://redcastor.io
 * @since      1.3.0
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
   * Map angular module name with shortcode method or function.
   *
   * @param $module
   * @return bool|mixed
   */
  public static function map_modules_gallery () {

    $modules_map = array(
      'rcGallery' => 'Wp_Ng_Shortcodes_Gallery::rc_gallery',
      'angular-owl-carousel-2' => 'Wp_Ng_Shortcodes_Gallery::owl2',
    );

    return apply_filters('wp_ng_shortcode_map_modules_gallery', $modules_map);
  }


  /**
   * Init shortcodes.
   */
  public static function init() {

    self::load_dependencies();

    add_shortcode( 'ng-form-input',   'Wp_Ng_Shortcodes_Form::input' );
    add_shortcode( 'ng-form-checkbox','Wp_Ng_Shortcodes_Form::checkbox' );
    add_shortcode( 'ng-form-radio',   'Wp_Ng_Shortcodes_Form::radio' );
    add_shortcode( 'ng-form-select',  'Wp_Ng_Shortcodes_Form::select' );
    add_shortcode( 'ng-form-submit',  'Wp_Ng_Shortcodes_Form::submit' );
    add_shortcode( 'ng-form-locale',  'Wp_Ng_Shortcodes_Form::locale' );
    add_shortcode( 'ng-form-token',   'Wp_Ng_Shortcodes_Form::token' );
    add_shortcode( 'ng-form-media-select','Wp_Ng_Shortcodes_Form::media_select' );

    add_shortcode( 'ng-alert',          'Wp_Ng_Shortcodes_Directive::alert' );

    add_shortcode( 'ng-socialshare',    'Wp_Ng_Shortcodes_720kbSocialShare::socialshare' );

    add_shortcode( 'ui-leaflet',        'Wp_Ng_Shortcodes_Map::leaflet' );
    add_shortcode( 'ui-leaflet-google', 'Wp_Ng_Shortcodes_Map::leaflet_google' );

    add_shortcode( 'ng-gallery',        'Wp_Ng_Shortcodes_Gallery::ng_gallery' );
    add_shortcode( 'rc-gallery',        'Wp_Ng_Shortcodes_Gallery::rc_gallery' );
    add_shortcode( 'rc-gallery-unitegallery', 'Wp_Ng_Shortcodes_Gallery::rc_gallery_unitegallery' );
    add_shortcode( 'rc-gallery-galleria',     'Wp_Ng_Shortcodes_Gallery::rc_gallery_galleria' );
    add_shortcode( 'ng-gallery-owl2',     'Wp_Ng_Shortcodes_Gallery::owl2' );


    if ( wp_ng_is_admin_gallery() ) {

      add_filter('post_gallery', 'Wp_Ng_Public_Shortcodes::post_gallery', 10, 3);
    }
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

    /**
     * Include shortcode leaflet class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-map.php';

    /**
     * Include shortcode gallery class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-gallery.php';

  }



  /**
   * Filter shortcode wp gallery [gallery]
   *
   * @param $output
   * @param $atts
   * @param $instance
   * @return mixed
   */
  public static function post_gallery( $output, $atts, $instance ) {

    if ( empty($output) && isset($atts['ng_module']) ) {

      if ( !isset($atts['id']) ) {
        $post = get_post();
        $atts['id'] = $post ? $post->ID : 0;
      }


      $modules_map = self::map_modules_gallery();
      $func_shortcode = !empty($modules_map[$atts['ng_module']]) ? $modules_map[$atts['ng_module']] : false;

      if ($func_shortcode && is_callable($func_shortcode)) {

        $atts['template'] = !empty($atts['template']) ? $atts['template'] : $atts['ng_module'];

        $output = call_user_func($func_shortcode, $atts, '');
      }
      else {
        $output = Wp_Ng_Shortcodes_Gallery::ng_gallery( $atts, '' );
      }
    }

    return $output;
  }

}
