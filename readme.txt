=== Angular for WordPress ===
Contributors: redcastor
Tags: wp-ng, WP-NG, WPNG, wp ng, wp-angular, wp angular, angular, angular js, bootstrapper, bootstrap, module, ng, script, enqueue, rest, wp-rest, wp-api, ngResource
Requires at least: 4.5
Tested up to: 4.7
Stable tag: trunk
License: MIT License
License URI: http://opensource.org/licenses/MIT


WP-NG is a plugin to automatic bootstrap angular application. Activate module by admin page and use directly directive.

== Description ==

WP-NG is a plugin to automatic bootstrap angular application. Activate module by admin page and use directly directive.

= Features =

* Automatic bootstrapper angular application.
* Activate modules by settings page like wordpress plugins page.
* Collection of default modules registered (example: ngRessource, ngRoute, ngAnimate, ui.bootstrap, mm.foundation,  ...).
* Register your module with standard function "wp_enqueue_script". Add prefix 'wp-ng_' to handle and add dependencie of 'wp-ng'.
* Register your module with filter "wp_ng_register_ng_modules".
* Combine script in queue for "wp-ng_" handle prefix.
* Combine style in queue for "wp-ng_" handle prefix.
* Compatibility module ngResource with wp rest api. For this feature there is a angular module "wpNgRest".

= Brief Doc API =

Automatic bootstrapper angular application with combine script and style in cache.
The cache file is create in /uploads/wp-ng/cache/.
The angular modules is include only if the handle start with prefix 'wp-ng_' and the dependencie egal 'wp-ng'.
The combine js and css include all script and style started with prefix 'wp-ng_'.
The process to combine all style change all relative url to absolute url.

More Info view the github: https://github.com/RedCastor/wp-ng

= Default Registered modules script =

List of handle available

* wp-ng_ngRoute
* wp-ng_ngSanitize
* wp-ng_ngAnimate
* wp-ng_ngResource
* wp-ng_ngCookies
* wp-ng_ngMessages
* wp-ng_ngTouch
* wp-ng_ui.bootstrap
* wp-ng_mm.foundation
* wp-ng_ui.router
* wp-ng_pascalprecht.translate
* wp-ng_offClick
* wp-ng_nya.bootstrap.select
* wp-ng_ngDialog
* wp-ng_smoothScroll
* wp-ng_ngScrollbars
* wp-ng_slick
* wp-ng_slickCarousel
* wp-ng_ngMagnify
* wp-ng_infinite-scroll
* wp-ng_ui-leaflet
* wp-ng_wpNgRest
* wp-ng_nemLogging
* wp-ng_duScroll
* wp-ng_pageslide-directive
* wp-ng_ui.mask
* wp-ng_ui.validate
* wp-ng_ui.grid
* wp-ng_ui.select
* wp-ng_ngAntimoderate
* wp-ng_ngGeonames
* wp-ng_socialLinks
* wp-ng_720kb.socialshare
* wp-ng_angular-translate-loader-static-files
* wp-ng_bootstrap
* wp-ng_foundation
* wp-ng_angular-loading-bar
* wp-ng_angular-svg-round-progressbar
* wp-ng_ngStorage
* wp-ng_xeditable
* wp-ng_ngTagsInput
* wp-ng_oc.lazyLoad
* wp-ng_angularLazyImg
* wp-ng_breakpointApp
* wp-ng_bs.screenSize
* wp-ng_angularProgressbar
* wp-ng_hl.sticky
* wp-ng_focus-if
* wp-ng_LiveSearch
* wp-ng_satellizer


= Default Registered modules styles =

List of handle available

* wp-ng_ngAnimate
* wp-ng_bootstrap
* wp-ng_foundation
* wp-ng_foundation-flex
* wp-ng_font-awesome
* wp-ng_nya.bootstrap.select
* wp-ng_ngDialog
* wp-ng_ngScrollbars
* wp-ng_slick
* wp-ng_slick-theme
* wp-ng_slickCarousel
* wp-ng_slickCarouselTheme
* wp-ng_ngMagnify
* wp-ng_ui-leaflet
* wp-ng_ui.grid
* wp-ng_ui.select
* wp-ng_angular-loading-bar
* wp-ng_xeditable
* wp-ng_ngTagsInput
* wp-ng_pageslide-directive
* wp-ng_hl.sticky
* wp-ng_LiveSearch

= Hook Filters =

List of hook available

