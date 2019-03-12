<?php
/**
 * Start Angular Wrapper Lazyload
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/global/wrapper-lazyload-start.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.5.0
 */

/**
 * Variable shared
 *
 * $ng_modules
 * $sources
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

global $wp_ng_lazyload_sources;

$wp_ng_lazyload_sources = $sources;
?>
<lazyload data-oc-lazy-load="<?php echo wp_ng_json_encode(array('serie' => true, 'files' => $sources)) ?>" >
