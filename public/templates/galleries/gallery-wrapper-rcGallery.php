<?php
/**
 * Gallery Wrapper rcGallery
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
 * $class_img
 * $height
 * $width
 * $content
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


//Classes
$class = explode(' ', $class);
if (!empty($type)) {
  $class[] = !empty($theme) ? esc_attr($type) . '-' . esc_attr($theme) : esc_attr($theme);
}

?>
<rc-gallery class="<?php echo implode(' ', $class); ?>" >
  <?php echo $content; ?>
</rc-gallery>
