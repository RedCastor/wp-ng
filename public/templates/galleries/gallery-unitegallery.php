<?php
/**
 * Gallery Unite Gallery
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/gallery-unitegallery.php.
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


$source_map = array(
  'thumb'           => 'ng-src',
  'big'             => 'data-image',
  'video_provider'  => 'data-type',
  'video_id'        => 'data-videoid',
  'description'     => 'data-description',
  'alt'             => 'alt',
);

switch ($theme) {
  case 'tiles':
    $gallery['options']['tiles_col_width']    = isset($gallery['options']['tiles_col_width']) ? $gallery['options']['tiles_col_width'] : 1200 / absint($columns);
    $gallery['options']['tiles_min_columns']  = isset($gallery['options']['tiles_min_columns']) ? $gallery['options']['tiles_min_columns'] : 1;
    $gallery['options']['tiles_max_columns']  = isset($gallery['options']['tiles_max_columns']) ? $gallery['options']['tiles_max_columns'] : absint($columns);
    break;
  case 'default':
  case 'compact':
  case 'grid':
  case 'slider':
    $gallery['options']['slider_control_zoom'] = isset($gallery['options']['slider_control_zoom']) ? $gallery['options']['slider_control_zoom'] : false;
    break;
  default:
}

//Mapping source item for gallery type
$sources = array();
foreach ($gallery['sources'] as $index => $source) {
  $sources[] = wp_ng_array_keys_map($source_map, $source, true);
}

//Override sources
$gallery['sources'] = $sources;

//Gallery array To Json string attributes
$gallery_attrs = array();
foreach ($gallery as $key => $val) {
  if (!empty($val)) {
    $gallery_attrs[] = sprintf('rcg-%s="%s"', $key, wp_ng_json_encode($val));
  }
}

//Id, Theme and Type
$id = !empty($id) ? sprintf('rcg-id="%s"', esc_attr($id)) : '';
$theme = !empty($theme) ? sprintf('rcg-theme="%s"', esc_attr($theme)) : '';
$type = !empty($type) ? sprintf('rcg-%s', esc_attr($type)) : '';
?>
<rcg-media <?php echo $id; ?> <?php echo $type; ?> <?php echo $theme; ?> <?php echo implode(' ', $gallery_attrs); ?> rcg-height="<?php echo esc_attr($height); ?>" rcg-width="<?php echo esc_attr($width); ?>" >
  <img data-ng-repeat="source in sources" rcg-source="source" alt="{{source.alt}}" />
</rcg-media>
