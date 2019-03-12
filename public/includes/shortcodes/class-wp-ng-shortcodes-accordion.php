<?php
/**
 * Accordion Shortcodes
 *
 * @author     RedCastor <team@redcastor.io>
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes/shortcodes
 * @version     1.6.5
 */
class Wp_Ng_Shortcodes_Accordion {


  private static $load = 'vAccordion';
  private static $prefix = '';


  /**
   * Shortcode accordion
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function ng_accordion( $atts, $content = '' ) {

    $html = '';

    $atts = wp_parse_args( $atts, array(
      'template' => 'default',
      'tag'  => 'v-accordion',
      'class' => 'vAccordion--default',
      'load' => empty(self::$load) ? 'vAccordion' : self::$load,
    ) );

    self::$load = $atts['load'];

    //Set default folder template
    $atts['template'] = (!empty(self::$load) ? self::$load . '/' : '') . $atts['template'];

    $html = Wp_Ng_Shortcodes_Directive::directive( $atts, $content );

    return $html;
  }

  /**
   * Shortcode sub accordion
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function _ng_accordion( $atts, $content = '' ) {

    self::$prefix = '_';

    $html = self::ng_accordion($atts, $content);

    self::$prefix = '';

    return $html;
  }

  /**
   * Shortcode accordion item
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function ng_accordion_item( $atts, $content = '' ) {

    $html = '';

    $atts = wp_parse_args( $atts, array(
      'template' => '',
      'tag'  => 'v-pane',
      'title' => '',
    ) );


    //Set title and content
    if ( $atts['tag'] === 'v-pane' ) {

      $header_shortcode = self::$prefix . 'ng-accordion-header';
      $content_shortcode = self::$prefix . 'ng-accordion-content';
      $accordion_header = '';
      $match_header = null;

      //Extract header
      if (preg_match_all("#\[".$header_shortcode."(.*)/".$header_shortcode."]#iUs", $content, $match_content) && !empty($match_content[0][0])) {
        $accordion_header = $match_content[0][0];
        $content = str_replace($accordion_header, '', $content);
        $content = wp_ng_trim_all($content, "\\x09", '');
      }

      if ( !has_shortcode( $content, $content_shortcode ) ) {
        $content = "[{$content_shortcode}]{$content}[/{$content_shortcode}]";
      }

      if ( !empty($atts['title']) ) {
        $accordion_header = "[{$header_shortcode}]{$atts['title']}[/{$header_shortcode}]";
      }

      $content = $accordion_header . $content;
      unset($atts['title']);
    }

    $html = Wp_Ng_Shortcodes_Directive::directive( $atts, $content );

    return $html;
  }


  /**
   * Shortcode accordion header
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function ng_accordion_header( $atts, $content = '' ) {

    $html = '';

    $atts = wp_parse_args( $atts, array(
      'template' => '',
      'tag'  => 'v-pane-header',
    ) );

    $html = Wp_Ng_Shortcodes_Directive::directive( $atts, $content );

    return $html;
  }


  /**
   * Shortcode accordion header
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function ng_accordion_content( $atts, $content = '' ) {

    $html = '';

    $atts = wp_parse_args( $atts, array(
      'template' => '',
      'tag'  => 'v-pane-content',
    ) );

    $html = Wp_Ng_Shortcodes_Directive::directive( $atts, apply_filters('wp_ng_the_content', $content) );

    return $html;
  }

}
