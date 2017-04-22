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

    $conditions = array_map([$this, 'checkConditions'], $this->conditions);

    if (in_array(true, $conditions)) {
      $this->result = true;
    }
  }


  private function checkConditions( $conditions ) {

    $conditions_or = explode('|', $conditions);

    $result = false;

    foreach ( $conditions_or as $condition_or ) {

      $conditions_and = explode('&', $condition_or);
      //And Conditions
      if ( sizeof($conditions_and) > 1 ) {

        foreach ( $conditions_and as $condition_and ) {

          $result = $this->checkCondition($condition_and);

          if( !$result ) {
            break;
          }
        }
      }
      else {
        //Or Conditions
        $result = $this->checkCondition($condition_or);
      }

      if( $result ) {
        break;
      }
    }

    return apply_filters('wp_ng_check_condition', $result, $conditions);
  }


  private function checkCondition( $condition ) {

    $condition_args = explode('$', $condition);

    $condition = (isset($condition_args[0])) ? $condition_args[0] : '';

    unset($condition_args[0]);

    if (function_exists($condition)) {

      $result = call_user_func_array($condition, $condition_args);

      if( $result === true || $result === 'true' ) {
        return true;
      }
    }

    return false;
  }

}
