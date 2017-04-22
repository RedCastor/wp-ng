# [wp-ng](http://redcastor.io)

wp-ng is a plugin to automatic bootstrap your app and inject module in app.

## Features

* Automatic bootstrapper angular application.
* Activate modules by settings page like wordpress plugins page
* Register your module with standard function "wp_enqueue_script". Add prefix 'wp-ng_' to handle and add dependencie of 'wp-ng'.
* Register your module with filter "wp_ng_register_ng_modules".
* Combine script in queue for "wp-ng_" handle prefix.
* Combine style in queue for "wp-ng_" handle prefix.
* Collection of default modules registered (example: ngRessource, ngRoute, ngAnimate, ui.bootstrap, mm.foundation,  ...).
* Compatibility module ngResource with wp rest api. For this feature there is a angular module "wpNgRest".

## Brief Doc API

Automatic bootstrapper angular application with combine script and style in cache.
The cache file is create in /uploads/wp-ng/cache/. 
The angular modules is include only if the handle start with prefix 'wp-ng_' and the dependencie egal 'wp-ng'. 
The combine js and css include all script and style started with prefix 'wp-ng_'.
The process to combine all style change all relative url to absolute url.

## Default Registered modules script

| **handle**                   | **dep** | **module name**         | **version** |
| -----------------------------|---------|-------------------------|-------------|
| wp-ng_ngRoute                | wp-ng   | ngRoute                 | 1.6.4       |
| wp-ng_ngSanitize             | wp-ng   | ngSanitize              | 1.6.4       |
| wp-ng_ngAnimate              | wp-ng   | ngAnimate               | 1.6.4       |
| wp-ng_ngResource             | wp-ng   | ngResource              | 1.6.4       |
| wp-ng_ngCookies              | wp-ng   | ngCookies               | 1.6.4       |
| wp-ng_ngMessages             | wp-ng   | ngMessages              | 1.6.4       |
| wp-ng_ngTouch                | wp-ng   | ngTouch                 | 1.6.4       |
| wp-ng_ui.bootstrap           | wp-ng   | ui.bootstrap            | 2.1.4       |
| wp-ng_mm.foundation          | wp-ng   | mm.foundation           | 0.11.15     |
| wp-ng_ui.router              | wp-ng   | ui.router               | 0.3.1       |
| wp-ng_pascalprecht.translate | wp-ng, wp-ng_angular-translate-loader-static-files   | pascalprecht.translate  | 1.0.0       |
| wp-ng_offClick               | wp-ng   | offClick                | 1.0.8       |
| wp-ng_nya.bootstrap.select   | wp-ng   | nya.bootstrap.select    | 2.1.9       |
| wp-ng_ngDialog               | wp-ng   | ngDialog                | 0.6.4       |
| wp-ng_smoothScroll           | wp-ng   | smoothScroll            | 2.0.0       |
| wp-ng_ngScrollbars           | wp-ng   | ngScrollbars            | 0.0.11      |
| wp-ng_slick                  | wp-ng   | slick                   | 0.2.1       |
| wp-ng_slickCarousel          | wp-ng   | slickCarousel           | 3.1.7       |
| wp-ng_ngMagnify              | wp-ng   | ngMagnify               | *           |
| wp-ng_infinite-scroll        | wp-ng   | infinite-scroll         | 1.3.4       |
| wp-ng_ui-leaflet             | wp-ng   | ui-leaflet              | master      |
| wp-ng_wpNgRest               | wp-ng   | wpNgRest                | 1.0.0       |
| wp-ng_nemLogging             | wp-ng   | nemLogging              | 0.1.7       |
| wp-ng_duScroll               | wp-ng   | duScroll                | 1.0.0       |
| wp-ng_pageslide-directive    | wp-ng   | pageslide-directive     | 2.1.1       |
| wp-ng_ui.mask                | wp-ng   | ui.mask                 | 1.8.7       |
| wp-ng_ui.validate            | wp-ng   | ui.validate             | 1.2.2       |
| wp-ng_ui.grid                | wp-ng   | ui.grid                 | 3.2.9       |
| wp-ng_ui.select              | wp-ng   | ui.select               | 0.19.6      |
| wp-ng_ngAntimoderate         | wp-ng   | ngAntimoderate          | 1.0.4       |
| wp-ng_ngGeonames             | wp-ng   | ngGeonames              | 1.0.8       |
| wp-ng_socialLinks            | wp-ng   | socialLinks             | 0.0.23      |
| wp-ng_720kb.socialshare      | wp-ng   | 720kb.socialshare       | 2.3.7       |
| wp-ng_ngFileUpload           | wp-ng   | ng-file-upload          | 12.2.13     |
| wp-ng_angular-loading-bar    | wp-ng   | angular-loading-bar     | 0.9.0       |
| wp-ng_angular-svg-round-progressbar| wp-ng | angular-svg-round-progressbar | 0.4.8 |
| wp-ng_ngStorage              | wp-ng   | ngstorage               | 0.3.11      |
| wp-ng_xeditable              | wp-ng   | angular-xeditable       | 0.5.0       |
| wp-ng_ngTagsInput            | wp-ng   | ng-tags-input           | 3.1.1       |
| wp-ng_oc.lazyLoad            | wp-ng   | oc.lazyLoad             | 1.0.9       |
| wp-ng_angularLazyImg         | wp-ng   | angularLazyImg          | 1.2.2       |
| wp-ng_breakpointApp          | wp-ng   | breakpointApp           | master      |
| wp-ng_bs.screenSize          | wp-ng   | bs.screenSize           | 1.0.5       |
| wp-ng_angularProgressbar     | wp-ng   | angularProgressbar      | 0.1.0       |
| wp-ng_hl.sticky              | wp-ng   | hl.sticky               | 0.3.0       |
| wp-ng_focus-if               | wp-ng   | focus-if                | 1.0.7       |
| wp-ng_LiveSearch             | wp-ng   | LiveSearch              | 0.2.0       |
| wp-ng_satellizer             | wp-ng   | satellizer              | 0.15.5      |
| wp-ng_angular-translate-loader-static-files | wp-ng_pascalprecht.translate | angular-translate-loader-static-files | 2.13.0 |
| wp-ng_bootstrap              | jquery  |                         | 3.3.7       |
| wp-ng_foundation             | jquery  |                         | 6.3.0       |
| wp-ng_mm.foundation-motion-ui | jquery  |                        | 1.2.2       |
| wp-ng_es6-shim               |         |                         | 0.35.3      |


