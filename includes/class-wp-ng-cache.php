<?php

/**
 * The cache script and style functionality of the plugin.
 *
 * @link       http://redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/includes
 */


/**
 * The cache scripts and style functionality of the plugin.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Cache {

  private $basename;
  private $suffix;
  private $base;
  private $content = '';

  private $dirname = '';

  /**
   * The Dist directory contains all final script and style.
   * @since    1.0.0
   */
  const CACHE_DIR =  'cache/';

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   */
  public function __construct( $basename, $suffix = '' , $dirname = '', $dest_path = '') {

    $this->basename = $basename;
    $this->suffix = $suffix;
    $this->dirname = $dirname;
    $this->base = ( $dest_path ) ? trailingslashit(trailingslashit($dest_path) . $dirname) : self::cache_dir($dirname) ;

  }


  /**
   * Combine handles file cache
   *
   * @param $handles
   * @return bool|string
   */
  public function combine ( $handles, $cahe_hours = 1 ) {

    if ( is_array($handles) && count($handles) > 0 ) {

      //Create dir if not exist and check if file exist in cache
      $basename = $this->get_basename_crc32_from_src( $handles );
      $filename = trailingslashit($this->base) . $basename;

      $this->remove_cache_file( $filename, $cahe_hours );

      if (wp_mkdir_p($this->base) && !file_exists($filename)) {

        $this->content = '';

        //combine content for each handle
        foreach ($handles as $handle => $src) {

          // Load the content of the css file
          $_local_path_src = $this->get_local_path($src);

          if( $_local_path_src ) {
            $_content = '/*! ' . $handle . ' */' . PHP_EOL . file_get_contents( $this->get_local_path($src) ) . PHP_EOL . PHP_EOL;

            //Replace relative url in css file to abs url (for resolve relative url in css url with combine cache in different directory).
            $_filename = pathinfo( $_local_path_src );
            if( $_filename['extension'] === 'css' ) {
              $_src_url = trailingslashit(dirname($src));
              $_content = self::css_rel2abs($_content, $_src_url);
            }

            $this->content .= $_content;
          }
        }

        //Write file
        if ($file_handle = @fopen($filename, 'w')) {
          fwrite($file_handle, $this->content);
          fclose($file_handle);

          return $basename;
        }

        return false;
      }

      return $basename;
    }

    return false;
  }

  /**
   * Create Json file cache
   * @param $data
   * @return bool|string
   */
  public function create_json ( $data ) {

    if ( is_array($data) && count($data) > 0 ) {

      //Create dir if not exist and check if file exist in cache
      $basename = $this->get_basename_crc32( $data );
      $filename = trailingslashit($this->base) . $basename;

      if (wp_mkdir_p($this->base) && !file_exists($filename) ) {

        $this->content = json_encode( $data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);

        //Write file
        if ($file_handle = @fopen($filename, 'w')) {
          fwrite($file_handle, $this->content);
          fclose($file_handle);

          return $basename;
        }

        return false;
      }

      return $basename;
    }

    return false;
  }


  /**
   * Cache directory
   *
   * @param string $file
   * @param bool $src
   * @return string
   */
  static public function cache_dir ( $dirname = '', $file = '', $src = false ) {
    $upload_dir = wp_upload_dir();
    $base = ($src === true) ? $upload_dir['baseurl'] : $upload_dir['basedir'];

    $base = trailingslashit( trailingslashit( $base ) . $dirname ) . self::CACHE_DIR . $file;

    if ( !$src ) {
      $base = wp_normalize_path( $base );
    }

    return $base;
  }

  /**
   * Replace css url relative to absolute form source url
   * Source from http://stackoverflow.com/questions/7922098/how-to-recalculate-the-css-url-paths-when-moving-it-to-a-different-folder
   * @param $content
   * @param $source_url
   *
   * @return mixed
   */
  static function css_rel2abs( $content, $source_url ) {
    $change_prefix = $source_url;

    $content = preg_replace_callback(
      '/
            @import\\s+
            (?:url\\(\\s*)?     # maybe url(
            [\'"]?              # maybe quote
            (.*?)               # 1 = URI
            [\'"]?              # maybe end quote
            (?:\\s*\\))?        # maybe )
            ([a-zA-Z,\\s]*)?    # 2 = media list
            ;                   # end token
            /x',
      function( $m ) use ( $change_prefix ) {
        $url = $change_prefix.$m[1];
        $url = str_replace('/./', '/', $url);
        do {
          $url = preg_replace('@/(?!\\.\\.?)[^/]+/\\.\\.@', '/', $url, 1, $changed);
        } while( $changed );
        return "@import url('$url'){$m[2]};";
      },
      $content
    );
    $content = preg_replace_callback(
      '/url\\(\\s*([^\\)\\s]+)\\s*\\)/',
      function( $m ) use ( $change_prefix ) {
        // $m[1] is either quoted or not
        $quote = ($m[1][0] === "'" || $m[1][0] === '"')
          ? $m[1][0]
          : '';
        $url = ($quote === '')
          ? $m[1]
          : substr($m[1], 1, strlen($m[1]) - 2);

        if( '/' !== $url[0] && strpos( $url, '//') === FALSE ) {
          $url = $change_prefix . $url;
          $url = str_replace('/./', '/', $url);
          do {
            $url = preg_replace('@/(?!\\.\\.?)[^/]+/\\.\\.@', '', $url, 1, $changed);
          } while( $changed );
        }
        return "url({$quote}{$url}{$quote})";
      },
      $content
    );
    return $content;
  }

  /**
   * Get basename file name with crc32 in hex format from handles source files
   * @param $handles
   * @return string
   */
  private function get_basename_crc32_from_src ( $handles ) {

    $files_time = array();
    foreach ($handles as $handle => $src) {
      $_local_path_src = $this->get_local_path($src);
      if ( $_local_path_src ) {
        $files_time[$handle] = strval( filemtime( $_local_path_src ) );
      }
    }

    return $this->get_basename_crc32( $files_time );
  }

  /**
   * Remove the cache file based on cache hours
   * @param $file
   * @param $cahe_hours
   * @return bool
   */
  private function remove_cache_file ( $filename, $cahe_hours ) {

    if ( file_exists($filename) && ((filemtime( $filename ) + ($cahe_hours * 3600)) < current_time('timestamp') ) ) {
      unlink($filename);
      return true;
    }

    return false;
  }

  /**
   * Get basename file name with crc32 in hex format from array
   * @param array $data
   * @return string
   */
  private function get_basename_crc32 ( $data = array() ) {

    $crc32 = dechex(crc32(serialize($data)));
    return sprintf( '%s-%s%s', basename($this->basename, $this->suffix ), $crc32, $this->suffix );
  }

  /**
   * Get the local path from url
   *
   * @param $url
   *
   * @return mixed false|string
   */
  private function get_local_path( $url ) {
    $urlParts = parse_url($url);

    //Search file in filenames array
    $filenames = array();
    $filenames[] = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $urlParts['path'];
    $filenames[] = ABSPATH . $urlParts['path'];

    foreach ( $filenames as $filename) {
      $filename = wp_normalize_path($filename);

      if ( file_exists( $filename ) ) {
        return $filename;
      }
    }

    return false;
  }


}
