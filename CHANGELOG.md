### HEAD

### 1.4.0: April 22th, 2017
* Update ngAntimoderate v1.0.4
* Add filter wp_ng_get_active_modules
* Bug fix bower fallback

### 1.4-beta1: April 18th, 2017
* Update Angular v1.5.10 to v1.6.4
* Add module Authentication satellizer
* Bug fix js angular-social-share
* Bug fix bootstrap-screensize include dependencie of rt-debounce.
* Bug fix angular foundation 6 (mm.foundation) reveal on IE not working. To fix bug load dependencie es6-shim.js

### 1.3.10: April 17th, 2017
* Refactoring label for shortcode
* Add shortcode for checkbox. label can use content shortcode and html.
* Bug fix attribute without value.

### 1.3.9: April 14th, 2017
* Add on shortcode form ng-change.

### 1.3.8: April 14th, 2017
* Bug fix locale shortcode add en_US
* Add Shortcode alert
* Add input value and init attribute value="My default value"
* Fix no model in input with model="true" attribute in shortcode.

### 1.3.7: April 13th, 2017
* Add conditional or in the inline string conditions (condition|condition2)
* Fix conditional inline string (condition|condition2|condition3&condition4|condition5)
* Fix locationTools.decode
* Bug fix shortcode param
* Change name file shortcode
* Add shrotcode ng-form-select for form select
* Add shortcode nf-form-locale for create a select with locale available language.
* Add module angular ui mask

### 1.3.6: Marsh 31th, 2017
* wpNg add factory locationTools to encode and decode URI
* Add Generic URI Query on locationStart.

### 1.3.5: Marsh 31th, 2017
* Bug fix wp_ng_add_plugin_support on add mixed features with param and without param.
* Bug fix tiny mce editor.
* Small bug fix

### 1.3.4: Marsh 28th, 2017
* Add filter condition to load module. and refactoring to accept 2 param condition.

### 1.3.3: Marsh 27th, 2017
* Refactoring field settings name to label
* Add module social 720kb.socialshare.
* Add module videogular
* Add shortcode ng-directive start implementation.
* Add shortcode ng-socialshare (use module 720kb.socialshare)
* Add directive ifModuleLoaded. Example check ui-bootstrap module loaded or and mm.foundation module load.

### 1.3.2: Marsh 13th, 2017
* Update angular foundation v0.11.15
* Add workaround CSS for angular foundation tabs not working with foundation v6.3 

### 1.3.1: February 21th, 2017
* Add module bootstrap-screensize.

### 1.3.0: February 15th, 2017
* Add Shortcodes for Form (ng-form-input, ng-form-submit).
* Bug fix not found in queue script and style removed by deregister. Add dequeue before deregister.

### 1.2.16: February 13th, 2017
* Bug fix conditional to use function with args separate them with char '$' in the string.

### 1.2.15: February 13th, 2017
* Add wp_ng_current_plugin_supports for force active module in plugin

### 1.2.14: February 10th, 2017
* Move preload in wp-ng.js to add class on app element.
* bug fix action if ng-submit is defined

### 1.2.13: February 7th, 2017
* Bug fix jquery load jquery-core and jquery-migrate.
* Add cdn jquery-migrate with fallback
* Add options to disbale cdn angular and jquery

### 1.2.12: February 6th, 2017
* Workaround form not send if action not defined or action egual to base url. Force action to base url (woocommerce add to cart).
* Add module wp-ng_LiveSearch

### 1.2.11: February 4th, 2017
* Bug fix foundation init if not defined.

### 1.2.10: February 2th, 2017
* Bug fix bower get version with '#'
* Add accordion animation.

### 1.2.9: February 1th, 2017
* Add module ng-focus-if

### 1.2.8: January 31th, 2017
* Add angular module hl.sticky
* Bug fix module name in descriptor. All __dot__ not __DOT__

### 1.2.7: January 31th, 2017
* Reverse foundation load on run angular. Bug init drill menu in pageslide.

### 1.2.6: January 31th, 2017
* Bug fix load foundation. move load foundation on document ready.
* Workaround sticky on initialize.

### 1.2.5: January 30th, 2017
* Add options adavanced 
* Add option disable wpautop
* Add option disable tinymce verify html

### 1.2.4: January 23th, 2017
* Bug fix "register_external_modules" with style src not empty add subfield style to default on.

### 1.2.3: January 23th, 2017
* Update ng-antimoderate

### 1.2.2: January 5th, 2017
* Add on uninstall plugin delete options wp-ng

### 1.2.1: December 20th, 2016
* Add log and check foundation initialized
* Add settings app element

### 1.2.0: December 19th, 2016
* Update foundation 6.3.0

### 1.1.2: December 19th, 2016
* Add module angular-progressbar, angularjs-breakpoint

### 1.1.1: December 19th, 2016
* Add Angular module angular-svg-round-progressbar
* various fix

### 1.1.0: December 12th, 2016
* Settings page tab to auto load angular module

### 1.0.4: December 1th, 2016
* Add wp-ng generic directives
* Remove module angular html compile directive

### 1.0.3: November 29th, 2016
* Add some angular modules
* Update Readme

### 1.0.2: November 10th, 2016
* Update Readme

### 1.0.1: November 10th, 2016
* Update Readme

### 1.0.0: November 8th, 2016
* First Release

### 1.0-beta17: November 2th, 2016
* Add ng-cloak-animation

### 1.0-beta16: November 2th, 2016
* Add angular ngGeonames module
* Add angular ngAntimoderate module

### 1.0-beta15: October 17th, 2016
* Remove angular-pjax module

### 1.0-beta14: October 17th, 2016
* Add angular-pjax module

### 1.0-beta10: October 6th, 2016
* Add modules

### 1.0-beta9: October 5th, 2016
* Add compatibility wp rest api and wpml for rest api

### 1.0-beta8: September 8th, 2016
* Bug fix add field settings

### 1.0-beta7: September 7th, 2016
* Bug fix get_local_path for combine style and script

### 1.0-beta6: August 16th, 2016
* Small change wp-ng.js 
* Add notice minimum version of WP. 
* Add fr_FR
* get_option return default if option return false or empty string 

### 1.0-beta5: August 16th, 2016
* Various bug fix
* Add settings cache
* Refactor bootstrap angular app
* Add manage handle with multiple angular module in same script. Each module will be separate with '+' for enqueue the script.
* Add filter to exclude module default module exclude is 'wp-ng_app' and module name with the app name.
* Add dependency jquery for angular script

### 1.0-beta4: August 15th, 2016
* Various bug fix
* Add settings cache
* Refactor bootstrap angular app

### 1.0-beta3: August 9th, 2016
* Rename author and change link author to RedCastor
* Bug fix handle script or style not registered. Add check handle isset in registered array $wp_script and $wp_style 

### 1.0-beta2: August 8th, 2016
* Change action enqueue script to wp_head
* Add setting body cloak
* Add disable settings
* Add filter "wp_ng_app_config"
* Add in wpngRootConfig more configuration "baseUrl", "local", "debug", "env"

### 1.0-beta1: August 3th, 2016
* Start Project
