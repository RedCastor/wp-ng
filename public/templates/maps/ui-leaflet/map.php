<?php
/**
 * UI Leaflet Map
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/maps/ui-leaflet/map.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.5.0
 */

/**
 * Variable shared
 * $map
 * $id
 * $height
 * $width
 * $class
 * $load
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$map_attrs = wp_ng_get_html_attributes($map);
?>

<?php do_action('wp_ng_template_wrapper_lazyload_start', $load ); ?>

<leaflet class="<?php echo esc_attr($class); ?>" id="<?php echo esc_attr($id); ?>" <?php echo implode(' ', $map_attrs); ?> height="<?php echo esc_attr($height); ?>" width="<?php echo esc_attr($width); ?>" ></leaflet>

<?php do_action('wp_ng_template_wrapper_lazyload_end' ); ?>
