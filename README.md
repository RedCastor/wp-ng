# [wp-ng](http://redcastor.io)

wp-ng is a plugin to automatic bootstrap your app and inject module in app.

## Features

* New Compatibility with Elementor plugin (https://wordpress.org/plugins/elementor)
* New Support Rollbar logging (https://rollbar.com)
* New Shortcodes for galleries, form, map, social
* New angular modules
* New built-in directive, decorator form directive
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

| **handle**                   | **dep** | **module name**         | **version** | **old version**  |
| -----------------------------|---------|-------------------------|-------------|------------------|
| wp-ng_ngRoute                | wp-ng   | ngRoute                 | 1.7.4      |                  |
| wp-ng_ngSanitize             | wp-ng   | ngSanitize              | 1.7.4       |                  |
| wp-ng_ngAnimate              | wp-ng   | ngAnimate               | 1.7.4       |                  |
| wp-ng_ngResource             | wp-ng   | ngResource              | 1.7.4       |                  |
| wp-ng_ngCookies              | wp-ng   | ngCookies               | 1.7.4       |                  |
| wp-ng_ngMessages             | wp-ng   | ngMessages              | 1.7.4       |                  |
| wp-ng_ngTouch                | wp-ng   | ngTouch                 | 1.7.4       |                  |    
| wp-ng_ui.bootstrap           | wp-ng   | ui.bootstrap            | 2.5.0       | 2.1.4            |
| wp-ng_mm.foundation          | wp-ng   | mm.foundation           | 0.11.5     |                   |
| wp-ng_ui.router              | wp-ng   | ui.router               | 0.4.2       | 0.3.1            |
| wp-ng_pascalprecht.translate | wp-ng, wp-ng_angular-translate-loader-static-files   | pascalprecht.translate  | 2.17.0 | 2.13.1 |
| wp-ng_offClick               | wp-ng   | offClick                | 1.0.8       |                  |
| wp-ng_nya.bootstrap.select   | wp-ng   | nya.bootstrap.select    | 2.1.9       |                  |
| wp-ng_oi.select              | wp-ng   | oi.select               | 0.2.21      |                  |
| wp-ng_ngDialog               | wp-ng   | ngDialog                | 1.4.0       |                  |
| wp-ng_smoothScroll           | wp-ng   | smoothScroll            | 2.0.0       |                  |
| wp-ng_ngTinyScrollbar        | wp-ng   | ngTinyScrollbar         | 0.10.1      |                  |
| wp-ng_ngScrollbars           | wp-ng   | ngScrollbars            | 0.0.11      |                  |
| wp-ng_slick                  | wp-ng   | slick                   | 0.2.1       |                  |
| wp-ng_slickCarousel          | wp-ng   | slickCarousel           | 3.1.7       |                  |
| wp-ng_angular-owl-carousel-2 | wp-ng   | angular-owl-carousel-2  | *           |                  |
| wp-ng_ngMagnify              | wp-ng   | ngMagnify               | 0.0.2       |                  |
| wp-ng_infinite-scroll        | wp-ng   | infinite-scroll         | 1.3.4       |                  |
| wp-ng_ui-leaflet             | wp-ng   | ui-leaflet              | 2.0.0       |                  |
| wp-ng_wpNgRest               | wp-ng   | wpNgRest                | 1.0.0       |                  |
| wp-ng_nemLogging             | wp-ng   | nemLogging              | 0.1.7       |                  |
| wp-ng_duScroll               | wp-ng   | duScroll                | 1.0.0       |                  |
| wp-ng_pageslide-directive    | wp-ng   | pageslide-directive     | 2.2.0       | 2.1.5            |
| wp-ng_ngGeonames             | wp-ng   | ngGeonames              | 1.1.0       |                  |
| wp-ng_ngAntimoderate         | wp-ng   | ngAntimoderate          | 1.1.5       |                  |
| wp-ng_ngColorUtils           | wp-ng   | ngColorUtils            | 1.0.0       |                  |
| wp-ng_trTrustpass            | wp-ng   | trTrustpass             | 0.4.0       |                  |
| wp-ng_ui.mask                | wp-ng   | ui.mask                 | 1.8.7       |                  |
| wp-ng_ui.validate            | wp-ng   | ui.validate             | 1.2.2       |                  |
| wp-ng_ui.grid                | wp-ng   | ui.grid                 | 3.2.9       |                  |
| wp-ng_ui.select              | wp-ng   | ui.select               | 0.19.6      |                  |
| wp-ng_ui.swiper              | wp-ng   | ui.swiper               | 2.3.8       |                  |
| wp-ng_ui.event               | wp-ng   | ui.event                | 1.0.0       |                  |
| wp-ng_ngAntimoderate         | wp-ng   | ngAntimoderate          | 1.0.6       | 1.0.5            |
| wp-ng_ngGeonames             | wp-ng   | ngGeonames              | 1.0.8       |                  |
| wp-ng_socialLinks            | wp-ng   | socialLinks             | 0.0.23      |                  |
| wp-ng_720kb.socialshare      | wp-ng   | 720kb.socialshare       | 2.3.7       |                  |
| wp-ng_720kb.tooltips         | wp-ng   | 720kb.tooltips          | 1.2.2       |                  |
| wp-ng_ngFileUpload           | wp-ng   | ng-file-upload          | 12.2.13     |                  |
| wp-ng_angular-loading-bar    | wp-ng   | angular-loading-bar     | 0.9.0       |                  |
| wp-ng_angular-svg-round-progressbar| wp-ng | angular-svg-round-progressbar | 0.4.8 |              |
| wp-ng_angularjs-gauge        | wp-ng   | angularjs-gauge         | 2.0.1       |                  |
| wp-ng_ngStorage              | wp-ng   | ngstorage               | 0.3.11      |                  |
| wp-ng_xeditable              | wp-ng   | angular-xeditable       | 0.5.0       |                  |
| wp-ng_ngTagsInput            | wp-ng   | ng-tags-input           | 3.1.1       |                  |
| wp-ng_oc.lazyLoad            | wp-ng   | oc.lazyLoad             | 1.0.9       |                  |
| wp-ng_angularLazyImg         | wp-ng   | angularLazyImg          | 1.2.2       |                  |
| wp-ng_breakpointApp          | wp-ng   | breakpointApp           | master      |                  |
| wp-ng_bs.screenSize          | wp-ng   | bs.screenSize           | 1.0.5       |                  |
| wp-ng_angularProgressbar     | wp-ng   | angularProgressbar      | 0.1.0       |                  |
| wp-ng_hl.sticky              | wp-ng   | hl.sticky               | 0.3.0       |                  |
| wp-ng_focus-if               | wp-ng   | focus-if                | 1.0.7       |                  |
| wp-ng_LiveSearch             | wp-ng   | LiveSearch              | 0.2.0       |                  |
| wp-ng_angular-img-cropper    | wp-ng   | angular-img-cropper     | 1.2.6       |                  |
| wp-ng_rcDialog               | wp-ng   | rcDialog                | 1.0.4       |                  |
| wp-ng_rcMedia                | wp-ng   | rcMedia                 | 1.0.0-alpha13|                 |
| wp-ng_Gallery                | wp-ng   | rcGallery               | 1.1.1       | 1.0.7            |
| wp-ng_rcGalleria             | wp-ng   | rcGalleria              | 1.0.0       |                  |
| wp-ng_webicon                | wp-ng   | webicon                 | 0.10.7      |                  |
| wp-ng_rcRollbar              | wp-ng   | rcRollbar               | 2.3.9       | 2.1.0            |
| wp-ng_jtt_aping              | wp-ng   | jtt_aping               | 1.4.1       |                  |
| wp-ng_jtt_aping_instagram    | wp-ng   | jtt_aping_instagram     | 0.7.7       |                  |
| wp-ng_jtt_aping_facebook     | wp-ng   | jtt_aping_facebook      | 0.7.8       |                  |
| wp-ng_jtt_aping_codebird     | wp-ng   | jtt_aping_codebird      | 0.7.8       |                  |
| wp-ng_jtt_aping_flickr       | wp-ng   | jtt_aping_flickr        | 0.7.9       |                  |
| wp-ng_jtt_aping_tumblr       | wp-ng   |jtt_aping_tumblr         | 0.7.8       |                  |
| wp-ng_jtt_aping_wikipedia    | wp-ng   | jtt_aping_wikipedia     | 0.5.0       |                  |
| wp-ng_jtt_aping_dailymotion  | wp-ng   | jtt_aping_dailymotion   | 0.7.10      |                  |
| wp-ng_jtt_aping_vimeo        | wp-ng   | jtt_aping_vimeo         | 0.7.8       |                  |
| wp-ng_jtt_aping_youtube      | wp-ng   | jtt_aping_youtube       | 0.7.12      |                  |
| wp-ng_jtt_aping_openweathermap | wp-ng | jtt_aping_openweathermap | 0.8.0      |                  | 
| wp-ng_vButton                | wp-ng   | vButton                 | 1.1.1       |                  |
| wp-ng_vAccordion             | wp-ng   | vAccordion              | 1.6.0       |                  |
| wp-ng_vModal                 | wp-ng   | vModal                  | 1.3.7       |                  |
| wp-ng_vTabs                  | wp-ng   | vTabs                   | 0.2.0       |                  |
| wp-ng_vTextfield             | wp-ng   | vTextfield              | 0.1.4       |                  |
| wp-ng_ng-sweet-alert         | wp-ng   | ng-sweet-alert          | 1.0.11      |                  |
| wp-ng_angular.backtop        | wp-ng   | angular.backtop         | 0.0.5       |                  | 
| wp-ng_ngLocationSearch       | wp-ng   | ngLocationSearch        | 1.0.2       |                  | 
| wp-ng_bgf.paginateAnything   | wp-ng   | bgf.paginateAnything    | 4.2.0       |                  |
| wp-ng_angularGrid            | wp-ng   | angularGrid             | 0.6.5       |                  |
| wp-ng_ngImageDimensions      | wp-ng   | ngImageDimensions       | 1.1.0       |                  | 
| wp-ng_angular-gridster2      | wp-ng   | angular-gridster2       | 1.18.0      |                  |   
| wp-ng_duParallax             | wp-ng   | duParallax              | 0.2.0       |                  |
| wp-ng_angular-nicescroll     | wp-ng   | angular-nicescroll      | 0.0.9       |                  |
| wp-ng_dragularModule         | wp-ng   | dragularModule          | 4.4.6       |                  |
| wp-ng_ng-slide-down          | wp-ng   | ng-slide-down           | 1.2.0       |                  |
| wp-ng_angular.vertilize      | wp-ng   | angular.vertilize       | 1.0.1       |                  |
| wp-ng_ngScrollSpy            | wp-ng   | ngScrollSpy             | 3.2.2       |                  |     
| wp-ng_angular-flatpickr      | wp-ng   | angular-flatpickr       | 3.4.0       |                  |
| wp-ng_snapscroll             | wp-ng   | snapscroll              | 1.3.1       |                  |
| wp-ng_swipe                  | wp-ng   | swipe                   | 0.2.1       |                  | 
| wp-ng_ismobile               | wp-ng   | ismobile                | 1.1.0       |                  |
| wp-ng_angular-inview         | wp-ng   | angular-inview          | 1.1.0       |                  |
| wp-ng_ngAntimoderate         | wp-ng   | ngAntimoderate          | 1.1.7       |                  |
| wp-ng_angular-rateit         | wp-ng   | ngRateIt                | 4.0.2       |                  | 
| wp-ng_angular-translate-loader-static-files | wp-ng_pascalprecht.translate | angular-translate-loader-static-files | 2.13.0 | |
| wp-ng_bootstrap              | jquery  |                         | 3.3.7       |                  |
| wp-ng_foundation             | jquery  |                         | 6.3.0       |                  |
| wp-ng_mm.foundation-motion-ui | jquery  |                        | 1.2.2       |                  |
| wp-ng_es6-shim               |         |                         | 0.35.3      |                  |
| wp-ng_owl-carousel           | jquery  |                         | 2.2.1       |                  |
        

## Default Registered modules styles

| **handle**                 | **dep**     | **version**    |
| ---------------------------| ------------|----------------|
| wp-ng_ngAnimate            | wp-ng       | 0.0.4          |
| wp-ng_bootstrap            |             | 3.3.7          |
| wp-ng_foundation           |             | 6.3.0          |
| wp-ng_foundation-flex      |             | 6.3.0          |
| wp-ng_font-awesome         |             | 4.7.0          |
| wp-ng_valitycss            |             | 0.3.3          |
| wp-ng_nya.bootstrap.select | wp-ng       | 2.1.9          |
| wp-ng_oi.select            | wp-ng       | 0.2.21         |
| wp-ng_ngDialog             | wp-ng       | 0.6.4          |
| wp-ng_ngTinyScrollbar      | wp-ng       | 0.10.1         |
| wp-ng_ngScrollbars         | wp-ng       | 0.0.11         |
| wp-ng_slick                | wp-ng       | 0.2.1          |
| wp-ng_slick-theme          | wp-ng_slick | 0.2.1          |
| wp-ng_slickCarousel        | wp-ng       | 3.1.7          |
| wp-ng_slickCarouselTheme   | wp-ng_slickCarousel | 3.1.7  |
| wp-ng_angular-owl-carousel-2 | wp-ng     | *              |
| wp-ng_ngMagnify            | wp-ng       | *              |
| wp-ng_ui-leaflet           | wp-ng       | 2.0.0          |
| wp-ng_trTrustpass          | wp-ng       | 0.4.0          |
| wp-ng_ui.grid              | wp-ng       | 3.2.9          |
| wp-ng_ui.select            | wp-ng       | 0.19.6         |
| wp-ng_ui.swiper            | wp-ng       | 2.3.8          |
| wp-ng_angular-loading-bar  | wp-ng       | 0.9.0          |
| wp-ng_xeditable            | wp-ng       | 0.5.0          |
| wp-ng_ngTagsInput          | wp-ng       | 3.1.1          |
| wp-ng_pageslide-directive  | wp-ng       | 2.2.0          |
| wp-ng_hl.sticky            | wp-ng       | 0.3.0          |
| wp-ng_LiveSearch           | wp-ng       | 0.2.0          |
| wp-ng_rcMedia-dialog       | wp-ng       | 1.0.0-alpha13  |
| wp-ng_rcMedia-select       | wp-ng       | 1.0.0-alpha13  |
| wp-ng_rcMedia-zf           | wp-ng       | 1.0.0-alpha13  |
| wp-ng_vButton              | wp-ng, wp-ng_valitycss | 1.1.1 |
| wp-ng_vAccordion           | wp-ng, wp-ng_valitycss | 1.6.0 |
| wp-ng_vModal               | wp-ng, wp-ng_valitycss | 1.3.7 |
| wp-ng_vTabs                | wp-ng, wp-ng_valitycss | 0.2.0 |
| wp-ng_vTextfield           | wp-ng, wp-ng_valitycss | 0.1.4 |
| wp-ng_ng-sweet-alert       | wp-ng       | 1.0.11         |
| wp-ng_angular.backtop      | wp-ng       | 0.0.5          |
| wp-ng_angular-gridster2    | wp-ng       | 1.18.0         |   
| wp-ng_720kb.tooltips       | wp-ng       | 1.2.2          |


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
| wp_ng_get_module_options     | Get the options of the module.                        | empty value, module handle |
| wp_ng_get_module_option      | Get the option value of the module.                   | default value, option name, module handle |
| wp_ng_register_external_modules | Register a module in the list for active later by admin settings page |  array of modules descriptor |
| wp_ng_json_encode            | Encode to json format with single quote               | empty value and array         |
| wp_ng_json_decode            | Decode from json                                      | empty value and array         |
| wp_ng_json_encode_shortcode  | Same as wp_ng_json_encode but encode bracket (json array) to url encode | empty value and array |
| wp_ng_get_language           | Get Default and current Language. Compatibility with WPML | empty value               |
| wp_ng_current_language       | Get current Language. Compatibility with WPML         | empty value               |
| wp_ng_apply_translation      | Apply translation shortcodes WPML (Add string translation) | $atts, $default, $name, $domain
| wp_ng_create_onetime_nonce   | Create a one time nonce (for forms)                   | $empty_value, $action, $expiration |
| wp_ng_verify_onetime_nonce   | Verify a one time nonce (for forms)                   | $empty_value, $nonce, $action, $invalidate |
  
  
## Hook Actions

| **hook**                     | **Description**                                       | **Param**                     |
| -----------------------------| ------------------------------------------------------| ------------------------------|
| wp_ng_invalidate_onetime_nonce | Invalidate a one time nonce (for forms)             | $nonce                        |
    
## Theme Support

Add in your functions.php this snippet to force the angular app name and force to active modules. 
In the Settings page the setting App Name is set to readonly and the active modules is set to readonly.
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

## Example load modules with enqueue functions

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

## Example to register module

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
        '' => get_template_directory_uri() . '/scripts/module_script.js',
      ),
      'styles_src' => array(                          //Source url styles
        '' => get_template_directory_uri() . '/styles/module_style.css',
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

## Example module javascript

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

## Example application javascript

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

## Internal Angular Directives and Filters

wp-ng include generic angular filters

  * html
  * isEmpty

wp-ng include generic angular directives

  * ng-bind-html-compile
  * if-module-loaded
  * ng-update-hidden
  * password-match
  * numbers-only
  * initial-value
  * go-back
  * el-size, size-debounce
  
  ```html
  <div data-ng-bing-html="content | html"></div>
  <div data-ng-hide="data | isEmpty"></div>
  <div data-if-module-loaded="module_name"></div>
  <input type="hidden" name="item.Name" data-ng-model="item.Name" data-ng-update-hidden />
  <input type="text" name="item.Name" ng-model="item.Name" value="My initial text" data-initial-value />
  <input type="text" name="item.Name" ng-model="item.Name" data-initial-value="My initial text" />
  <button data-go-back>Go Back</button>
  ```
  
wp-ng form decorator (Force validation for all form)
 
 * $setTouched()
 * $validate()    
  
  ```html
  <div ng-controller="myController">
    <form name="myForm" ng-submit="submit()">
     
      <button type="submit">Submit</button>
    </form>
  </div>
  ```
    
  ```javascript
  $scope.submit = function () {
    $scope.myForm.$setTouched();
    $scope.myForm.$validate();
  }
  ```
