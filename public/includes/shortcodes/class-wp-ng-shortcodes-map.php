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


      if ($type === 'div') {
        $thumb_id = isset($marker['icon']['html']) ? absint($marker['icon']['html']) : 0;
        $thumb_src = wp_get_attachment_image_src($thumb_id, 'thumbnail');
        $thumb_html = $thumb_src ? sprintf('<img src="%s" width="%s" height="%s" style="width: 100%%; height: 100%%;" />', $thumb_src[0], $thumb_src[1], $thumb_src[2]) : '';

        $map['markers'][$marker_key]['icon']['html'] = $thumb_html;
      }
    }


    $html = wp_ng_get_template( 'maps/simple-map.php', null, array(
      'id'      => $id,
      'map'     => $map,
      'height'  => $_atts['height'],
      'width'   => $_atts['width'],
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
    ) );


    return self::leaflet( $atts );
  }


}