* wp_ng_exclude_handles_module
* wp_ng_register_ng_modules
* wp_ng_%module-name%_config
* wp_ng_app_env
* wp_ng_app_config
* wp_ng_app_element
* wp_ng_settings_fields
* wp_ng_get_option
* wp_ng_get_options
* wp_ng_get_active_modules
* wp_ng_register_external_modules

= Theme Support =

Add in your functions.php this snippet to force the angular app name. In the Settings page the setting App Name is set to readonly.

`
<?php
/**
 * Theme setup
 */
function setup() {
  add_theme_support('wp-ng_app_name', 'your_app.name');
  add_theme_support('wp-ng_modules', array(
        'ngAnimate',
        'ngSanitize',       //sanitize for $sce trusted ng-bind-html
        'ui__dot__bootstrap' => array( 'active' => 'on', 'style' => 'on', 'script' => 'bootstrap' ),
        'pascalprecht__dot__translate' => array(  'active' => 'on', 'script_static' => 'on'),
        'ui__dot__router'   //Change module name '.' to with '__dot__'
     )
  );
}
add_action('after_setup_theme', 'setup');
?>
`

= PLugin Support =

Add in your plugin this snippet to force active module.

`
<?php
/**
 * Plugin setup
 */
wp_ng_add_plugin_support( 'modules',
  array(
    'ngResource',
    'ngAnimate',
    'ui__dot__bootstrap' => array( 'active' => 'on', 'style' => 'on', 'script' => 'bootstrap' ),
  )
);
`

= Example =

Load Module included in wp-ng with default wordpress function

`
<?php
wp_enqueue_script('wp-ng_slick');
wp_enqueue_style('wp-ng_slick');

wp_enqueue_script('wp-ng_ui-leaflet');
wp_enqueue_style('wp-ng_ui-leaflet');
?>
`

Add your Module in wp-ng

`
<?php
wp_enqueue_script( 'wp-ng_myModule', '/my-module.js', array('wp-ng'), null, true );
wp_enqueue_style( 'wp-ng_myModule', '/my-module.css', array('wp-ng'), null, 'all' );

wp_enqueue_script( 'wp-ng_app', '/your_app.js', array('wp-ng'), null, true );
?>
`

or with filter 'wp_ng_register_ng_modules':

`
<?php
/**
 * Register only a Angular Module and not include the script in combine
 * (to combine the script add prefix 'wp-ng_' in the handle name).
 */
function register_ng_modules ( $ng_modules ) {

  $ng_modules[] = 'myModule';

  return $ng_modules;
}
add_filter('wp_ng_register_ng_modules', 'register_ng_modules');

wp_enqueue_script( 'myModule', 'my-module.js', array(), null, true );
?>
`

Multiple module in one js. This is possible with concat angular module name with '+' : "wp-ng_moduleService1+moduleService2"

`
<?php
wp_enqueue_script( 'wp-ng_moduleService1+moduleService2', '/module.js', array('wp-ng'), null, true );
?>
`

Register External Modules

`
<?php
/**
 * Register a Angular Module to module list (you can view in admin modules tab)
 */
function register_external_modules( $modules ) {

    $modules[] = array(
      'name'    => 'module_name',                     //Angular Module Name
      'label' => 'Label Module Name',                 //The Label Module Name
      'active'  => true,                              //Default active true or false
      'desc'    => 'The description of the module.',  //Description module
      'version' => $this->version,                    //Version module
      'scripts_src' => array(                         //Source url scripts
        '' => wp_rc_auth_get_asset_path( 'scripts/rc-auth.js' ),
      ),
      'styles_src' => array(                          //Source url styles
        '' => wp_rc_auth_get_asset_path( 'styles/rc-auth.css' ),
      ),
    );

    return $modules;
}
add_filter( 'wp_ng_register_external_modules',  'register_external_modules' );
`

Add Config to module

`
<?php
add_filter('wp_ng_myModule_config', function ( $config ) {

  $config['l10n'] = array(
    'title' => __( 'My Title', 'my-domain'),            // Translation
  );
  $config['restNamespace'] = 'v1/my-route';             // Rest Api route
  $config['partialUrl'] = 'http://domain.com/partials'; //Template html url

  return $config;
});
?>
`

= Example Script =

Get Config and create module constant

`
(function(angular, wpNg){
  'use strict';


  // Create my module
  var wpMyModule = angular.module('wpMyModule', [
    'wpNgRest'
  ]);


  var constant = {};

  if ( (angular.isDefined(wpNg.config.modules.wpMyModule) && angular.isObject(wpNg.config.modules.wpMyModule)) ) {
    constant = angular.extend(constant, wpNg.config.modules.wpMyModule);
  }


  // Constant my module
  wpMyModule.constant('WP_MY_MODULE_CONFIG', constant);

})(angular, wpNg);
`

