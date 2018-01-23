<?php
/**
 * Directive Shortcodes Gallery
 *
 * @author     RedCastor <team@redcastor.io>
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes/shortcodes
 * @version     1.5.0
 */
class Wp_Ng_Shortcodes_Gallery {



  /**
   * Gallery main process
   *
   * @param $atts
   *
   * @return string
   */
  public static function ng_gallery( $atts, $content = '' ) {

    $html = '';

    if ( ! empty( $atts['ids'] ) ) {
      // 'ids' is explicitly ordered, unless you specify otherwise.
      if ( empty( $atts['orderby'] ) ) {
        $atts['orderby'] = 'post__in';
      }
      $atts['include'] = $atts['ids'];
    }

    $_atts = shortcode_atts( array(
      'order'      => 'ASC',
      'orderby'    => 'menu_order ID',
      'gid'        => '',
      'id'         => 0,
      'include'    => '',
      'exclude'    => '',
      'columns'    => 3,
      'class'      => '',
      'class_item' => '',
      'class_img'  => '',
      'template'   => '',
      'type'       => '',
      'theme'      => '',
      'size'       => 'thumbnail',
      'size_image' => 'medium',
      'size_big'   => 'large',
      'width'      => '',
      'height'     => '',
    ), $atts, 'ng-gallery' );

    $id = intval( $_atts['id'] );
    $gid = $_atts['gid'];
    $type = $_atts['type'];
    $theme = $_atts['theme'];
    $template = $_atts['template'];
    $columns = $_atts['columns'];
    $class = $_atts['class'];
    $class_item = $_atts['class_item'];
    $class_img = $_atts['class_img'];

    //Parse shortcode gallery attributes.
    $atts_gallery = array(
      'sources',
      'options',
    );

    $atts_parser = new Wp_Ng_Shortcode_Parser();
    $gallery = $atts_parser->parse($atts, $atts_gallery);

    if ( $id || $_atts['include'] || $_atts['exclude'] ) {

      //Query posts attachment
      if ( ! empty( $_atts['include'] ) ) {

        $_attachments = get_posts( array( 'include' => $_atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $_atts['order'], 'orderby' => $_atts['orderby'] ) );

        $attachments = array();

        foreach ( $_attachments as $key => $val ) {

          $attachments[$val->ID] = $_attachments[$key];
        }
      } elseif ( ! empty( $_atts['exclude'] ) ) {

        $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $_atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $_atts['order'], 'orderby' => $_atts['orderby'] ) );
      } else {

        $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $_atts['order'], 'orderby' => $_atts['orderby'] ) );
      }

      if ( !empty( $attachments ) ) {

        $size       = $_atts['size'];
        $size_image = $_atts['size_image'];
        $size_big   = $_atts['size_big'];

        foreach ( $attachments as $id => $attachment ) {

          $thumb = wp_get_attachment_image_src($id, $size);
          $image = wp_get_attachment_image_src($id, $size_image);
          $big = wp_get_attachment_image_src($id, $size_big);

          $source = array(
            'id'            => $id,
            'size'          => $size,
            'thumb'         => !empty($thumb[0]) ? esc_url($thumb[0]) : '',
            'thumb_width'   => !empty($thumb[1]) ? $thumb[1] : 0,
            'thumb_height'  => !empty($thumb[2]) ? $thumb[2] : 0,
            'image'         => !empty($image[0]) ? esc_url($image[0]) : '',
            'image_width'   => !empty($image[1]) ? $image[1] : 0,
            'image_height'  => !empty($image[2]) ? $image[2] : 0,
            'big'           => !empty($big) ? esc_url($big[0]) : '',
            'big_width'     => !empty($big[1]) ? $big[1] : 0,
            'big_height'    => !empty($big[2]) ? $big[2] : 0,
            'title'         => esc_attr($attachment->post_title),
            'description'   => wp_get_attachment_caption($id),
            'alt'           => esc_attr( trim( strip_tags( get_post_meta( $id, '_wp_attachment_image_alt', true ) ) ) ),
          );

          $video_url = get_post_meta( $id, 'video_url', true );

          if ( !empty($video_url) ) {
            $source['video_provider'] = VideoUrlParser::identify_service( $video_url );
            $source['video_id'] = VideoUrlParser::get_url_id( $video_url );
            $source['video_url'] = esc_url($video_url);
          }

          $gallery['sources'][] = $source;
        }
      }
    }

    //Data Template
    $data = array(
      'gallery'   => $gallery,
      'type'      => $type,
      'id'        => $gid,
      'template'  => $template,
      'theme'     => $theme,
      'columns'   => $columns,
      'class'     => $class,
      'class_item' => $class_item,
      'class_img' => $class_img,
      'height'    => $_atts['height'],
      'width'     => $_atts['width'],
    );


    if(empty($content)) {
      $template_path = !empty($type) ? "galleries/gallery-{$type}.php" : 'galleries/gallery.php';

      $content = wp_ng_get_template( $template_path, null, $data, false );
    }

    $template_path = !empty($template) ? "galleries/gallery-wrapper-{$template}.php" : 'galleries/gallery-wrapper.php';
    $data['content'] = $content ? do_shortcode( $content ) : '';

    $html = wp_ng_get_template( $template_path, null, $data, false );


    return $html;
  }



  /**
   * Shortcode [rc-gallery]
   *
   * @param $atts
   *
   * @return string
   */
  public static function rc_gallery( $atts, $content = '' ) {

    //Default Size
    if ( !isset($atts['height']) ) {
      $atts['height'] = '400px';
    }

    if ( !isset($atts['width']) ) {
      $atts['width'] = '100%';
    }


    //Merge rcg with default attribute for ng-gallery
    if ( !empty($atts['rcg-id']) ) {
      $atts['gid'] = $atts['rcg-id'];
      unset( $atts['rcg-id']);
    }

    if ( !empty($atts['rcg-theme']) ) {
      $atts['theme'] = $atts['rcg-theme'];
      unset( $atts['rcg-theme']);
    }

    if ( !empty($atts['rcg-height']) ) {
      $atts['height'] = $atts['rcg-height'];
      unset( $atts['rcg-height']);
    }

    if ( !empty($atts['rcg-width']) ) {
      $atts['width'] = $atts['rcg-width'];
      unset( $atts['rcg-width']);
    }

    if ( !empty($atts['rcg-sources']) ) {
      $atts['sources'] = $atts['rcg-sources'];
      unset( $atts['rcg-sources']);
    }

    if ( !empty($atts['rcg-options']) ) {
      $atts['options'] = $atts['rcg-options'];
      unset( $atts['rcg-options']);
    }

    //Set the template
    $atts['template'] = !empty($atts['template']) ? $atts['template'] : 'rcGallery';

    return self::ng_gallery( $atts, $content );
  }


  /**
   * Shortcode [rc-gallery-unitegallery]
   *
   * @param $atts
   *
   * @return string
   */
  public static function rc_gallery_unitegallery( $atts, $content = '' ) {

    $atts['type'] = 'unitegallery';


    return self::rc_gallery( $atts, $content );
  }


  /**
   * Shortcode [rc-gallery-galleria]
   *
   * @param $atts
   *
   * @return string
   */
  public static function rc_gallery_galleria( $atts, $content = '' ) {

    $atts['type'] = 'galleria';

    return self::rc_gallery( $atts, $content );
  }


  /**
   * Shortcode [rc-gallery-galleria]
   *
   * @param $atts
   *
   * @return string
   */
  public static function owl2( $atts, $content = '' ) {

    $atts['type'] = 'owl';

    //Set the template
    $atts['template'] = !empty($atts['template']) ? $atts['template'] : 'angular-owl-carousel-2';

    return self::ng_gallery( $atts, $content );
  }

}
