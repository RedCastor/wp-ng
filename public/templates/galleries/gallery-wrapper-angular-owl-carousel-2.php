<?php
/**
 * Gallery Wrapper Angular OWL Carousel 2
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/gallery-wrapper-angular-owl-carousel-2.php.
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
 * $content
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

//Default Options
$gallery['options']['items']    = isset($gallery['options']['items']) ? $gallery['options']['items'] : 1;
$gallery['options']['loop']     = isset($gallery['options']['loop']) ? $gallery['options']['loop'] : true;
$gallery['options']['autoplay'] = isset($gallery['options']['autoplay']) ? $gallery['options']['autoplay'] : false;
$gallery['options']['autoplayHoverPause'] = isset($gallery['options']['autoplayHoverPause']) ? $gallery['options']['autoplayHoverPause'] : true;
$gallery['options']['autoplayTimeout'] = isset($gallery['options']['autoplayTimeout']) ? $gallery['options']['autoplayTimeout'] : 2000;

//To Json options attribute
$gallery['options'] = wp_ng_json_encode($gallery['options']);

$type = !empty($type) ? $type : 'owl';
$theme = !empty($theme) ? $theme : 'theme';

//Classes
$class = explode(' ', $class);
$class[] = esc_attr($type) . '-' . esc_attr($theme); //Create Class 'owl-theme'

//Style Size
$style = array();
if (!empty($height)) {
  $style[] = sprintf('height:%s;', esc_attr($height));
}
if (!empty($width)) {
  $style[] = sprintf('width:%s;', esc_attr($width));
}

//Id, Theme and Type
$id = empty($id) ? $type . '_' . strval(dechex(crc32(uniqid()))) : esc_attr($id);
?>
<ng-owl-carousel id="<?php echo $id ?>" class="<?php echo implode(' ', $class); ?>" owl-items="[]" owl-properties="<?php echo $gallery['options']; ?>" >
  <?php echo $content; ?>
</ng-owl-carousel>

