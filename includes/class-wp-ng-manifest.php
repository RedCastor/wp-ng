<?php

/**
 * Manifest
 *
 * @link       http://redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */

/**
 * Manifest
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_JsonManifest {

  private $manifest;

  /**
   * Wp_Ng_JsonManifest constructor.
   *
   * @param $manifest_path
   */
  public function __construct($manifest_path) {
      if (file_exists($manifest_path)) {
          $this->manifest = json_decode(file_get_contents($manifest_path), true);
      } else {
          $this->manifest = [];
      }
  }

  /**
   * Get
   *
   * @return array
   */
  public function get() {
      return $this->manifest;
  }

  /**
   * Get path
   *
   * @param string $key
   * @param null $default
   *
   * @return array|mixed|null
   */
  public function get_path($key = '', $default = null) {
      $collection = $this->manifest;
      if (is_null($key)) {
          return $collection;
      }
      if (isset($collection[$key])) {
          return $collection[$key];
      }
      foreach (explode('.', $key) as $segment) {
          if (!isset($collection[$segment])) {
              return $default;
          } else {
              $collection = $collection[$segment];
          }
      }
      return $collection;
  }

}
