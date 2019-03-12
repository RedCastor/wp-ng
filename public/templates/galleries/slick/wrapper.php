<?php
/**
 * Angular Slick Wrapper
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/slick/wrapper.php.
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

$type = !empty($type) ? $type : 'slick';
$theme = !empty($theme) ? $theme : 'theme';
$options = array('animated' => $animated, 'shuffle' => $shuffle);

//Style Size
$style = array();
if (!empty($height)) {
  $style[] = sprintf('height:%s;', esc_attr($height));
}

//Classes
$class = explode(' ', $class);
$class[] = esc_attr($type) . '-' . esc_attr($theme); //Create Class 'owl-theme'


//Attributes
$gallery_attrs = wp_ng_get_html_attributes( $gallery['options'] );

if ($mode === 'aping') {
  $gallery_attrs[] = 'data-ng-if="sources.length"';
  $gallery_attrs[] = 'init-onload="true"';
  $gallery_attrs[] = 'data="sources"';
}
?>

<?php do_action('wp_ng_template_wrapper_lazyload_start', $load ); ?>
<?php do_action('wp_ng_template_wrapper_gallery_start', $template, $type, $mode, $gallery, $id, $options ); ?>

<slick <?php echo implode(' ', $gallery_attrs); ?> id="<?php echo esc_attr($id) ?>" class="<?php echo implode(' ', $class); ?>" style="<?php echo implode(' ', $style) ?>" >
  <?php echo $content; ?>
</slick>

<?php do_action('wp_ng_template_wrapper_gallery_end' ); ?>
<?php do_action('wp_ng_template_wrapper_lazyload_end' ); ?>
