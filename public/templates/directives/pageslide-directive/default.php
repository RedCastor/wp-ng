<?php
/**
 * Pageslide default
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/directives/pageslide-directive/default.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.6.5
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

<?php echo $content; ?>

<?php do_action('wp_ng_template_wrapper_lazyload_end' ); ?>
