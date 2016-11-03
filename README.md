# [WP NG](http://redcastor.io)
[![build status](https://git.staglabel.be/wp-plugins/wp-ng/badges/master/build.svg)](https://git.staglabel.be/wp-plugins/wp-ng/commits/master)


WP NG is a plugin to automatic bootstrap your app and inject module in app.

## Features

* Automatic bootstrapper application.
* Register your module with standard function "wp_enqueue_script" and add dependencie of 'wp-ng'.
* Register your module with filter "wp_ng_register_handles_module".
* Combine script in queue for "wp-ng_" handle prefix.
* Combine style in queue for "wp-ng_" handle prefix.
* Collection of default modules registered (example: ngRessource, ngRoute, ngAnimate, ui.bootstrap, mm.foundation,  ...).
* Compatibility module ngResource with wp rest api. For this feature there is a angular module "wpNgRest".

## Brief Doc API

For exclude handle to automatic inject module in the angular app, you can use the script or style handle name 'wp-ng_app' or 
the app name to register in settings.

The combine js and css include only the handle with prefix 'wp-ng_'.
The ng modules include only the handle with dependencie of 'wp-ng'. 

## Default Registered modules script

| **handle**                   | **dep** | **module name**         | **version** |
| -----------------------------|---------|-------------------------|-------------|
| wp-ng_ngRoute                | wp-ng   | ngRoute                 | 1.5.8       |
| wp-ng_ngSanitize             | wp-ng   | ngSanitize              | 1.5.8       |
| wp-ng_ngAnimate              | wp-ng   | ngAnimate               | 1.5.8       |
| wp-ng_ngResource             | wp-ng   | ngResource              | 1.5.8       |
| wp-ng_ngCookies              | wp-ng   | ngCookies               | 1.5.8       |
| wp-ng_ngMessages             | wp-ng   | ngMessages              | 1.5.8       |
| wp-ng_ngTouch                | wp-ng   | ngTouch                 | 1.5.8       |
| wp-ng_ui.bootstrap           | wp-ng   | ui.bootstrap            | 2.1.4       |
| wp-ng_mm.foundation          | wp-ng   | mm.foundation           | 0.10.12     |
| wp-ng_ui.router              | wp-ng   | ui.router               | 0.3.1       |
| wp-ng_pascalprecht.translate | wp-ng   | pascalprecht.translate  | 1.0.0       |
| wp-ng_offClick               | wp-ng   | offClick                | 1.0.8       |
| wp-ng_nya.bootstrap.select   | wp-ng   | nya.bootstrap.select    | 2.1.9       |
| wp-ng_ngDialog               | wp-ng   | ngDialog                | 0.6.4       |
| wp-ng_smoothScroll           | wp-ng   | smoothScroll            | 2.0.0       |
| wp-ng_ngScrollbars           | wp-ng   | ngScrollbars            | 0.0.11      |
| wp-ng_slick                  | wp-ng   | slick                   | 0.2.1       |
| wp-ng_slickCarousel          | wp-ng   | slickCarousel           | 3.1.7       |
| wp-ng_ngInfiniteScroll       | wp-ng   | ngInfiniteScroll        | 0.0.1       |
| wp-ng_ui-leaflet             | wp-ng   | ui-leaflet              | master      |
| wp-ng_wpNgRest               | wp-ng   | wpNgRest                | 1.0.0       |
| wp-ng_nemLogging             | wp-ng   | nemLogging              | 0.1.7       |
| wp-ng_duScroll               | wp-ng   | duScroll                | 1.0.0       |
| wp-ng_pageslide-directive    | wp-ng   | pageslide-directive     | 2.1.1       |
| wp-ng_ui.validate            | wp-ng   | ui.validate             | 1.2.2       |
| wp-ng_ui.grid                | wp-ng   | ui.grid                 | 3.2.9       |
| wp-ng_ngPJAX                 | wp-ng   | ngPJAX                  | 0.0.2       |
| wp-ng_bootstrap              | jquery  |                         | 3.3.7       |
| wp-ng_foundation             | jquery  |                         | 6.2.3       |

## Default Registered modules styles

| **handle**                 | **dep**     | **version**    |
| ---------------------------| ------------|----------------|
| wp-ng_ngAnimate            | wp-ng       | 0.0.4          |
| wp-ng_bootstrap            |             | 3.3.7          |
| wp-ng_foundation           |             | 6.2.3          |
| wp-ng_foundation-flex      |             | 6.2.3          |
| wp-ng_font-awesome         |             | 4.6.3          |
| wp-ng_nya.bootstrap.select | wp-ng       | 2.1.9          |
| wp-ng_ngDialog             | wp-ng       | 0.6.4          |
| wp-ng_ngScrollbars         | wp-ng       | 0.0.11         |
| wp-ng_slick                | wp-ng       | 0.2.1          |
| wp-ng_slickCarousel        | wp-ng       | 3.1.7          |
| wp-ng_ui-leaflet           | wp-ng       | master         |
| wp-ng_ui.grid              | wp-ng       | 3.2.9          |


## Example

Load Module include in wp-ng with default wordpress function
```php
<?php
wp_enqueue_script('wp-ng_slick');
wp_enqueue_style('wp-ng_slick');

wp_enqueue_script('wp-ng_ui-leaflet');
wp_enqueue_style('wp-ng_ui-leaflet');
```

Add Module in wp-ng
```php
<?php
wp_enqueue_script( 'wp-ng_myModule', '/my-module.js', array('wp-ng'), null, true );
wp_enqueue_style( 'wp-ng_myModule', '/my-module.css', array('wp-ng'), null, 'all' );

wp_enqueue_script( 'wp-ng_app', '/your_app.js', array('wp-ng'), null, true );
```

or with wordpress filter 'wp_ng_register_modules':
```php
<?php
add_filter('app_root_register_handles_module', function( $ng_handles ) {
  $ng_handles[] = 'wp-ng_myModule';
  
  return $ng_handles;
});
wp_enqueue_script( 'wp-ng_myModule', 'my-module.js', array(), null, true );
```

Multiple module in one js. This is possible with concat module name with '+' : "moduleService1+moduleService2"
```php
<?php
wp_enqueue_script( 'wp-ng_moduleService1+moduleService2', asset_path('scripts/module.js'), array('wp-ng'), null, true );
```

Add Config to module
```php
<?php
add_filter('wp_ng_myModule_config', function ( $config ) {

  $config['l10n'] = array(
    'title' => __( 'My Title', 'my-domain');
  ),
  $config['restNamespace'] = 'v1/my-route';
  $config['partialUrl'] = 'http://domain.com/partials';

  return $config;
});
```

Get Config and create module constant
```javascript
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
```

Example your_app.js
```javascript
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
```
