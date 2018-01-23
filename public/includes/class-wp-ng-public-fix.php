<?php

/**
 * The public-facing includes functionality fixing or workaround wp core.
 *
 * @link       http://redcastor.io
 * @since      1.5.0
 *
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes
 */







/**
 *
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Public_Fix {


  /**
   * Init fix.
   */
  public static function init() {



    add_filter( 'update_attached_file', array( __CLASS__, 'fix_attachment_file'), 10, 2 );
  }


  /**
   * Fix attachemnt windows path file duplicate backslash on create media by rest api.
   * Bug issue: https://core.trac.wordpress.org/ticket/40861
   *
   *
   * @param $file
   * @param $attachment_id
   *
   * @return mixed
   */
  public static function fix_attachment_file($file, $attachment_id) {

    $file = str_replace('\\\\', '\\', $file );

    return $file;
  }


}
