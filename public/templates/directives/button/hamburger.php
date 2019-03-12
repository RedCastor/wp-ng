<?php
/**
 * Button Hamburger
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

//Filter Class
$attrs = array_map(function($v) {
   $start = strpos($v, 'class=');
   if ($start === 0) {
    $v = substr($v, 7, strpos($v, '"', 7) - 7);
    $v = explode(' ', $v);
    $v[] = 'hamburger';
    $v[] = 'hamburger--squeeze';
    $v = 'class="' . implode(' ', array_unique($v)) . '"';
   }
    return $v;
}, $attrs);
?>
<<?php echo tag_escape($tag); ?> <?php echo implode(' ', $attrs); ?> >
  <span class="hamburger-box">
    <span class="hamburger-inner"></span>
  </span>
  <?php echo $content; ?>
</<?php echo tag_escape($tag); ?>>
