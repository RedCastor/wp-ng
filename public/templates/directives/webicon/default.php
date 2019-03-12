<?php
/**
 * Default WebIcon
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/directives/webicon/default.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.5.1
 */

/**
 * Variable shared
 *
 * $tag
 * $attrs
 * $template
 * $content
 * $load
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

?>

<?php do_action('wp_ng_template_wrapper_lazyload_start', $load ); ?>

<?php printf('<%1$s %2$s >%3$s</%1$s>', $tag, implode(' ', $attrs), $content); ?>

<?php do_action('wp_ng_template_wrapper_lazyload_end' ); ?>
