<?php
/**
 * Angular OWL Carousel 2 Wrapper
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/angular-owl-carousel-2/wrapper.php.
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
 * $animated
 * $shuffle
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
$options = array('animated' => $animated, 'shuffle' => $shuffle);

//Classes
$class = explode(' ', $class);
$class[] = esc_attr($type) . '-' . esc_attr($theme); //Create Class 'owl-theme'

//Style Size
$style = array();
if (!empty($height)) {
  $style[] = sprintf('height:%s;', esc_attr($height));
}

//Attributes
if ($mode === 'aping') {
  $gallery_attrs[] = 'data-ng-if="sources.length"';
  $gallery_attrs[] = 'owl-items="sources"';
}
else {
  $gallery_attrs[] = 'owl-items="[]"';
}
$gallery_attrs[] = 'owl-properties="' . $gallery['options'] . '"';
?>

<?php do_action('wp_ng_template_wrapper_lazyload_start', $load ); ?>
<?php do_action('wp_ng_template_wrapper_gallery_start', $template, $type, $mode, $gallery, $id, $options ); ?>

<ng-owl-carousel <?php echo implode(' ', $gallery_attrs); ?> id="<?php echo $id ?>" class="<?php echo implode(' ', $class); ?>" style="<?php echo implode(' ', $style) ?>" >
  <?php echo $content; ?>
</ng-owl-carousel>

<?php do_action('wp_ng_template_wrapper_gallery_end' ); ?>
<?php do_action('wp_ng_template_wrapper_lazyload_end' ); ?>
