<?php

/**
 *  Wp NG Shortcode Parser
 *
 *  Class that will parse attribute shortocode to array multidimentitonal.
 *  __ double underscore is the separator for new item array.
 * - dash is convert to camel case.
 *
 * Example:
 *
 * options__fisrt_item="my_item"
 * option__enable=true
 * options_camel-case
 *
 * oprions = array(
 *   fisrt_item=>"my_item",
 *   enable: true,
 *   camelCase: false
 * )
 *
 *
 * @link       http://www.redcastor.io
 * @since      1.5.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public
 */

/**
 * Parser shortcode class
 *
 * @since      1.5.0
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Shortcode_Parser
{

  private $delimiter;
  private $attr_search;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.5.0
   */
  public function __construct() {

    $this->delimiter = '__';
    $this->attr_search = '';
  }

  /**
   * Set the search for filter array
   *
   * @param $search
   */
  public function set_filter_search( $search ) {
    $this->attr_search = $search;
  }

  /**
   * Callback for array_filter
   *
   * @param $key
   * @return bool
   */
  public function filter_array ($key) {
      return strpos($key, $this->attr_search) === 0;
  }

  /**
   * Callback for set type bool and numeric.
   *
   * @param $val
   * @return bool|float
   */
  public function map_type($val) {

    switch ($val) {
      case 'true':
        $val = true;
        break;
      case 'false':
        $val = false;
        break;
    }

    if (is_numeric($val)) {

      $_val = floatval($val);

      if ( $_val <= PHP_INT_MAX ) {
        $val = $_val;
      }
    }

    return $val;
  }


  /**
   * Parse All attributes based on
   * @param $atts
   * @return array
   */
  public function parse($atts, $atts_to_parse) {

    $data = array();

    foreach ( $atts_to_parse as $attr_key ){

      $attr_val = isset($atts[$attr_key]) ? $atts[$attr_key] : array();

      if (is_string($attr_val)) {
        $attr_val = wp_ng_json_decode($atts[$attr_key]);
      }

      $this->set_filter_search($attr_key . $this->delimiter);

      $atts_filtered = array_filter($atts, array($this, 'filter_array'), ARRAY_FILTER_USE_KEY);

      $data[$attr_key] = array_replace_recursive($attr_val, $this->attributes_to_array($atts_filtered, $attr_key . $this->delimiter, true));
    }

    return $data;
  }


  public function camel_case ( $val ) {

    return lcfirst(str_replace(' ', '', ucwords(strtr($val, '-', ' '))));
  }


  public function replace_keys( $atts, $search ) {

    foreach ($atts as $attr_key => $attr_val) {
      $pos = strpos($attr_key, $search);

      if ($pos === 0) {
        $new_attr_key = substr($attr_key, strlen($search));

        if ($new_attr_key !== $attr_key ) {
          $atts[$new_attr_key] = $attr_val;
          unset($atts[$attr_key]);
        }
      }
    }

    return $atts;
  }


  public function attributes_to_array( $atts, $search, $camel_case = true ) {

    $data = array();

    $this->set_filter_search( $search );

    $atts_filtered = array_filter($atts, array($this, 'filter_array'), ARRAY_FILTER_USE_KEY);

    $atts_filtered = $this->replace_keys($atts_filtered, $search);

    foreach ($atts_filtered as $attr_key => $attr_val) {
      $attr_keys = explode($this->delimiter, $attr_key);

      if ( count($attr_keys) > 1 ) {
        $attr_val = $this->attributes_to_array($atts_filtered, $attr_keys[0] . $this->delimiter, true);
      }

      $data_key = $attr_keys[0];

      if ($camel_case === true) {
        $data_key = $this->camel_case($data_key);
      }

      //Set map type
      $attr_val = $this->map_type($attr_val);

      //Parse if string is json.
      if (is_string($attr_val)) {
        $attr_decoded = wp_ng_json_decode(strval($attr_val));
        $attr_val = empty($attr_decoded) ? $attr_val : $attr_decoded;
      }

      $data[$data_key] = $attr_val;
    }

    return $data;
  }

}
