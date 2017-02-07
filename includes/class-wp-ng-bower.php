<?php

/**
 * Bower
 *
 * @link       http://redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */

/**
 * Bower
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Bower {

  private $bower = null;
  private $bower_admin = null;

  /**
   * Wp_Ng_Bower constructor.
   *
   * @param string $filename
   * @param string $path
   */
  public function __construct( $filename = 'public/bower.json', $path = __FILE__ ) {

    if (empty($this->bower)) {
      $bower_path = plugin_dir_path( dirname( $path ) ) . $filename;
      $this->bower = new Wp_Ng_JsonManifest($bower_path);
    }

    if (empty($this->bower_admin)) {
      $bower_path = plugin_dir_path( dirname( $path ) ) . 'admin/bower.json';
      $this->bower_admin = new Wp_Ng_JsonManifest($bower_path);
    }

  }


 /**
  * @return null|Wp_Ng_JsonManifest
  */
  public function get() {
      return $this->bower;
  }

  /**
   * @param $name
   *
   * @return array|mixed|null
   */
  public function get_version( $name, $admin = false ) {

    if ( $admin === true ) {
      $bower = $this->bower_admin;
    }
    else {
      $bower = $this->bower;
    }

    $version = explode( '#', $bower->get_path('dependencies.' . $name) );

    return ( isset($version[1]) ) ? $version[1] : $version[0];
  }

  /**
   * @param $dependency
   * @param $fallback
   *
   * @return mixed
   */
  public function map_to_cdn($dependency, $fallback, $version = '') {

    if( !isset($dependency['name']) || !isset($dependency['file']) || !isset($dependency['cdn']) ) {
      return $fallback;
    }

    $templates = [
      'jquery'        => '//code.jquery.com/%file%',
      'jquery-migrate'=> '//code.jquery.com/%file%',
      'google-angular'=> '//ajax.googleapis.com/ajax/libs/%name%js/%version%/%file%',
      'google'        => '//ajax.googleapis.com/ajax/libs/%name%/%version%/%file%',
      'cloudflare'    => '//cdnjs.cloudflare.com/ajax/libs/%name%/%version%/%file%',
    ];

    if (!$version) {
      $version = $this->get_version($dependency['name']);
    }

    if (isset($version) && preg_match('/^(\d+\.){2}\d+$/', $version)) {
      $search = ['%name%', '%version%', '%file%'];
      $replace = [$dependency['name'], $version, $dependency['file']];
      return str_replace($search, $replace, $templates[$dependency['cdn']]);
    } else {
      return $fallback;
    }
  }

}
