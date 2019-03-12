<?php
/**
 * Pageslide Shortcode
 *
 * @author     RedCastor <team@redcastor.io>
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes/shortcodes
 * @version     1.7.5
 */
class Wp_Ng_Shortcodes_Pageslide {

  private static $ps_open = '';

  /**
   * Shortcode pageslide
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function ng_pageslide( $atts, $content = '' ) {

    $html = '';
    self::$ps_open = '';

    $atts = wp_parse_args( $atts, array(
      'template' => 'default',
      'tag'  => '',
      'load' => '',
      'button' => '',
    ) );

    $atts['load'] = empty($atts['load']) ? 'pageslide-directive' : $atts['load'];

    $button_shortcode = 'ng-pageslide-button';
    $content_shortcode = 'ng-pageslide-content';
    $pageslide_button = '';
    $match_button = null;

    //Extract Button
    if (preg_match_all("#\[".$button_shortcode."(.*)/".$button_shortcode."]#iUs", $content, $match_content) && !empty($match_content[0][0])) {
      $pageslide_button = $match_content[0][0];
      $content = str_replace($pageslide_button, '', $content);
      $content = wp_ng_trim_all($content, "\\x09", '');
    }

    if ( !has_shortcode( $content, $content_shortcode ) ) {
      $content = "[{$content_shortcode}]{$content}[/{$content_shortcode}]";
    }

    if ( !empty($atts['button']) ) {
      $pageslide_button = "[{$button_shortcode}]{$atts['button']}[/{$button_shortcode}]";
    }

    $content = $pageslide_button . $content;
    unset($atts['button']);

    //Set default folder template
    $atts['template'] = $atts['load'] . '/' . $atts['template'];

    $html = Wp_Ng_Shortcodes_Directive::directive( $atts, $content );

    return $html;
  }


  /**
   * Shortcode pageslide button
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function ng_pageslide_button( $atts, $content = '' ) {

    $html = '';

    $atts = wp_parse_args( $atts, array(
      'click' => '',
    ) );

    if ( empty(self::$ps_open) ) {
      self::$ps_open  = empty($atts['click']) ? 'ps_open_' . strval(dechex(crc32(uniqid()))) : $atts['click'];
    }

    if ( !isset($atts['ng-click']) ) {
      $atts['ng-click'] = self::$ps_open . '=!' . self::$ps_open;
      $atts['ng-class'] = sprintf("{'is-active':%s}", self::$ps_open);
    }

    unset($atts['click']);

    $html = Wp_Ng_Shortcodes_Directive::button( $atts, $content );

    return $html;
  }


  /**
   * Shortcode pageslide content
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function ng_pageslide_content( $atts, $content = '' ) {

    $html = '';

    $atts = wp_parse_args( $atts, array(
      'template'  => '',
      'tag'       => 'pageslide',
      'ps-open'   => '',
      'ps-body-class' => 'true',
      'ps-side' => 'left',
      'ps-auto-close' => 'true',
      'ps-key-listener' => 'true',
      'ps-click-outside' => 'true',
      'ps-speed' => '0.4',
      'ps-push' => 'false',
      'ps-size' => '250px',
      'ps-zindex' => '1100',
    ) );

    $atts['ps-open']  = empty($atts['ps-open']) ? self::$ps_open : $atts['ps-open'];

    $html = Wp_Ng_Shortcodes_Directive::directive( $atts, apply_filters('wp_ng_the_content', $content) );

    //Reset open ng var
    self::$ps_open = '';

    return $html;
  }

}
