<?php
/**
 * Start Angular Wrapper UI Router
 *
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/global/wrapper-ui-router-start.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.6.2
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

?>
<div class="wp-ng-fade">
  <div data-ng-if="selectView === ''" class="wp-ng-loading">
    <div class="wp-ng-loader spinner-ripple"><div></div><div></div></div>
  </div>
  <div data-ng-if="selectView !== 'base'">
    <div ui-view></div>
  </div>
  <div id="ng_router_base" data-ng-if="selectView === 'base'" >
