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
 * $class
 * $class_item
 * $height
 * $width
 * $content
 * $load
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$type = !empty($type) ? $type : 'gallery';
$options = array('animated' => $animated, 'shuffle' => $shuffle);

//Classes
$class = explode(' ', $class);
$class[] = !empty($theme) ? esc_attr($type) . '-' . esc_attr($theme) : esc_attr($type);
$class[]= $animated ? ' gallery-animated' : '';

//Attributes
$gallery_attrs = wp_ng_get_html_attributes( $gallery['options'] );

if ($mode === 'aping') {
  $gallery_attrs[] = 'data-ng-if="sources.length"';
  $gallery_attrs[] = 'angular-grid="sources"';
}
else {
  $gallery_attrs[] = 'angular-grid="[]"';
}

?>

<?php do_action('wp_ng_template_wrapper_lazyload_start', $load ); ?>
<?php do_action('wp_ng_template_wrapper_gallery_start', $template, $type, $mode, $gallery, $id, $options); ?>

<ul class="gallery-columns-<?php echo $columns ?> <?php echo implode(' ', $class); ?>" ag-id="<?php echo esc_attr($id) ?>" <?php echo implode(' ', $gallery_attrs); ?> >
  <?php echo $content; ?>
</ul>

<?php do_action('wp_ng_template_wrapper_gallery_end' ); ?>
<?php do_action('wp_ng_template_wrapper_lazyload_end' ); ?>
