<?php
/**
 * Button Pageslide
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/directives/button/type/pageslide/default.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.5.1
 */

/**
 * Variable shared
 *
 * $button
 * $options
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$pageslide_attrs = wp_ng_get_html_attributes( $options );

$content = ob_start();
?>
<?php if (!empty($button['content'])) : ?>
  <section class="entry-content" <?php echo (!empty($button['content_class']) ? $button['content_class'] : ''); ?> >
    <?php echo $button['content']; ?>
  </section>
<?php endif; ?>
<?php
$content = ob_get_clean();

echo do_shortcode(sprintf('[ng-pageslide][ng-pageslide-button %s][/ng-pageslide-button][ng-pageslide-content %s]%s[/ng-pageslide-content][/ng-pageslide]',
  $button['toggle'],
  implode(' ', $pageslide_attrs),
  $content
));
