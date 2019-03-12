<?php
/**
 * Tabs Shortcodes
 *
 * @author     RedCastor <team@redcastor.io>
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes/shortcodes
 * @version     1.6.5
 */
class Wp_Ng_Shortcodes_Tabs
{


  private static $load = 'vTabs';
  private static $prefix = '';
  private static $headers = '';
  private static $header_index = 0;
  private static $active_index = 0;


  /**
   * Shortcode tabs
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function ng_tabset($atts, $content = '')
  {

    $html = '';

    $atts = wp_parse_args($atts, array(
      'template' => 'default',
      'tag' => 'v-tabset',
      'class' => '',
      'direction' => 'horizontal',
      'active' => 0,
      'load' => empty(self::$load) ? 'vTabs' : self::$load,
    ));

    self::$headers = '';
    self::$header_index = 0;
    self::$active_index = intval($atts['active']);
    self::$load = $atts['load'];

    //Set default folder template
    $atts['template'] = (!empty(self::$load) ? self::$load . '/' : '') . $atts['template'];

    //Construct vTabs html
    if ($atts['tag'] === 'v-tabset') {

      $tab_active = "tab_" . strval(dechex(crc32(uniqid()))) . '_index';

      $content = do_shortcode($content);

      $header = sprintf('<v-tabs class="vTabs--default" %s active="%s">%s</v-tabs>', $atts['direction'],$tab_active, self::$headers);
      $content = sprintf('<v-pages class="vPages--default" active="%s">%s</v-pages>', $tab_active, $content);

      //Wrapper header if vertical
      if ($atts['direction'] == 'vertical') {
        $header = '<span class="wp-ng-inline vTabs-vertical">' . $header . '</span>';
        $content = '<span class="wp-ng-inline vTabs-vertical">' . $content . '</span>';
      }


      $atts['data-ng-init'] = sprintf("%s=%s", $tab_active, self::$active_index);

      unset($atts['direction']);
      unset($atts['active']);
    }

    $html = Wp_Ng_Shortcodes_Directive::directive( $atts, ($header . $content) );

    return $html;
  }


  /**
   * Shortcode sub tabs
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function _ng_tabset( $atts, $content = '' ) {

    self::$prefix = '_';

    $html = self::ng_tabset($atts, $content);

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
  public static function ng_tab( $atts, $content = '' ) {

    $atts = wp_parse_args( $atts, array(
      'title' => ''
    ) );

    $header_shortcode = self::$prefix . 'ng-tab-header';
    $content_shortcode = self::$prefix . 'ng-tab-content';
    $tab_header = '';
    $match_header = null;

    //Extract header
    if (preg_match_all("#\[".$header_shortcode."(.*)/".$header_shortcode."]#iUs", $content, $match_content) && !empty($match_content[0][0])) {
      $tab_header = $match_content[0][0];
      $content = str_replace($tab_header, '', $content);
      $content = wp_ng_trim_all($content, "\\x09", '');
    }

    if ( !has_shortcode( $content, $content_shortcode ) ) {
      $content = "[{$content_shortcode}]{$content}[/{$content_shortcode}]";
    }

    if ( !empty($atts['title']) ) {
      $tab_header = "[{$header_shortcode}]{$atts['title']}[/{$header_shortcode}]";
    }

    if ( isset($atts['active']) || in_array('active', $atts) ) {
      self::$active_index = self::$header_index;
    }
    else {
      self::$header_index++;
    }

    self::$headers .= $tab_header;

    unset($atts['title']);
    unset($atts['active']);

    return $content;
  }



  /**
   * Shortcode accordion header
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function ng_tab_header( $atts, $content = '' ) {

    $html = '';

    $atts = wp_parse_args( $atts, array(
      'template' => '',
      'tag'  => 'v-tab',
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
  public static function ng_tab_content( $atts, $content = '' ) {

    $html = '';

    $atts = wp_parse_args( $atts, array(
      'template' => '',
      'tag'  => 'v-page',
    ) );

    $html = Wp_Ng_Shortcodes_Directive::directive( $atts, apply_filters('wp_ng_the_content', $content) );

    return $html;
  }

}
