<?php
/**
 * Dialog Shortcodes
 *
 * @author     RedCastor <team@redcastor.io>
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes/shortcodes
 * @version     1.3.3
 */
class Wp_Ng_Shortcodes_Dialog {


  /**
   * Shortcode dialog
   *
   * @param $atts
   * @param $content
   *
   * @return string
   */
  public static function ng_dialog( $atts, $content = '' ) {

    $html = '';

    $_atts = shortcode_atts( array(
      'id'        => null,
      'template'  => '',
      'type'      => '',
      'theme'     => '',
      'class'     => '',
      'content'   => '',
      'content_class' => '',
      'load'      => 'ngDialog,rcDialog',
    ), $atts, 'ng-dialog' );


    //Parse shortcode dialog attributes.
    $atts_dialog = array(
      'data',
      'options',
    );

    $atts_parser = new Wp_Ng_Shortcode_Parser();
    $dialog = $atts_parser->parse($atts, $atts_dialog);
    $id = empty($_atts['id']) ? 'dialog_' . strval(dechex(crc32(uniqid()))) : $_atts['id'];
    $template = $_atts['template'];
    $type = !empty($_atts['type']) ? $_atts['type'] : '';
    $theme = $_atts['theme'];
    $class = $_atts['class'];
    $dialog_content = wp_ng_shortcode_decode($_atts['content']);
    $dialog_content_class = $_atts['content_class'];
    $load = array_map('trim', explode(',', $_atts['load']));

    //Data Template
    $data = array(
      'dialog'      => array(
        'content' => apply_filters('wp_ng_the_content', $dialog_content),
        'content_class' => $dialog_content_class,
      ),
      'options'     => $dialog['options'],
      'data'        => $dialog['data'],
      'type'        => $type,
      'id'          => $id,
      'template_id' => sprintf('template_%s.html', $id ),
      'template'    => $template,
      'theme'       => $theme,
      'class'       => $class,
      'content'     => $content ? do_shortcode( $content ) : '',
      'load'        => $load
    );

    $template_button_path = !empty($template) ? "dialogs/{$template}/button.php" : 'dialogs/rcDialog/button.php';
    $template_content_path = !empty($template) && !empty($type) ? "dialogs/{$template}/{$type}-content.php" : 'dialogs/rcDialog/dialog-content.php';

    $html .= wp_ng_get_template( $template_button_path, null, $data, false );
    $html .= wp_ng_get_template( $template_content_path, null, $data, false );

    return $html;
  }


  /**
   * Shortcode [rc-dialog]
   *
   * @param $atts
   *
   * @return string
   */
  public static function rc_dialog( $atts, $content = '' ) {

    if (!empty($atts['options'])) {
      $atts['options'] = wp_ng_json_decode($atts['options']);
    }
    else {
      $atts['options'] = array();
    }

    //Merge rcd with default attribute for rc-dialog
    if ( !empty($atts['rcd-data']) ) {
      $atts['data'] = $atts['rcd-data'];
      unset( $atts['rcd-data']);
    }

    if ( !empty($atts['rcd-id']) ) {
      $atts['id'] = $atts['rcd-id'];
      unset( $atts['rcd-id']);
    }

    if ( !empty($atts['rcd-open']) ) {
      $atts['type'] = $atts['rcd-open'];
      unset( $atts['rcd-open']);
    }

    if ( !empty($atts['rcd-template-url']) ) {
      unset( $atts['rcd-template-url']);
    }

    if ( !empty($atts['rcd-template']) ) {
      unset( $atts['rcd-template']);
    }

    if ( !empty($atts['rcd-size']) ) {
      $atts['options']['size'] = $atts['rcd-size'];
      unset( $atts['rcd-size']);
    }

    if ( !empty($atts['rcd-animation']) ) {
      $atts['options']['animation'] = $atts['rcd-animation'];
      unset( $atts['rcd-animation']);
    }

    if ( !empty($atts['rcd-backdrop']) ) {
      $atts['options']['backdrop'] = $atts['rcd-backdrop'];
      unset( $atts['rcd-backdrop']);
    }

    if ( !empty($atts['rcd-esc-close']) ) {
      $atts['options']['esc_close'] = $atts['rcd-esc-close'];
      unset( $atts['rcd-esc-close']);
    }

    if ( !empty($atts['rcd-click-close']) ) {
      $atts['options']['click_close'] = $atts['rcd-click-close'];
      unset( $atts['rcd-click-close']);
    }

    if ( !empty($atts['rcd-auto-close']) ) {
      $atts['options']['auto_close'] = $atts['rcd-auto-close'];
      unset( $atts['rcd-auto-close']);
    }

    if ( !empty($atts['rcd-class']) ) {
      $atts['options']['class'] = $atts['rcd-class'];
      unset( $atts['rcd-class']);
    }

    if ( !empty($atts['rcd-selected-view']) ) {
      $atts['options']['selected_view'] = $atts['rcd-selected-view'];
      unset( $atts['rcd-selected-view']);
    }

    $atts['options'] = wp_json_encode($atts['options'], true);

    $atts['load'] = 'ngDialoag,rcDialog';

    //Set the template
    $atts['template'] = !empty($atts['template']) ? $atts['template'] : 'rcDialog';
    $atts['type'] = !empty($atts['type']) ? $atts['type'] : '';

    return self::ng_dialog( $atts, $content );
  }

}
