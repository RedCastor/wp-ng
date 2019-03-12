<?php
/**
 * Angular Gallery Item
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/galleries/angular/item.php.
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

//Theme ZF6 Classes
if ($theme === 'zf-float') {
  $class_item[] = 'column column-block';
}
?>
<?php foreach ($gallery['sources'] as $item) : ?>

  <figure class="gallery-item <?php echo implode(' ', $class_item); ?> <?php echo (!empty($item['class']) ? $item['class'] : ''); ?>" style="<?php echo implode(' ', $style) ?>" >

    <?php if(!empty($item['link_url'])) : ?>
      <a class="wp-ng-fit-abs"
         href="<?php echo esc_url($item['link_url']); ?>"
         target="<?php echo esc_attr($item['link_target']); ?>"
         rel="<?php echo esc_attr($item['link_rel']); ?>"
      ></a>
    <?php endif; ?>

    <?php if ( !empty($item['thumb']) ) : ?>
      <img class="<?php echo implode(' ', $class_img); ?>" data-ng-src="<?php echo $item['image']; ?>" alt="<?php echo $item['alt'] ; ?>" >
    <?php elseif ( !empty($item['id']) ) : ?>
      <?php echo wp_get_attachment_image($item['id'], $item['size'], false, array('class' => implode(' ', $class_img))); ?>
    <?php endif; ?>

    <?php if (!empty($item['content'])) : ?>
      <section class="gallery-content <?php echo $item['content_class'] ?>">
        <section class="entry-content">
          <?php echo wpngautop($item['content']); ?>
        </section>
      </section>
    <?php endif; ?>

    <?php if($item['caption']) : ?>
      <figcaption class="wp-caption-text gallery-caption <?php echo $item['caption_class'] ?>"><?php echo $item['caption']; ?></figcaption>
    <?php endif; ?>
  </figure>

<?php endforeach; ?>
