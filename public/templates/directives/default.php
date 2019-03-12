<?php
/**
 * Default
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/directives/default.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.5.0
 */

/**
 * Variable shared
 *
 * $tag
 * $attrs
 * $template
 * $content
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


printf('<%1$s %2$s >%3$s</%1$s>', $tag, implode(' ', $attrs), $content);
?>
