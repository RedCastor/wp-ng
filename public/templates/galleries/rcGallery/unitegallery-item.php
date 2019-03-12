<?php
/**
 * rcGallery Unite Gallery Item
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/rcGallery/unitegallery-item.php.
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
  'caption'         => 'data-description',
  'alt'             => 'alt',
);

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
  case 'sliderfull':
  case 'slider':
    $gallery['options']['slider_control_zoom'] = isset($gallery['options']['slider_control_zoom']) ? $gallery['options']['slider_control_zoom'] : false;
    break;
  default:
}

if ($width === '') {
  $width = '100%';
}

//Mapping source item for gallery type
//-- Force add alt to empty if not exist other wise unitegallery js error stripTags replace undefined
$sources = array();
foreach ($gallery['sources'] as $index => $source) {
  $sources[] = wp_ng_array_keys_map($source_map, $source, true, array('alt'));
}

//Override sources
$gallery['sources'] = $sources;

//Gallery array To Json string attributes
$gallery_attrs = wp_ng_get_html_attributes( $gallery, 'rcg-');

//Id, Theme and Type
$id = !empty($id) ? sprintf('rcg-id="%s"', esc_attr($id)) : '';
$theme = !empty($theme) ? sprintf('rcg-theme="%s"', esc_attr($theme)) : '';
$type = !empty($type) ? sprintf('rcg-%s', esc_attr($type)) : '';
?>
<rcg-media <?php echo $id; ?> <?php echo $type; ?> <?php echo $theme; ?> <?php echo implode(' ', $gallery_attrs); ?> rcg-height="<?php echo esc_attr($height); ?>" rcg-width="<?php echo esc_attr($width); ?>" >
  <img data-ng-repeat="item in sources" rcg-source="item" />
</rcg-media>
