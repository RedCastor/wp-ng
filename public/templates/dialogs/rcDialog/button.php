<?php
/**
 * rcDialog Dialog
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/dialogs/rcDialog/dialog.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.5.1
 */

/**
 * Variable shared
 *
 * $dialog
 * $options
 * $data
 * $type
 * $id
 * $template_id
 * $template
 * $theme
 * $class
 * $content
 * $load
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$options_attrs = wp_ng_get_html_attributes( $options, 'rcd-' );

$template_content_path = !empty($template) && !empty($type) ? "dialogs/{$template}/{$type}-content.php" : 'dialogs/rcDialog/dialog-content.php';
?>

<?php do_action('wp_ng_template_wrapper_lazyload_start', $load ); ?>

<button type="button" class="<?php echo esc_attr($class); ?>" rcd-open="<?php echo esc_attr($type); ?>" rcd-template-url="<?php echo esc_attr($template_id); ?>" <?php echo implode(' ', $options_attrs); ?> >
  <?php echo $content; ?>
</button>
