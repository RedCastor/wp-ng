<?php
/**
 * Gallery Wrapper Angular
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/gallery-wrapper-rcGallery.php.
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
 * $height
 * $width
 * $content
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$gallery_attrs = array();
$type = !empty($type) ? $type : 'ngGallery';

//Classes
$class = explode(' ', $class);
$class[] = !empty($theme) ? esc_attr($type) . '-' . esc_attr($theme) : esc_attr($theme);

//Style Size
$style = array();
if (!empty($height)) {
  $style[] = sprintf('height:%s;', esc_attr($height));
}
if (!empty($width)) {
  $style[] = sprintf('width:%s;', esc_attr($width));
}

//Id
$id = empty($id) ? $type . '_' . strval(dechex(crc32(uniqid()))) : esc_attr($id);
?>
<div id="<?php echo $id ?>" class="<?php echo implode(' ', $class); ?>" <?php echo implode(' ', $gallery_attrs); ?> style="<?php echo implode(' ', $style) ?>" >
  <?php echo $content; ?>
</div>
