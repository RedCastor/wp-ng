<?php
/**
 * Start Angular Wrapper Gallery Init
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/global/wrapper-json-start.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.6.2
 */

/**
 * Variable shared
 *
 * $template
 * $type
 * $mode
 * $gallery
 * $id
 * $options
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


$source_map = array(
  'link_url'        => 'post_url',
  'id'              => 'intern_id',
  'caption'         => 'caption',
  'thumb'           => 'thumb_url',
  'image'           => 'img_url',
  'big'             => 'native_url',
  'title'           => 'title',
  'alt'             => 'alt',
);

//Mapping source item for gallery type
$sources = array();
foreach ($gallery['sources'] as $index => $source) {

  $new_source =  wp_ng_array_keys_map($source_map, $source, true);

  $new_source['blog_name'] = get_bloginfo('name');
  $new_source['blog_id'] = 0;
  $new_source['blog_link'] = get_bloginfo('url');
  $new_source['date_time'] = get_the_date('', $source['id'] ) . ' ' . get_the_time('', $source['id'] );
  $new_source['timestamp'] = get_the_time('U', $source['id'] );
  $new_source['source'] = array_diff_key($source, $source_map);

  $sources[] = $new_source;
}

$sources = wp_ng_json_encode($sources);
$sources  = !empty($options['shuffle']) ? "({$sources} | shuffle)" : $sources;
$init_exp = 'source_' . $id . '=' . $sources;
?>
<div data-ng-init="<?php echo $init_exp ?>" >
