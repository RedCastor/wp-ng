<?php
/**
 * Button Webicon
 * Template provide html for https://jonsuh.com/hamburgers/
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/directives/button/hamburger.php.
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

if ($tag === 'button') {
  $attrs[] = 'type="button"';
}

//Filter icon
$icon = '';
$attrs = array_map(function($v) use (&$icon) {
  $start = strpos($v, 'icon=');
  if ($start === 0) {
    $icon = str_replace(['icon=', '"'],"", $v);
    return '';
  }
  return $v;
}, $attrs);
?>
<<?php echo tag_escape($tag); ?> <?php echo implode(' ', $attrs); ?> >
  <?php echo do_shortcode(sprintf('[ng-webicon tag="%s" icon="%s"]<span>%s</span>', 'span', $icon, $content)); ?>
</<?php echo tag_escape($tag); ?>>
