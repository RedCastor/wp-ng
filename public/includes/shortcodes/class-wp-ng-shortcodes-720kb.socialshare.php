<?php
/**
 * 720kb Social Share Shortcodes
 *
 * @author     RedCastor <team@redcastor.io>
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes/shortcodes
 * @version     1.3.3
 */
class Wp_Ng_Shortcodes_720kbSocialShare {


  /**
   * Shortcode socialshare
   *
   * @param $atts
   *
   * @return string
   */
  public static function socialshare( $atts, $content = '' ) {

    $html = '';

    $_atts = shortcode_atts( array(
      'content'   => '',
      'class'     => '',
      'provider'  => '',
      'text'      => '',
      'hashtags'  => '',
      'url'       => '',
      'title'     => '',
      'description' => '',
      'media'     => '',
      'type'      => 'sharer',
      'via'       => '',
      'required'  => '',
      'to'        => '',
      'from'      => '',
      'ref'       => '',
      'display'   => '',
      'quote'     => '',
      'source'    => '',
      'caption'   => '',
      'redirect-uri' => '',
      'mobileiframe' => false,
    ), $atts );

    //Add More attribute not describe.
    $extra_attr = array_diff_key($atts, $_atts);

    if ($_atts['provider']) {

      $_attr = array_merge($_atts, $extra_attr);

      unset($_attr['content']);
      unset($_attr['class']);

      if ( !empty( $_atts['content'] ) ) {
        $content = esc_html( $_atts['content']  ) . ( empty( $content ) ? '' : ' ' ) . $content;
      }

      if ($content) {
        foreach ($_attr as $attribute => $value) {
          if ( !empty($value) && $value !== 'false') {
            $attr[] = sprintf('socialshare-%s="%s"', $attribute, esc_attr($value));
          }
        }

        $html = sprintf( '<a href="#" class="socialshare %1$s" socialshare %2$s >%3$s</a>', esc_attr($_atts['class']), implode(' ', $attr), do_shortcode( $content ) );
      }
    }

    return $html;
  }

}
