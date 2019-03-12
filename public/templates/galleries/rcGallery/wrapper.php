<?php
/**
 * rcGallery Wrapper
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/rcGallery/wrapper.php.
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

global $wp_ng_lazyload_sources;

$options = array('animated' => $animated, 'shuffle' => $shuffle);

//Classes
$class = explode(' ', $class);
$class[] = !empty($theme) ? esc_attr($type) . '-' . esc_attr($theme) : esc_attr($type);

//Attributes
$gallery_attrs = array();

if ($mode === 'aping') {
  $gallery_attrs[] = 'data-ng-if="sources.length"';
}
?>

<?php do_action('wp_ng_template_wrapper_lazyload_start', $load ); ?>
<?php do_action('wp_ng_template_wrapper_gallery_start', $template, $type, $mode, $gallery, $id, $options ); ?>

<?php
$load_urls = array();
if ( !empty($wp_ng_lazyload_sources) ) {

  switch ($type) {
    case 'unitegallery':
      $theme = !empty($theme) ? $theme : 'default';
      $load_urls[] = wp_ng_get_asset_path("vendor/unitegallery/js/unitegallery.min.js");
      $load_urls[] = wp_ng_get_asset_path("vendor/unitegallery/css/unitegallery.min.css");
      $load_urls[] = wp_ng_get_asset_path("vendor/unitegallery/themes/{$theme}/unitegallery.{$theme}.min.js");
      break;
    case 'galleria':
      $theme = !empty($theme) ? $theme : 'classic';
      $load_urls[] = wp_ng_get_asset_path("vendor/galleria/galleria.min.js");
      $load_urls[] = wp_ng_get_asset_path("vendor/galleria/themes/{$theme}/galleria.{$theme}.min.js");
      break;
  }

}
?>

<rc-gallery class="<?php echo implode(' ', $class); ?>" rcg-load-urls="<?php echo wp_ng_json_encode($load_urls) ?>" <?php echo implode(' ', $gallery_attrs); ?> >
  <?php echo $content; ?>
</rc-gallery>

<?php do_action('wp_ng_template_wrapper_gallery_end' ); ?>
<?php do_action('wp_ng_template_wrapper_lazyload_end' ); ?>
