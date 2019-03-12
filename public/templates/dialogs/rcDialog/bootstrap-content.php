<?php
/**
 * rcDialog Bootstrap
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/dialogs/rcDialog/bootstrap.php.
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

?>
<script type="text/ng-template" id="<?php echo esc_attr($template_id); ?>">
  <?php if (!empty($dialog['content'])) : ?>
    <section class="entry-content" <?php echo (!empty($dialog['content_class']) ? $dialog['content_class'] : ''); ?> >
      <?php echo wpngautop($dialog['content']); ?>
    </section>
  <?php endif; ?>
</script>

<?php do_action('wp_ng_template_wrapper_lazyload_end'); ?>