Example your_app.js

`
(function(angular, wpNg){
  'use strict';

  var app = angular.module(wpNg.appName);


  //Run Application.
  app.run(['$rootScope', 'WP_NG_CONFIG', function ($log, WP_NG_CONFIG) {

    function init() {

        $log.info('Environment:     ' + WP_NG_CONFIG.env);
        $log.info('Version Theme:  V' + WP_NG_CONFIG.themeVersion);
        $log.info('Version Wp:     V' + WP_NG_CONFIG.wpVersion);
        $log.info('Debug Mode:      ' + WP_NG_CONFIG.debugEnabled);


    }

    init();

}]);

})(angular, wpNg);
`

= Internal Angular Filters =

wp-ng include generic angular filters

  * html
  * isEmpty

wp-ng include generic angular directives

  * ng-bind-html-compile
  * if-module-loaded

`
<div data-ng-bing-html="content | html"></div>
<div data-ng-hide="data | isEmpty"></div>
`


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Plugin Name screen to configure the plugin

== Frequently Asked Questions ==


== Screenshots ==

1. Angular Modules.
2. Settings Page.

== Frequently Asked Questions ==

== Upgrade Notice ==

== Changelog ==

= 1.4.0 =
* Update ngAntimoderate v1.0.4
* Update Angular v1.6.4
* Update angular foundation v0.11.15
* Update foundation to v6.3.1

* Add module social 720kb.socialshare.
* Add module videogular
* Add module vimeo and youtube module for videogular
* Add module Authentication satellizer
* Add module bootstrap-screensize
* Add module ui.mask

* Add directive ifModuleLoaded. Example check ui-bootstrap module loaded or and mm.foundation module load.
* Add factory locationTools to encode and decode URL.

* Add shortcode ng-socialshare (use module 720kb.socialshare)
* Add Shortcodes for Form (ng-form-input, ng-form-submit).
* Add shrotcode ng-form-select for form select
* Add shortcode ng-form-locale for create a select with locale available language.
* Add Shortcode alert

* Add filter wp_ng_get_active_modules
* Add filter wp_ng_register_external_modules
* Add function wp_ng_add_plugin_support
* Add Generic search URL Query on locationStart
  Example url: http://www.your-domain.com/#/?wpNgQuery={"service":"$log","call":"debug","params":["test"]}
  Example encoded url: http://www.your-domain.com/#/?wpNgQuery=%7B%22service%22%3A%22%24log%22%2C%22call%22%3A%22debug%22%2C%22params%22%3A%5B%22test%22%5D%7D

* Add conditional 'or' in the inline string conditions (condition|condition2)
* Add workaround CSS for angular foundation tabs not working with foundation v6.3

* Bug fix bower fallback
* Bug fix js angular-social-share
* Bug Fix conditional inline string (condition|condition2|condition3&condition4|condition5)
* Bug fix bootstrap-screensize include dependencie of rt-debounce.
* Bug fix angular foundation 6 (mm.foundation) reveal on IE not working. Load dependencie es6-shim.js
* Bug fix locale shortcode add en_US
* Bug fix not found in queue script and style removed by deregister. Add dequeue before deregister.
* Bug fix tiny mce editor.
* Bug fix wp_ng_add_plugin_support on add mixed features with param and without param.

* Refactoring Conditional to accepted multiple args.

= 1.2.16 =
* Bug fix conditional to use function with args separate them with char '$' in the string.

= 1.2.15 =
* Add wp_ng_current_plugin_supports for force active module in plugin

= 1.2.14 =
* Move preload in wp-ng.js to add class on app element.
* Bug fix action if ng-submit is defined

= 1.2.13 =
* Bug fix jquery load jquery-core and jquery-migrate.
* Add cdn jquery-migrate with fallback.
* Add options to disbale cdn angular and jquery.

= 1.2.12 =
* Workaround form not send if action not defined or action egual to base url. Force action to base url (woocommerce add to cart).
* Add module wp-ng_LiveSearch

= 1.2.11 =
* Bug fix foundation init if not defined.

= 1.2.10 =
* Add Modules list
* Activate or desactivate module on the admin.

= 1.0.2 =
* Update version readme
* Update Language FR

= 1.0.1 =
* Update readme

= 1.0.0 =
* First Release

