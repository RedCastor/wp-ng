<?php
/**
 * Button Default
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/directives/button/default.php.
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
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

echo sprintf('<%1$s %2$s><span aria-hidden="true">&times;</span>&nbsp;%3$s</%1$s>', $tag, implode(' ', $attrs), $content);
?>

