<?php
/**
 * Angular Gallery Wrapper
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/angular/wrapper.php.
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
 * $columns_small
 * $columns_large
 * $class
 * $class_item
 * $height
 * $width
 * $content
 * $load
 * $animated
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$type = !empty($type) ? $type : 'gallery';


//Classes
$class = explode(' ', $class);
$class[] = !empty($theme) ? esc_attr($type) . '-' . esc_attr($theme) : esc_attr($type);
$class[]= $animated ? ' gallery-animated' : '';

//Theme ZF6 Classes
if ($theme === 'zf-float') {
  $class[] = " row small-up-{$columns_small} medium-up-{$columns} large-up-{$columns_large}";
}

//Attributes
$gallery_attrs = array();

if ($mode === 'aping') {
  $gallery_attrs[] = 'data-ng-if="sources.length"';
}
?>

<?php do_action('wp_ng_template_wrapper_lazyload_start', $load ); ?>
<?php do_action('wp_ng_template_wrapper_gallery_start', $template, $type, $mode, $gallery, $id ); ?>

<ng-gallery id="<?php echo esc_attr($id) ?>" class="gallery-columns-<?php echo $columns ?> <?php echo implode(' ', $class); ?>" <?php echo implode(' ', $gallery_attrs); ?> >
  <?php echo $content; ?>
</ng-gallery>

<?php do_action('wp_ng_template_wrapper_gallery_end' ); ?>
<?php do_action('wp_ng_template_wrapper_lazyload_end' ); ?>
