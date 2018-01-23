<?php
/**
 * Simple Leaflet map
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/map/simple-map.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.5.0
 */

/**
 * Variable shared
 * $map,
 * $id,
 * $height,
 * $width
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$map_attrs = array();

foreach ($map as $key => $val) {
  if (!empty($val)) {
    $map_attrs[] = sprintf('%s="%s"', $key, wp_ng_json_encode($val));
  }
}

?>
<leaflet id="<?php echo esc_attr($id); ?>" <?php echo implode(' ', $map_attrs); ?> height="<?php echo esc_attr($height); ?>" width="<?php echo esc_attr($width); ?>" ></leaflet>
