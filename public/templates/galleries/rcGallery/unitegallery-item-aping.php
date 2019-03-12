<?php
/**
 * rcGallery Unite Gallery Item apiNG
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/rcGallery/unitegallery-item-aping.php.
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

switch ($theme) {
  case 'tilesgrid':
    $gallery['options']['grid_num_rows'] = isset($gallery['options']['grid_num_rows']) ? $gallery['options']['grid_num_rows'] : $columns;
    break;
  case 'tiles':
    $gallery['options']['tiles_col_width']    = isset($gallery['options']['tiles_col_width']) ? $gallery['options']['tiles_col_width'] : 1200 / absint($columns);
    $gallery['options']['tiles_min_columns']  = isset($gallery['options']['tiles_min_columns']) ? $gallery['options']['tiles_min_columns'] : 1;
    $gallery['options']['tiles_max_columns']  = isset($gallery['options']['tiles_max_columns']) ? $gallery['options']['tiles_max_columns'] : absint($columns);
    $gallery['options']['theme_appearance_order']  = isset($gallery['options']['theme_appearance_order']) ? $gallery['options']['theme_appearance_order'] : 'keep';
    break;
  case 'default':
    break;
  case 'compact':
    break;
  case 'grid':
    break;
  case 'slider':
    $gallery['options']['slider_control_zoom'] = isset($gallery['options']['slider_control_zoom']) ? $gallery['options']['slider_control_zoom'] : false;
    break;
  default:
}

//Override sources
$gallery['sources'] = "sources";

//Gallery array To Json string attributes
$gallery_attrs = wp_ng_get_html_attributes( $gallery, 'rcg-');

//Id, Theme and Type
$id = !empty($id) ? sprintf('rcg-id="%s"', esc_attr($id)) : '';
$theme = !empty($theme) ? sprintf('rcg-theme="%s"', esc_attr($theme)) : '';
$type = !empty($type) ? sprintf('rcg-%s', esc_attr($type)) : '';
?>
<rcg-media <?php echo $id; ?> <?php echo $type; ?> <?php echo $theme; ?> <?php echo implode(' ', $gallery_attrs); ?> rcg-height="<?php echo esc_attr($height); ?>" rcg-width="<?php echo esc_attr($width); ?>" >
  <img data-ng-repeat="item in sources" data-ng-src="{{item.thumb_url}}" data-image="{{item.img_url}}" ng-attr-data-type="{{item.source.video_provider}}" ng-attr-data-videoid="{{item.source.video_id}}" data-description="{{item.caption}}" alt="{{item.source.alt}}" />
</rcg-media>
