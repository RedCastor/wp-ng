<?php
/**
 * rcGallery Galleria Item apiNG
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/rcGallery/galleria-item-aping.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.5.0
 */

/**
 * Variable shared
 * $gallery
 * $type
 * $id
 * $template
 * $theme
 * $columns
 * $class
 * $class_item
 * $class_img
 * $height
 * $width
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


//Override sources
$gallery['sources'] = "sources";

//Gallery array To Json string attributes
$gallery_attrs = wp_ng_get_html_attributes( $gallery, 'rcg-' );

//Id, Theme and Type
$id = !empty($id) ? sprintf('rcg-id="%s"', esc_attr($id)) : '';
$theme = !empty($theme) ? sprintf('rcg-theme="%s"', esc_attr($theme)) : '';
$type = !empty($type) ? sprintf('rcg-%s', esc_attr($type)) : '';
?>
<rcg-media <?php echo $type; ?> <?php echo $id; ?> <?php echo $theme; ?> <?php echo implode(' ', $gallery_attrs); ?> rcg-height="<?php echo esc_attr($height); ?>" rcg-width="<?php echo esc_attr($width); ?>" >
  <a data-ng-repeat="item in sources" data-ng-href="{{item.source.video_url || item.img_url}}" >
    <img data-ng-src="{{item.thumb_url}}" data-title="{{item.title}}" data-description="{{item.caption}}" alt="{{item.source.alt}}" data-big="{{item.native_url}}" />
  </a>
</rcg-media>
