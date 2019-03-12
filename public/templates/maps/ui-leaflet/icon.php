<?php
/**
 * UI Leaflet Map Icon
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/maps/ui-leaflet/icon.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.5.1
 */

/**
 * Variable shared
 * $icon
 * $icon_class
 * $thumb_class
 * $thumb_src
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

?>
<div class="wp-ng-leaflet-icon-container <?php echo esc_attr($icon_class) ?>">
  <img class="<?php echo esc_attr($thumb_class) ?>" src="<?php echo esc_url($thumb_src[0]) ?>" width="<?php echo esc_attr($thumb_src[1]) ?>" height="<?php echo esc_attr($thumb_src[2]) ?>" style="width: 100%; height: 100%;" />
  <div class="wp-ng-leaflet-icon-pin"></div>
</div>

