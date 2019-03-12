<?php
/**
 * Source From https://github.com/kamranahmedse/php-geocode
 */
namespace Google_Geocode;

/**
 * A wrapper around Google's Geocode API that parses the address,
 * to get different details regarding the address
 *
 * @author  Kamran Ahmed <kamranahmed.se@gmail.com>
 * @license http://www.opensource.org/licenses/MIT
 * @version v2.0
 */
class Geocode
{
  /**
   * API URL through which the address will be obtained.
   */
  private $serviceUrl = "://maps.googleapis.com/maps/api/geocode/json?";

  /**
   * Array containing the query results
   */
  private $serviceResults;

  /**
   * Constructor
   *
   * @param string $key Google Maps Geocoding API key
   */
  public function __construct($key = '')
  {
    $this->serviceUrl = (!empty($key))
        ? 'https' . $this->serviceUrl . "key={$key}"
        : 'http' . $this->serviceUrl;
  }

  /**
   * Returns the private $serviceUrl
   *
   * @return string The service URL
   */
  public function getServiceUrl()
  {
    return $this->serviceUrl;
  }

  /**
   * Sends request to the passed Google Geocode API URL and fetches the address details and returns them
   *
   * @param $address
   *
   * @return   bool|object false if no data is returned by URL and the detail otherwise
   * @throws   \Exception
   * @internal param string $url Google geocode API URL containing the address or latitude/longitude
   */
  public function get($address)
  {
    if (!empty($address)) {

      $url = $this->getServiceUrl() . "&address=" . urlencode($address);
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $serviceResults = curl_exec($ch);

      $serviceResultsObj = json_decode($serviceResults);

      if ($serviceResultsObj && $serviceResultsObj->status === 'OK') {
        $this->serviceResults = $serviceResultsObj;

        return new Location($address, $this->serviceResults);
      }

    }

    return new Location($address, new \stdClass);
  }
}
