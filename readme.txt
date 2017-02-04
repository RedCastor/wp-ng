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
* wp-ng_ui.validate
* wp-ng_ui.grid
* wp-ng_ui.select
* wp-ng_ngAntimoderate
* wp-ng_ngGeonames
* wp-ng_socialLinks
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
* wp-ng_angularProgressbar
* wp-ng_hl.sticky
* wp-ng_focus-if


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

= Theme Support =

Add in your functions.php this snippet to force the angular app name. In the Settings page the setting App Name is set to readonly.

`
<?php
/**
 * Theme setup
 */
function setup() {
  add_theme_support('wp-ng_app_name', 'your_app.name');
}
add_action('after_setup_theme', 'setup');
?>
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

Add Module your in wp-ng

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

