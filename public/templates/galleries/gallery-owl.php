<?php
/**
 * Gallery OWL2
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/gallery.php.
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

//Style Size
$style = array();
if (!empty($height)) {
  $style[] = sprintf('height:%s;', esc_attr($height));
}
if (!empty($width)) {
  $style[] = sprintf('width:%s;', esc_attr($width));
}

//Classes
$class_item = explode(' ', $class_item);
$class_img = explode(' ', $class_img);
?>
<?php foreach ($gallery['sources'] as $item) : ?>
  <figure class="<?php echo implode(' ', $class_item); ?>" style="<?php echo implode(' ', $style) ?>" >
    <?php if ( !empty($gallery['options']['lazyLoad']) ) : ?>
      <img class="owl-lazy <?php echo implode(' ', $class_img); ?>" data-src="<?php echo $item['thumb']; ?>" alt="<?php echo $item['alt'] ; ?>">
    <?php else : ?>
      <?php echo wp_get_attachment_image($item['id'], $item['size'], false, array('class' => implode(' ', $class_img))); ?>
    <?php endif; ?>
    <?php if($item['description']) : ?>
      <figcaption><?php echo $item['description']; ?></figcaption>
    <?php endif; ?>
  </figure>
<?php endforeach; ?>
