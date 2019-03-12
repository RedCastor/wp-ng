<?php
/**
 * Button Dropdown
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/directives/button/type/dropdown.php.
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

$dropdown_attrs = wp_ng_get_html_attributes( $options );
?>
<dropdown-toggle <?php echo implode(' ', $dropdown_attrs); ?> >
  <toggle>
    <?php echo $button['toggle'] ?>
  </toggle>
  <pane>
    <?php if (!empty($button['content'])) : ?>
      <section class="entry-content" <?php echo (!empty($button['content_class']) ? $button['content_class'] : ''); ?> >
        <?php echo $button['content']; ?>
      </section>
    <?php endif; ?>
  </pane>
</dropdown-toggle>
