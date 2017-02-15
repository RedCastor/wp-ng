<?php

/**
 * Conditional
 *
 * @link       http://redcastor.io
 * @since      1.1.0
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
class Wp_Ng_Conditional {

  private $conditions;
  public $result = false;


  public function __construct( $conditions = [] ) {

    $this->conditions = $conditions;

    $conditions = array_map([$this, 'checkCondition'], $this->conditions);

    if (in_array(true, $conditions)) {
      $this->result = true;
    }
  }


  private function checkCondition( $condition ) {

    $conditions = explode('&', $condition);
    $result = true;

    foreach ( $conditions as $condition ) {

      $condition_function = explode('$', $condition);
      $condition = (isset($condition_function[0])) ? $condition_function[0] : '';
      $condition_arg = (isset($condition_function[1])) ? $condition_function[1] : null;

      if (function_exists($condition) && $result === true) {

        $result = $condition_arg ? $condition($condition_arg) : $condition();

        if( $result === false) {
          break;
        }
      }
      else {
        $result = false;
        break;
      }
    }

    return $result;
  }

}
