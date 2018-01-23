<?php
/**
 * Video Url Parser
 *
 * From source: https://gist.github.com/astockwell/11055104
 *
 * Parses URLs from major cloud video providers. Capable of returning
 * keys from various video embed and link urls to manipulate and
 * access videos in various ways.
 */
class VideoUrlParser
{
  /**
   * Determines which cloud video provider is being used based on the passed url.
   *
   * @param string $url The url
   * @return null|string Null on failure to match, the service's name on success
   */
  public static function identify_service($url)
  {
    if (preg_match('%youtube|youtu\.be%i', $url)) {
      return 'youtube';
    }
    elseif (preg_match('%vimeo%i', $url)) {
      return 'vimeo';
    }
    return null;
  }

  /**
   * Determines which cloud video provider is being used based on the passed url,
   * and extracts the video id from the url.
   *
   * @param string $url The url
   * @return null|string Null on failure, the video's id on success
   */
  public static function get_url_id($url)
  {
    $service = self::identify_service($url);

    if ($service == 'youtube') {
      return self::get_youtube_id($url);
    }
    elseif ($service == 'vimeo') {
      return self::get_vimeo_id($url);
    }
    return null;
  }

  /**
   * Determines which cloud video provider is being used based on the passed url,
   * extracts the video id from the url, and builds an embed url.
   *
   * @param string $url The url
   * @return null|string Null on failure, the video's embed url on success
   */
  public static function get_url_embed($url)
  {
    $service = self::identify_service($url);

    $id = self::get_url_id($url);

    if ($service == 'youtube') {
      return self::get_youtube_embed($id);
    }
    elseif ($service == 'vimeo') {
      return self::get_vimeo_embed($id);
    }
    return null;
  }

  /**
   * Parses various youtube urls and returns video identifier.
   *
   * @param string $url The url
   * @return string the url's id
   */
  public static function get_youtube_id($url)
  {
    $youtube_url_keys = array('v','vi');

    // Try to get ID from url parameters
    $key_from_params = self::parse_url_for_params($url, $youtube_url_keys);
    if ($key_from_params) return $key_from_params;

    // Try to get ID from last portion of url
    return self::parse_url_for_last_element($url);
  }

  /**
   * Builds a Youtube embed url from a video id.
   *
   * @param string $youtube_video_id The video's id
   * @return string the embed url
   */
  public static function get_youtube_embed($youtube_video_id, $autoplay = 1)
  {
    $embed = "http://youtube.com/embed/$youtube_video_id?autoplay=$autoplay";

    return $embed;
  }

  /**
   * Parses various vimeo urls and returns video identifier.
   *
   * @param string $url The url
   * @return string The url's id
   */
  public static function get_vimeo_id($url)
  {
    // Try to get ID from last portion of url
    return self::parse_url_for_last_element($url);
  }

  /**
   * Builds a Vimeo embed url from a video id.
   *
   * @param string $vimeo_video_id The video's id
   * @return string the embed url
   */
  public static function get_vimeo_embed($vimeo_video_id, $autoplay = 1)
  {
    $embed = "http://player.vimeo.com/video/$vimeo_video_id?byline=0&amp;portrait=0&amp;autoplay=$autoplay";

    return $embed;
  }

  /**
   * Find the first matching parameter value in a url from the passed params array.
   *
   * @access private
   *
   * @param string $url The url
   * @param array $target_params Any parameter keys that may contain the id
   * @return null|string Null on failure to match a target param, the url's id on success
   */
  private static function parse_url_for_params($url, $target_params)
  {
    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_params );
    foreach ($target_params as $target) {
      if (array_key_exists ($target, $my_array_of_params)) {
        return $my_array_of_params[$target];
      }
    }
    return null;
  }

  /**
   * Find the last element in a url, without any trailing parameters
   *
   * @access private
   *
   * @param string $url The url
   * @return string The last element of the url
   */
  private static function parse_url_for_last_element($url)
  {
    $url_parts = explode("/", $url);
    $prospect = end($url_parts);
    $prospect_and_params = preg_split("/(\?|\=|\&)/", $prospect);
    if ($prospect_and_params) {
      return $prospect_and_params[0];
    } else {
      return $prospect;
    }
    return $url;
  }
}
?>