## Default Registered modules styles

| **handle**                 | **dep**     | **version**    |
| ---------------------------| ------------|----------------|
| wp-ng_ngAnimate            | wp-ng       | 0.0.4          |
| wp-ng_bootstrap            |             | 3.3.7          |
| wp-ng_foundation           |             | 6.3.0          |
| wp-ng_foundation-flex      |             | 6.3.0          |
| wp-ng_font-awesome         |             | 4.6.3          |
| wp-ng_nya.bootstrap.select | wp-ng       | 2.1.9          |
| wp-ng_ngDialog             | wp-ng       | 0.6.4          |
| wp-ng_ngScrollbars         | wp-ng       | 0.0.11         |
| wp-ng_slick                | wp-ng       | 0.2.1          |
| wp-ng_slick-theme          | wp-ng_slick | 0.2.1          |
| wp-ng_slickCarousel        | wp-ng       | 3.1.7          |
| wp-ng_slickCarouselTheme   | wp-ng_slickCarousel | 3.1.7  |
| wp-ng_ngMagnify            | wp-ng       | *              |
| wp-ng_ui-leaflet           | wp-ng       | master         |
| wp-ng_ui.grid              | wp-ng       | 3.2.9          |
| wp-ng_ui.select            | wp-ng       | 0.19.6         |
| wp-ng_angular-loading-bar  | wp-ng       | 0.9.0          |
| wp-ng_xeditable            | wp-ng       | 0.5.0          |
| wp-ng_ngTagsInput          | wp-ng       | 3.1.1          |
| wp-ng_pageslide-directive  | wp-ng       | 2.1.1          |
| wp-ng_hl.sticky            | wp-ng       | 0.3.0          |
| wp-ng_LiveSearch           | wp-ng       | 0.2.0          |

## Hook Filters

| **hook**                     | **Description**                                       | **Param**                     |
| -----------------------------| ------------------------------------------------------| ------------------------------|
| wp_ng_exclude_handles_module | Exclude a handle for script and style                 | array of handles              |
| wp_ng_register_ng_modules    | Register a angular module (Name of the angular module)| array of modules              |
| wp_ng_%module-name%_config   | Filter to pass configuration                          | array of config               |
| wp_ng_app_env                | Filter to pass environment param                      | array of env                  | 
| wp_ng_app_config             | Filter to pass config param                           | array of config               |
| wp_ng_app_element            | Bootstrap your the app on the body element by default.| string of angular element     |
| wp_ng_settings_fields        | Page Settings fields (descriptor array)               | array of fields               |
| wp_ng_get_option             | Get the option value                                  | string name, section, default |
| wp_ng_get_options            | Get the options values                                | section                       |
| wp_ng_get_active_modules     | Get the active modules                                | array of handles              |
| wp_ng_register_external_modules | Register a module in the list for active later by admin settings page |  array of modules descriptor |

## Theme Support

Add in your functions.php this snippet to force the angular app name and force to active modules. 
In the Settings page the setting App Name is set to readonly and the second line active modules ans set to readonly.
```php
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
```

## Plugin Support
Add in your plugin this snippet to force active module. 
```php
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
```

## Example

Load Module included in wp-ng with default wordpress function
```php
<?php
wp_enqueue_script('wp-ng_slick');
wp_enqueue_style('wp-ng_slick');

wp_enqueue_script('wp-ng_ui-leaflet');
wp_enqueue_style('wp-ng_ui-leaflet');
```

Add your Module in wp-ng
```php
<?php
wp_enqueue_script( 'wp-ng_myModule', '/my-module.js', array('wp-ng'), null, true );
wp_enqueue_style( 'wp-ng_myModule', '/my-module.css', array('wp-ng'), null, 'all' );

wp_enqueue_script( 'wp-ng_app', '/your_app.js', array('wp-ng'), null, true );
```

or with filter 'wp_ng_register_ng_modules':
```php
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
```

Multiple module in one js. This is possible with concat angular module name with '+' : "wp-ng_moduleService1+moduleService2"
```php
<?php
wp_enqueue_script( 'wp-ng_moduleService1+moduleService2', '/module.js', array('wp-ng'), null, true );
```

Register External Modules
```php
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
```

Add Config to module
```php
<?php
add_filter('wp_ng_myModule_config', function ( $config ) {

  $config['l10n'] = array(
    'title' => __( 'My Title', 'my-domain'),            // Translation
  );
  $config['restNamespace'] = 'v1/my-route';             // Rest Api route
  $config['partialUrl'] = 'http://domain.com/partials'; //Template html url

  return $config;
});
```

## Example Script
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

## Internal Angular Filters

wp-ng include generic angular filters

  * html
  * isEmpty

wp-ng include generic angular directives

  * ng-bind-html-compile
  * if-module-loaded
  
```html
<div data-ng-bing-html="content | html"></div>
<div data-ng-hide="data | isEmpty"></div>
```
