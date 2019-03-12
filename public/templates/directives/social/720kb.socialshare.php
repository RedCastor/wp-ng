<?php
/**
 * Social Share
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/directives/social/720k.socialshare.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.5.1
 */

/**
 * Variable shared
 *
 * $socialshare
 * $template
 * $class
 * $content
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$socialshare_attrs = wp_ng_get_html_attributes( $socialshare, 'socialshare-' );

printf('<a href="#" class="socialshare %1$s" socialshare %2$s >%3$s</a>', esc_attr($class), implode(' ', $socialshare_attrs), $content );
?>
