<?php
/**
 * Directive Shortcodes Map
 *
 * @author     RedCastor <team@redcastor.io>
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes/shortcodes
 * @version     1.5.0
 */
class Wp_Ng_Shortcodes_Map {


  /**
   * Shortcode leaflet
   *
   * @param $atts
   *
   * @return string
   */
  public static function leaflet( $atts ) {

    $html = '';

    $_atts = shortcode_atts( array(
      'id'        => null,
      'height'    => '400px',
      'width'     => 'auto',
      'class'     => '',
      'load'      => '',
    ), $atts );


    $atts_map = array(
      'defaults',
      'controls',
      'center',
      'layers',
      'markers',
      'bounds',
      'maxbounds',
      'paths',
      'tiles',
    );


    $atts_parser = new Wp_Ng_Shortcode_Parser();
    $map = $atts_parser->parse($atts, $atts_map);
    $id = empty($_atts['id']) ? 'map_' . strval(dechex(crc32(uniqid()))) : $_atts['id'];


    foreach ($map['markers'] as $marker_key => $marker) {

      $type = isset($marker['icon']['type']) ? $marker['icon']['type'] : '';
      $icon_id = isset($marker['icon']['iconUrl']) ? absint($marker['icon']['iconUrl']) : 0;
      $shadow_id = isset($marker['icon']['shadowUrl']) ? absint($marker['icon']['shadowUrl']) : 0;
      $icon_html = null;
      $thumb_src = null;
      $thumb_id = null;
      $thumb_url = null;
      $thumb_class = '';
      $icon_class = '';

      if (isset($marker['icon']['html'])) {
        $icon_html = $marker['icon']['html'];

        if (is_array($icon_html)) {
          $thumb_id = !empty($icon_html['id']) ? $icon_html['id'] : 0;
          $thumb_url = !empty($icon_html['url']) && wp_ng_is_valid_url($icon_html['url']) ? $icon_html['url'] : false;
          $thumb_class = !empty($icon_html['imgClass']) ? $icon_html['imgClass'] : '';
          $icon_class = !empty($icon_html['iconClass']) ? $icon_html['iconClass'] : '';

          $map['markers'][$marker_key]['icon']['html'] = '';
        }
        else {
          $thumb_id = absint($icon_html);

          if (wp_ng_is_valid_url($icon_html)) {
            $thumb_url = $icon_html;
          }
        }
      }


      //Set icon image
      if ($icon_id) {
        $icon_src = wp_get_attachment_image_src($icon_id, 'thumbnail');
        $icon_url = $icon_src ? $icon_src[0] : '';

        $map['markers'][$marker_key]['icon']['iconUrl'] = $icon_url;
      }

      //Set shadow image
      if ($shadow_id) {
        $shadow_src = wp_get_attachment_image_src($shadow_id, 'thumbnail');
        $shadow_url = $shadow_src ? $shadow_src[0] : '';

        $map['markers'][$marker_key]['icon']['shadowUrl'] = $shadow_url;
      }


      if ($thumb_id) {
        $thumb_src = wp_get_attachment_image_src($thumb_id, 'thumbnail');
      }
      else if (!empty($thumb_url)) {
        $thumb_src[0] = $thumb_url;
        $thumb_src[1] = get_option( 'thumbnail_size_w' );
        $thumb_src[2] = get_option( 'thumbnail_size_h' );
      }

      if ($type === 'div' && $thumb_src ) {

        $map['markers'][$marker_key]['icon']['html'] = wp_ng_get_template( 'maps/ui-leaflet/icon.php', null, array(
          'icon'    => $marker['icon'],
          'icon_class' => $icon_class,
          'thumb_class' => $thumb_class,
          'thumb_src' => $thumb_src,
        ), false );
      }
    }

    $html = wp_ng_get_template( 'maps/ui-leaflet/map.php', null, array(
      'id'      => $id,
      'map'     => $map,
      'height'  => $_atts['height'],
      'width'   => $_atts['width'],
      'class'   => $_atts['class'],
      'load'    => array_merge(array_map('trim', explode(',', $_atts['load'])), array('ui-leaflet')),
      ), false );


    return $html;
  }


  /**
   * Shortcode leaflet google layer
   *
   * @param $atts
   *
   * @return string
   */
  public static function leaflet_google( $atts ) {

    $google_default_layer = array(
      'baselayers' => array(
        'googleTerrain' => array(
          'name'      => 'Google Streets',
          'layerType' => 'ROADMAP',
          'type'      => 'google',
          'layerOptions' => array(
            'mapOptions' => array(
              'backgroundColor'   => '#e6e6e6',
              'styles'            => array(),
            )
          )
        )
      )
    );

    $atts = array_replace_recursive( $atts, array(
      'layers' => $google_default_layer,
      'load' => 'ui-leaflet-layers,ui-leaflet-layer-google',
    ) );

    return self::leaflet( $atts );
  }


}
