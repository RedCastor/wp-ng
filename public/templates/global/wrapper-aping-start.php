<?php
/**
 * Start Angular Wrapper apiNG
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/global/wrapper-aping-start.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.6.0
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

  $new_source['platform'] = 'internal';
  $new_source['type'] = 'image';
  $new_source['blog_name'] = get_bloginfo('name');
  $new_source['blog_id'] = 0;
  $new_source['blog_link'] = get_bloginfo('url');
  $new_source['date_time'] = get_the_date('', $source['id'] ) . ' ' . get_the_time('', $source['id'] );
  $new_source['timestamp'] = get_the_time('U', $source['id'] );
  $new_source['source'] = array_diff_key($source, $source_map);

  $sources[] = $new_source;
}

$aping   = wp_ng_get_html_attributes($gallery['aping']);
$sources = wp_ng_json_encode($sources);
$sources  = !empty($options['shuffle']) ? "({$sources} | shuffle)" : $sources;
?>
<aping result-name="sources" aping-json-string="<?php echo $sources; ?>" <?php echo implode(' ', $aping); ?> >
