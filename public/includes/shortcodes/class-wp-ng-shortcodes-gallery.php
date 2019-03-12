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


  private static function set_gallery_sources( $ids, $sources ) {

    //Add id to sources from include
    foreach ($ids as $id) {

      if (!empty($id)) {
        $sources[] = array('id' => $id);
      }
    }

    return $sources;
  }

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
      'columns_small' => 2,
      'columns_large' => 4,
      'class'      => '',
      'class_item' => '',
      'class_img'  => '',
      'template'   => '',
      'template_plugin' => '',
      'template_plugin_item' => '',
      'type'       => '',
      'mode'       => '',
      'theme'      => '',
      'size'       => 'medium',
      'size_thumb' => 'thumbnail',
      'size_big'   => 'large',
      'width'      => '',
      'height'     => '',
      'load'       => '',
      'empty_item' => 'true',
      'animated'   => 'false',
      'shuffle'    => 'false',
    ), $atts, 'ng-gallery' );

    $id         = absint( $_atts['id'] );
    $type       = $_atts['type'];
    $gid        = empty($_atts['gid']) ? (!empty($type) ? $type . '_' : '') . strval(dechex(crc32(uniqid()))) : $_atts['gid'];
    $mode       = $_atts['mode'];
    $theme      = $_atts['theme'];
    $template   = $_atts['template'];
    $template_plugin = !empty($_atts['template_plugin']) ? $_atts['template_plugin'] : null;
    $template_plugin_item = !empty($_atts['template_plugin_item']) ? $_atts['template_plugin_item'] : null;
    $columns    = intval($_atts['columns']);
    $columns_small = intval($_atts['columns_small']);
    $columns_large = intval($_atts['columns_large']);
    $class      = $_atts['class'];
    $class_item = $_atts['class_item'];
    $class_img  = $_atts['class_img'];
    $size       = $_atts['size'];
    $size_thumb = $_atts['size_thumb'];
    $size_big   = $_atts['size_big'];
    $empty_item = $_atts['empty_item'] === 'true' ? true : false;
    $animated   = $_atts['animated'] === 'true' ? true : false;
    $shuffle   = $_atts['shuffle'] === 'true' ? true : false;
    $placeholder_image_src = $empty_item === false ? wp_ng_get_placeholder_image_src() : '';

    //Default Source
    $default_source = array(
      'id' => 0,
      'size' => $size,
      'thumb' => $placeholder_image_src,
      'thumb_width' => 0,
      'thumb_height' => 0,
      'image' => $placeholder_image_src,
      'image_width' => 0,
      'image_height' => 0,
      'big' => $placeholder_image_src,
      'big_width' => 0,
      'big_height' => 0,
      'title' => '',
      'content' => '',
      'content_class' => '',
      'caption' => '',
      'caption_class' => '',
      'alt' => '',
      'link_url' => '',
      'link_target' => '',
      'link_rel' => '',
    );

    //Parse shortcode gallery attributes.
    $atts_gallery = array(
      'sources',
      'options',
    );

    //Add Mode to parse
    if (!empty($mode)) {
      $atts_gallery[] = $mode;
    }

    $atts_parser = new Wp_Ng_Shortcode_Parser();
    $gallery = $atts_parser->parse($atts, $atts_gallery);

    $include_arr = array_map('trim', explode(',', $_atts['include']));

    //Add id to sources from include
    $gallery['sources'] = self::set_gallery_sources($include_arr, $gallery['sources']);

    //Complete id if not set
    foreach ($gallery['sources'] as $i => $source) {
      if(!isset($source['id'])) {
        $source['id'] = 0;
        $gallery['sources'][$i] = $source;
      }
    }

    //Get all Ids from sources
    $source_ids = wp_list_pluck($gallery['sources'], 'id');
    $_atts['include'] = implode(',', array_filter($source_ids));

    //Query posts attachment
    if ( $id || !empty($_atts['include']) || !empty($_atts['exclude']) ) {

      if ( ! empty( $_atts['include'] ) ) {

        $_attachments = get_posts( array( 'include' => $_atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $_atts['order'], 'orderby' => $_atts['orderby'] ) );

        $attachments = array();

        foreach ( $_attachments as $key => $val ) {

          $attachments[$val->ID] = $_attachments[$key];
        }
      } elseif ( ! empty( $_atts['exclude'] ) ) {

        $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $_atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $_atts['order'], 'orderby' => $_atts['orderby'] ) );

        $gallery['sources'] = self::set_gallery_sources(array_keys($attachments), $gallery['sources']);
      } else {

        $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $_atts['order'], 'orderby' => $_atts['orderby'] ) );

        $gallery['sources'] = self::set_gallery_sources(array_keys($attachments), $gallery['sources']);
      }
    }

    $parsed_sources = array();

    foreach ($gallery['sources'] as $source ) {

      $source_id = false;

      if (!empty($source['id'])) {
        $source_id = apply_filters( 'wp_ng_translate_id', $source['id'], 'attachment', true );
      }

      if ($source_id && !empty($attachments[$source_id]) ) {
        $attachment = $attachments[$source_id];
        $thumb = wp_get_attachment_image_src($source_id, $size_thumb);
        $image = wp_get_attachment_image_src($source_id, $size);
        $big = wp_get_attachment_image_src($source_id, $size_big);

        $attachment_source = array(
          'id'            => $source_id,
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
          'content'       => $attachment->post_content,
          'caption'       => wp_get_attachment_caption($source_id),
          'alt'           => esc_attr( trim( strip_tags( get_post_meta( $source_id, '_wp_attachment_image_alt', true ) ) ) ),
        );

        $video_url = get_post_meta( $source_id, 'video_url', true );

        if ( !empty($video_url) ) {
          $attachment_source['video_provider'] = VideoUrlParser::identify_service( $video_url );
          $attachment_source['video_id'] = VideoUrlParser::get_url_id( $video_url );
          $attachment_source['video_url'] = esc_url($video_url);
        }

        $source = wp_parse_args($source, $attachment_source);
      }


      $parsed_source = wp_parse_args($source, $default_source);

      $parsed_source['content'] = wp_ng_shortcode_decode($parsed_source['content']);
      $parsed_sources[] = $parsed_source;
    }

    //Blank if no source
    if (empty($parsed_sources) && empty($content)) {
      //For not execute wp gallary shortcode after post_gallery filter if no source
      return "\n";
    }

    $gallery['sources'] = ($shuffle === true) ? apply_filters('wp_ng_shuffle_assoc', $parsed_sources) : $parsed_sources;


    //Data Template
    $data = array(
      'gallery'   => $gallery,
      'type'      => $type,
      'id'        => $gid,
      'template'  => $template,
      'theme'     => $theme,
      'mode'      => $mode,
      'columns'   => $columns,
      'columns_small' => $columns_small,
      'columns_large' => $columns_large,
      'class'     => $class,
      'class_item' => $class_item,
      'class_img' => $class_img,
      'height'    => $_atts['height'],
      'width'     => $_atts['width'],
      'load'      => array_map('trim', explode(',', $_atts['load'])),
      'animated'  => $animated,
      'shuffle'   => $shuffle,
    );


    if(empty($content)) {

      $template_path = !empty($template) ? (!empty($type) ? "galleries/{$template}/{$type}-item" : "galleries/{$template}/item") : 'galleries/angular/item';
      $template_path .= !empty($mode) ? "-{$mode}.php" : '.php';

      $content = wp_ng_get_template( $template_path, $template_plugin_item, $data, false );
    }

    $template_path = !empty($template) ? "galleries/{$template}/wrapper.php" : 'galleries/angular/wrapper.php';

    $data['content'] = $content ? do_shortcode( $content ) : '';

    $html = wp_ng_get_template( $template_path, $template_plugin, $data, false );

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

    if ( !empty($atts['load']) ) {
      $atts['load'] .= ',rcGallery';
    }
    else {

      if (!empty($atts['type'])) {

        switch($atts['type']) {
          case 'unitegallery':
            $atts['load'] = 'rcGalleryUnitegallery';
            break;
          case 'galleria':
            $atts['load'] = 'rcGalleryGalleria';
            break;
        }

        $atts['load'] .= ',rcGallery';
      }
      else {
        $atts['load'] = 'rcGallery';
      }
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
   * Shortcode [ng-gallery-owl2]
   *
   * @param $atts
   *
   * @return string
   */
  public static function owl2( $atts, $content = '' ) {

    $atts['type'] = 'owl';
    $atts['load'] = 'angular-owl-carousel-2-theme-default,angular-owl-carousel-2';

    //Set the template
    $atts['template'] = !empty($atts['template']) ? $atts['template'] : 'angular-owl-carousel-2';

    return self::ng_gallery( $atts, $content );
  }


  /**
   * Shortcode [ng-gallery-slick]
   *
   * @param $atts
   *
   * @return string
   */
  public static function slick( $atts, $content = '' ) {

    $atts['type'] = 'slick';
    $atts['load'] = 'slick-theme,slick';

    //Set the template
    $atts['template'] = !empty($atts['template']) ? $atts['template'] : 'slick';

    return self::ng_gallery( $atts, $content );
  }


  /**
   * Shortcode [ng-gallery-swiper]
   *
   * @param $atts
   *
   * @return string
   */
  public static function swiper( $atts, $content = '' ) {

    $atts['type'] = 'swiper';
    $atts['load'] = 'ui.swiper';

    //Set the template
    $atts['template'] = !empty($atts['template']) ? $atts['template'] : 'ui.swiper';

    return self::ng_gallery( $atts, $content );
  }

}
