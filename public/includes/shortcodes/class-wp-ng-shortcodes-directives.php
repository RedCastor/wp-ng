<?php
/**
 * Directive Shortcodes
 *
 * @author     RedCastor <team@redcastor.io>
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes/shortcodes
 * @version     1.3.3
 */
class Wp_Ng_Shortcodes_Directive {



  /**
   * Shortcode generic directive
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function directive( $atts, $content = '' ) {

    $html = '';

    $_atts = shortcode_atts( array(
      'tag'   => 'div',
      'id'    => null,
      'class' => null,
      'template' => '',
      'template_path' => 'directives/',
      'load'  => '',
    ), $atts, 'ng-directive' );

    extract($_atts);

    //Add More attribute not describe. (example for auto focus, or validation)
    $extra_attr = array_diff_key($atts, $_atts);

    //Default Attributes
    $_attr_directive['id'] = $id;
    $_attr_directive['class'] = $class;

    $_attr_directive = wp_parse_args($_attr_directive, $extra_attr);

    $attr_directive = array();

    //Parse attributes for display
    foreach ($_attr_directive as $attribute => $value) {
      if ( $value !== null) {
        if ( is_numeric($attribute) ) {
          $attr_directive[] = (string) $value;
        }
        else {
          $attr_directive[] = sprintf('%s="%s"', $attribute, htmlspecialchars($value, ENT_QUOTES));
        }
      }
    }

    //Data Template
    $data = array(
      'tag'   => $tag,
      'attrs' => $attr_directive,
      'template' => $template,
      'load'  => array_map('trim', explode(',', $load)),
    );

    $template_path .= !empty($template) ? "{$template}.php" : 'default.php';
    $data['content'] = $content ? do_shortcode( $content ) : '';

    $html = wp_ng_get_template( $template_path, null, $data, false );

    return $html;
  }


  /**
   * Shortcode webicon
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function webicon( $atts ) {

    $atts = wp_parse_args( $atts, array(
      'template' => 'default',
      'tag'  => 'webicon',
      'icon' => null,
    ) );

    //Set default folder template
    $atts['template'] = 'webicon/' . $atts['template'];

    //Is icon set.
    if ($atts['icon']) {
      switch ($atts['tag']) {
        case 'webicon':
          break;
        case 'div':
          $atts['data-webicon'] = $atts['icon'];
          unset($atts['icon']);
          break;
        default:
          $atts['webicon'] = $atts['icon'];
          unset($atts['icon']);
      }

      $atts['load'] = 'webicon';

      return self::directive( $atts );
    }

    return '';
  }


  /**
   * Shortcode button
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function button( $atts, $content = '' ) {

    $html = '';

    $atts = wp_parse_args( $atts, array(
      'template' => 'default',
      'tag'  => 'button',
      'type' => null,
      'content' => '',
      'content_class' => ''
    ) );

    //Set default folder template
    $atts['template'] = 'button/' . $atts['template'];

    //Parse shortcode attributes.
    $atts_linked = array(
      'options',
    );

    $atts_parser = new Wp_Ng_Shortcode_Parser();
    $button = $atts_parser->parse($atts, $atts_linked);

    $button_content = wp_ng_shortcode_decode($atts['content']);
    $button_content_class = $atts['content_class'];
    $type = $atts['type'];

    unset($atts['content']);
    unset($atts['content_class']);
    unset($atts['type']);

    foreach ($atts as $att => $value) {
      if (strpos($att, 'options') === 0) {
        unset($atts[$att]);
      }
    }

    $button_html = self::directive( $atts, $content );

    if (!empty($button_content) && $type ) {

      $data = array(
        'button'  => array(
          'toggle' => $button_html,
          'content' => apply_filters('wp_ng_the_content', $button_content),
          'content_class' => $button_content_class,
        ),
        'options' => $button['options'],
      );

      $button_html = wp_ng_get_template( "directives/button/type/{$type}.php", null, $data, false );
    }

    return $button_html;
  }


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
      'template'  => '',
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
    ), $atts, 'ng-socialshare' );

    //Add More attribute not describe.
    $extra_attr = array_diff_key($atts, $_atts);

    if ($_atts['provider']) {

      $_attr = array_merge($_atts, $extra_attr);
      $template = $_attr['template'];
      $class    = $_attr['class'];

      unset($_attr['template']);
      unset($_attr['content']);
      unset($_attr['class']);

      if ( !empty( $_atts['content'] ) ) {
        $content = esc_html( $_atts['content']  ) . ( empty( $content ) ? '' : ' ' ) . $content;
      }

      if ($content) {
        $data = array(
          'socialshare' => $_attr,
          'template'    => $template,
          'class'       => $class,
          'content'     => $content ? do_shortcode( $content ) : '',
        );

        $template_path = !empty($template) ? "directives/social/{$template}.php" : 'directives/social/720kb.socialshare.php';

        $html .= wp_ng_get_template( $template_path, null, $data, false );
      }
    }

    return $html;
  }


  /**
   * Shortcode alert
   *
   * @param $atts
   * @param string $content
   *
   * @return string
   */
  public static function alert( $atts, $content = '' ) {

    $html = '';

    extract( shortcode_atts( array(
      'theme'   => '',
      'class'   => '',
      'scope'   => 'alerts',
    ), $atts ) );

    switch ( $theme ) {
      case 'bootstrap':
        $html = sprintf( '<div uib-alert class="%1$s" data-ng-repeat="alert in %2$s" data-ng-class="{\'alert-danger\': alert.type == \'alert\', \'alert-success\': alert.type == \'success\'}">{{alert.msg}}</div>', esc_attr($class), esc_attr($scope) );
        break;
      case 'foundation':
        $html = sprintf( '<div class="callout %1$s" data-ng-repeat="alert in %2$s" data-ng-class="alert.type">{{alert.msg}}</div>', esc_attr($class), esc_attr($scope) );
        break;
      default:
        $html = sprintf( '<p class="%1$s" data-ng-repeat="alert in %2$s" data-ng-class="{\'has-error\': alert.type == \'alert\', \'has-success\': alert.type == \'success\'}" >{{alert.msg}}</p>', esc_attr($class), esc_attr($scope) );
    }

    if ( $content ) {
      $html .= sprintf( '<div data-ng-hide="%1$s.length > 0 && %1$s[0].type == \'success\'" >', esc_attr($scope) );
      $html .= do_shortcode( $content );
      $html .= '</div>';
    }

    return $html;
  }

}
