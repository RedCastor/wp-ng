<?php
/**
 * Angular UI Swiper Wrapper
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/ui.swiper/wrapper.php.
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
 * $mode
 * $columns
 * $class
 * $class_item
 * $class_img
 * $height
 * $width
 * $content
 * $load
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

//Default Options
$swiper_dots  = isset($gallery['options']['swiper_dots']) ? $gallery['options']['swiper_dots'] : false;
$swiper_nav   = isset($gallery['options']['swiper_nav']) ? $gallery['options']['swiper_nav'] : false;
unset($gallery['options']['swiper_dots']);
unset($gallery['options']['swiper_nav']);

//To Json options attribute
$gallery['options'] = wp_ng_get_html_attributes($gallery['options']);

$type = !empty($type) ? $type : 'swiper';
$theme = !empty($theme) ? $theme : 'default';
$options = array('animated' => $animated, 'shuffle' => $shuffle);

//Classes
$class = explode(' ', $class);
$class[] = esc_attr($type) . '-' . esc_attr($theme); //Create Class

//Style Size
$style = array();
if (!empty($height)) {
  $style[] = sprintf('height:%s;', esc_attr($height));
}

//Attributes
$gallery_attrs = $gallery['options'];

if ($mode === 'aping') {
  $gallery_attrs[] = 'data-ng-if="sources.length"';
}
?>

<?php do_action('wp_ng_template_wrapper_lazyload_start', $load ); ?>
<?php do_action('wp_ng_template_wrapper_gallery_start', $template, $type, $mode, $gallery, $id, $options ); ?>

<ui-swiper id="<?php echo esc_attr($id) ?>" class="<?php echo implode(' ', $class); ?>" <?php echo implode(' ', $gallery_attrs); ?> style="<?php echo implode(' ', $style) ?>" >
  <ui-swiper-slides>
  <?php echo $content; ?>
  </ui-swiper-slides>

  <?php if ($swiper_nav) : ?>
  <ui-swiper-prev></ui-swiper-prev>
  <ui-swiper-next></ui-swiper-next>
  <?php endif; ?>

  <?php if ($swiper_dots) : ?>
  <ui-swiper-pagination></ui-swiper-pagination>
  <?php endif; ?>
</ui-swiper>

<?php do_action('wp_ng_template_wrapper_gallery_end' ); ?>
<?php do_action('wp_ng_template_wrapper_lazyload_end' ); ?>
