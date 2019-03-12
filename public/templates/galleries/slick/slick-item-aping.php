<?php
/**
 * Angular Slick apiNG
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/slick/slick-item-aping.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.5.0
 */

/**
 * Variable shared
 * $gallery
 * $type
 * $id
 * $template
 * $theme
 * $mode
 * $columns
 * $class
 * $class_item
 * $class_img
 * $height
 * $width
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

//Style Size
$style = array();
if (!empty($height)) {
  $style[] = sprintf('height:%s;', esc_attr($height));
}
if (!empty($width)) {
  $style[] = sprintf('width:%s;', esc_attr($width));
}

//Classes
$class_item = explode(' ', $class_item);
$class_img = explode(' ', $class_img);

//Tag Slide
$slickItem = !empty($gallery['options']['slide']) ? $gallery['options']['slide'] : 'div';
?>
<<?php echo $slickItem; ?> data-ng-repeat="item in sources" >
  <figure class="<?php echo implode(' ', $class_item); ?>" data-ng-class="item.source.class" style="<?php echo implode(' ', $style) ?>" >
    <a data-ng-if="item.post_url" data-ng-href="{{item.post_url}}" class="wp-ng-fit-abs" target="{{item.link_target}}" rel="{{item.link_rel}}"></a>

    <img class="<?php echo implode(' ', $class_img); ?>" data-ng-src="{{item.img_url}}" alt="{{item.source.alt || item.title}}" >

    <section data-ng-if="item.source.content" class="slick-slide-content" data-ng-class="item.source.content_class">
      <section class="entry-content" data-ng-bind-html-compile="item.source.content"></section>
    </section>

    <figcaption data-ng-if="item.caption" data-ng-class="item.source.caption_class" data-ng-bind-html-compile="item.caption"></figcaption>
  </figure>
</<?php echo $slickItem; ?>>
