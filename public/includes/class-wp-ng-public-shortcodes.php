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
      'rcGallery'               => 'Wp_Ng_Shortcodes_Gallery::rc_gallery',
      'angular-owl-carousel-2'  => 'Wp_Ng_Shortcodes_Gallery::owl2',
      'slick'                   => 'Wp_Ng_Shortcodes_Gallery::slick',
      'ui.swiper'               => 'Wp_Ng_Shortcodes_Gallery::swiper',
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

    add_shortcode( 'ng-directive',    'Wp_Ng_Shortcodes_Directive::directive' );
    add_shortcode( 'ng-webicon',      'Wp_Ng_Shortcodes_Directive::webicon' );
    add_shortcode( 'ng-button',       'Wp_Ng_Shortcodes_Directive::button' );
    add_shortcode( 'ng-socialshare',  'Wp_Ng_Shortcodes_Directive::socialshare' );
    add_shortcode( 'ng-alert',        'Wp_Ng_Shortcodes_Directive::alert' );

    add_shortcode( 'ng-accordion',     'Wp_Ng_Shortcodes_Accordion::ng_accordion' );
    add_shortcode( 'ng-accordion-item','Wp_Ng_Shortcodes_Accordion::ng_accordion_item' );
    add_shortcode( 'ng-accordion-header','Wp_Ng_Shortcodes_Accordion::ng_accordion_header' );
    add_shortcode( 'ng-accordion-content','Wp_Ng_Shortcodes_Accordion::ng_accordion_content' );

    add_shortcode( '_ng-accordion',     'Wp_Ng_Shortcodes_Accordion::_ng_accordion' );
    add_shortcode( '_ng-accordion-item','Wp_Ng_Shortcodes_Accordion::ng_accordion_item' );
    add_shortcode( '_ng-accordion-header','Wp_Ng_Shortcodes_Accordion::ng_accordion_header' );
    add_shortcode( '_ng-accordion-content','Wp_Ng_Shortcodes_Accordion::ng_accordion_content' );

    add_shortcode( 'ng-tabset',        'Wp_Ng_Shortcodes_Tabs::ng_tabset' );
    add_shortcode( 'ng-tab',           'Wp_Ng_Shortcodes_Tabs::ng_tab' );
    add_shortcode( 'ng-tab-header',    'Wp_Ng_Shortcodes_Tabs::ng_tab_header' );
    add_shortcode( 'ng-tab-content',   'Wp_Ng_Shortcodes_Tabs::ng_tab_content' );

    add_shortcode( '_ng-tabset',        'Wp_Ng_Shortcodes_Tabs::_ng_tabset' );
    add_shortcode( '_ng-tab',           'Wp_Ng_Shortcodes_Tabs::ng_tab' );
    add_shortcode( '_ng-tab-header',    'Wp_Ng_Shortcodes_Tabs::ng_tab_header' );
    add_shortcode( '_ng-tab-content',   'Wp_Ng_Shortcodes_Tabs::ng_tab_content' );

    add_shortcode( 'ng-dialog',       'Wp_Ng_Shortcodes_Dialog::ng_dialog' );
    add_shortcode( 'rc-dialog',       'Wp_Ng_Shortcodes_Dialog::rc_dialog' );

    add_shortcode( 'ui-leaflet',      'Wp_Ng_Shortcodes_Map::leaflet' );
    add_shortcode( 'ui-leaflet-google','Wp_Ng_Shortcodes_Map::leaflet_google' );

    add_shortcode( 'ng-gallery',      'Wp_Ng_Shortcodes_Gallery::ng_gallery' );
    add_shortcode( 'rc-gallery',      'Wp_Ng_Shortcodes_Gallery::rc_gallery' );
    add_shortcode( 'rc-gallery-unitegallery','Wp_Ng_Shortcodes_Gallery::rc_gallery_unitegallery' );
    add_shortcode( 'rc-gallery-galleria', 'Wp_Ng_Shortcodes_Gallery::rc_gallery_galleria' );
    add_shortcode( 'ng-gallery-owl2',     'Wp_Ng_Shortcodes_Gallery::owl2' );
    add_shortcode( 'ng-gallery-slick',    'Wp_Ng_Shortcodes_Gallery::slick' );
    add_shortcode( 'ng-gallery-swiper',   'Wp_Ng_Shortcodes_Gallery::swiper' );

    add_shortcode( 'ng-social-share-links', 'Wp_Ng_Shortcodes_Social_Share::links' );

    add_shortcode( 'ng-pageslide',     'Wp_Ng_Shortcodes_Pageslide::ng_pageslide' );
    add_shortcode( 'ng-pageslide-button','Wp_Ng_Shortcodes_Pageslide::ng_pageslide_button' );
    add_shortcode( 'ng-pageslide-content','Wp_Ng_Shortcodes_Pageslide::ng_pageslide_content' );


    //Filter default shortcode gallery
    add_filter('post_gallery', 'Wp_Ng_Public_Shortcodes::post_gallery', 10, 3);
  }


  private static function load_dependencies() {

    /**
     * Include shortcodes directive class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-directives.php';

    /**
     * Include shortcode form class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-form.php';

    /**
     * Include shortcode accordion class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-accordion.php';

    /**
     * Include shortcode tabs class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-tabs.php';

    /**
     * Include shortcode dialog class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-dialog.php';

    /**
     * Include shortcode leaflet class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-map.php';

    /**
     * Include shortcode gallery class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-gallery.php';

    /**
     * Include shortcode pageslide class
     */
    require_once dirname( __FILE__ ) . '/shortcodes/class-wp-ng-shortcodes-pageslide.php';

  }



  /**
   * Filter shortcode wp gallery [gallery]
   *
   * @param $output
   * @param $atts
   * @param $instance
   * @return mixed
   */
  public static function post_gallery( $output, $attr, $instance ) {

    if ( empty($output) && isset($attr['ng_module']) ) {

      $post = get_post();

      $html5 = current_theme_supports( 'html5', 'gallery' );
      $atts = wp_parse_args($attr, array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'itemtag'    => $html5 ? 'figure'     : 'dl',
        'icontag'    => $html5 ? 'div'        : 'dt',
        'captiontag' => $html5 ? 'figcaption' : 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => '',
        'link'       => ''
      ));

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
