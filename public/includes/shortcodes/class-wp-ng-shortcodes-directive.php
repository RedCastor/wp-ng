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
        $html = sprintf( '<alert class="%1$s" data-ng-repeat="alert in %2$s" type="alert.type">{{alert.msg}}</alert>', esc_attr($class), esc_attr($scope) );
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
