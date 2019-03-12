<?php
/**
 * Source From https://github.com/tuupola/php_google_maps
 */
namespace Google_Geocode;


class Bounds {

  protected $min_lng = 0;
  protected $min_lat = 0;
  protected $max_lng = 0;
  protected $max_lat = 0;

  /**
   * Class constructor.
   *
   * @param    array which can be mix of Google_Maps_Coordinate|Point objects.
   * @return   object
   */

  public function __construct( $location_list ) {

    /* Make sure everything is a coordinate. */
    $coordinate_list = array();
    foreach ($location_list as $location) {
      if (is_a($location, 'Location')) {
        $coordinate_list[] = $location;
      }
      else if (isset($location['lat']) && isset($location['lng'])) {
        $coordinate_list[] = new Location('', (object)array('lat' => floatval($location['lat']), 'lng' => floatval($location['lng'])));
      }
    }

    if (empty($coordinate_list)) {
      return;
    }

    $coordinate = array_pop($coordinate_list);
    $this->min_lng = $coordinate->getLongitude();
    $this->min_lat = $coordinate->getLatitude();
    $this->max_lng = $coordinate->getLongitude();
    $this->max_lat = $coordinate->getLatitude();

    foreach ($coordinate_list as $coordinate) {
      if ($coordinate->getLongitude() < $this->min_lng) {
        $this->min_lng = $coordinate->getLongitude();
      }
      if ($coordinate->getLongitude() > $this->max_lng) {
        $this->max_lng = $coordinate->getLongitude();
      }
      if ($coordinate->getLatitude() < $this->min_lat) {
        $this->min_lat = $coordinate->getLatitude();
      }
      if ($coordinate->getLatitude() > $this->max_lat) {
        $this->max_lat = $coordinate->getLatitude();
      }
    }

  }

  /**
   * Return north-west corner of bounds.
   *
   * @return mixed Google_Maps_Coordinate or Google_Maps_Point
   */

  public function getNorthWest($type='') {

    return array(
      'lat' => $this->max_lat,
      'lng' => $this->min_lng,
    );
  }

  /**
   * Return north-east corner of bounds.
   *
   * @return mixed Google_Maps_Coordinate or Google_Maps_Point
   */

  public function getNorthEast($type='') {

    return array(
      'lat' => $this->max_lat,
      'lng' => $this->max_lng,
    );
  }

  /**
   * Return souts-east corner of bounds.
   *
   * @return mixed Google_Maps_Coordinate or Google_Maps_Point
   */

  public function getSouthEast($type='') {

    return array(
      'lat' => $this->min_lat,
      'lng' => $this->max_lng,
    );
  }

  /**
   * Return south-west corner of bounds.
   *
   * @return mixed Google_Maps_Coordinate or Google_Maps_Point
   */

  public function getSouthWest($type='') {

    return array(
      'lat' => $this->min_lat,
      'lng' => $this->min_lng,
    );
  }


  /**
   * Check if given coordinate or point is inside bounds
   *
   * @return boolean
   */

  public function containsLocation( Location $location ) {
    $retval     = false;

    if ($location->getLongitude() < $this->max_lng && $location->getLongitude() > $this->min_lng &&
      $location->getLatitude() < $this->max_lat && $location->getLatitude() > $this->min_lat) {
      $retval = true;
    }
    return $retval;
  }


  /**
   * Returns array of path objects which can be used for drawing
   * borders of current bounds object into the static map. Can be
   * used for debugging.
   *
   * @return array of Google_Maps_Path
   */

  public function getPath() {
    return array(
      'northWest' => $this->getNorthWest(),
      'northEast' => $this->getNorthEast(),
      'southEast' => $this->getSouthEast(),
      'southWest' => $this->getSouthWest(),
      'northWest' => $this->getNorthWest()
    );
  }

}
