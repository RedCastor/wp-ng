<?php
/**
 * Angular OWL Carousel 2 Item
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/angular-owl-carousel-2/owl-item.php.
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
?>
<?php foreach ($gallery['sources'] as $item) : ?>

  <figure class="<?php echo implode(' ', $class_item); ?> <?php echo (!empty($item['class']) ? $item['class'] : ''); ?>" style="<?php echo implode(' ', $style) ?>" >

    <?php if(!empty($item['link_url'])) : ?>
      <a class="wp-ng-fit-abs"
         href="<?php echo esc_url($item['link_url']); ?>"
         target="<?php echo esc_attr($item['link_target']); ?>"
         rel="<?php echo esc_attr($item['link_rel']); ?>"
      ></a>
    <?php endif; ?>

    <?php if ( !empty($item['id']) ) : ?>
    <?php if ( !empty($gallery['options']['lazyLoad']) && $gallery['options']['lazyLoad'] === true ) : ?>
      <img class="owl-lazy <?php echo implode(' ', $class_img); ?>" data-src="<?php echo $item['image']; ?>" alt="<?php echo $item['alt'] ; ?>" >
    <?php else : ?>
      <?php echo wp_get_attachment_image($item['id'], $item['size'], false, array('class' => implode(' ', $class_img), 'no-antimoderate' => true)); ?>
    <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($item['content'])) : ?>
      <section class="owl-slide-content <?php echo (!empty($item['content_class']) ? $item['content_class'] : ''); ?>">
        <section class="entry-content">
          <?php echo wpngautop($item['content']); ?>
        </section>
      </section>
    <?php endif; ?>

    <?php if($item['caption']) : ?>
      <figcaption class="<?php echo $item['caption_class'] ?>"><?php echo $item['caption']; ?></figcaption>
    <?php endif; ?>

  </figure>

<?php endforeach; ?>
