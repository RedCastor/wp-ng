=== Angular for WordPress ===
Contributors: redcastor
Tags: wp-ng, WP-NG, WPNG, wp ng, wpng, wp-angular, wp angular, wp-angularjs, wp angularjs, angular, angular js, AngularJs,  bootstrapper, bootstrap, module, ng, script, enqueue, rest, wp-rest, wp-api, ngResource, rollbar, Rollbar, logging, logs, logger
Requires at least: 4.5
Requires PHP: 5.6.31
Tested up to: 4.8
Stable tag: 1.5.0
License: MIT License
License URI: http://opensource.org/licenses/MIT


WP-NG is a plugin to automatic bootstrap angular application. Activate module by admin page and use directly directive.

== Description ==

WP-NG is a plugin to automatic bootstrap angular application. Activate module by admin page and use directly directive.

= Features =

* New Support Rollbar logging (https://rollbar.com)
* New Shortcodes for galleries, form, map, social
* New angular modules
* New built-in directive, decorator form directive
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
* wp-ng_oi.select
* wp-ng_ngDialog
* wp-ng_smoothScroll
* wp-ng_ngTinyScrollbar
* wp-ng_ngScrollbars
* wp-ng_slick
* wp-ng_slickCarousel
* wp-ng_angular-owl-carousel-2
* wp-ng_ngMagnify
* wp-ng_infinite-scroll
* wp-ng_ui-leaflet
* wp-ng_wpNgRest
* wp-ng_nemLogging
* wp-ng_duScroll
* wp-ng_pageslide-directive
* wp-ng_ui.mask
* wp-ng_ui.validate
* wp-ng_trTrustpass
* wp-ng_ui.grid
* wp-ng_ui.select
* wp-ng_ui.swiper
* wp-ng_ngAntimoderate
* wp-ng_ngGeonames
* wp-ng_socialLinks
* wp-ng_720kb.socialshare
* wp-ng_angular-translate-loader-static-files
* wp-ng_bootstrap
* wp-ng_foundation
* wp-ng_angular-loading-bar
* wp-ng_angular-svg-round-progressbar
* wp-ng_angularjs-gauge
* wp-ng_ngStorage
* wp-ng_xeditable
* wp-ng_ngTagsInput
* wp-ng_oc.lazyLoad
* wp-ng_angularLazyImg
* wp-ng_breakpointApp
* wp-ng_bs.screenSize
* wp-ng_ng.deviceDetector
* wp-ng_angularProgressbar
* wp-ng_hl.sticky
* wp-ng_focus-if
* wp-ng_LiveSearch
* wp-ng_satellizer
* wp-ng_angular-img-cropper
* wp-ng_rcDialog
* wp-ng_rcMedia
* wp-ng_rcGallery
* wp-ng_rcGalleria
* wp-ng_webicon
* wp-ng_rcRollbar
* wp-ng_jtt_aping
* wp-ng_jtt_aping_instagram
* wp-ng_jtt_aping_facebook
* wp-ng_jtt_aping_codebird
* wp-ng_jtt_aping_flickr
* wp-ng_jtt_aping_tumblr
* wp-ng_jtt_aping_wikipedia
* wp-ng_jtt_aping_dailymotion
* wp-ng_jtt_aping_vimeo
* wp-ng_jtt_aping_youtube
* wp-ng_jtt_aping_openweathermap
* wp-ng_vButton
* wp-ng_vAccordion
* wp-ng_vModal
* wp-ng_vTabs
* wp-ng_vTextfield
* wp-ng_ng-sweet-alert
* wp-ng_angular.backtop
* wp-ng_ngLocationSearch
* wp-ng_bgf.paginateAnything
* wp-ng_angularGrid
* wp-ng_ngImageDimensions
* wp-ng_angular-gridster2


= Default Registered modules styles =

List of handle available

* wp-ng_ngAnimate
* wp-ng_bootstrap
* wp-ng_foundation
* wp-ng_foundation-flex
* wp-ng_font-awesome
* wp-ng_nya.bootstrap.select
* wp-ng_oi.select
* wp-ng_ngDialog
* wp-ng_ngTinyScrollbar
* wp-ng_ngScrollbars
* wp-ng_slick
* wp-ng_slick-theme
* wp-ng_slickCarousel
* wp-ng_slickCarouselTheme
* wp-ng_angular-owl-carousel-2
* wp-ng_ngMagnify
* wp-ng_ui-leaflet
* wp-ng_trTrustpass
* wp-ng_ui.grid
* wp-ng_ui.select
* wp-ng_ui.swiper
* wp-ng_angular-loading-bar
* wp-ng_xeditable
* wp-ng_ngTagsInput
* wp-ng_pageslide-directive
* wp-ng_hl.sticky
* wp-ng_LiveSearch
* wp-ng_rcMedia-dialog
* wp-ng_rcMedia-select
* wp-ng_rcMedia-zf
* wp-ng_valitycss
* wp-ng_vButton
* wp-ng_vAccordion
* wp-ng_vModal
* wp-ng_vTabs
* wp-ng_vTextfield
* wp-ng_ng-sweet-alert
* wp-ng_angular.backtop
* wp-ng_angular-gridster2


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
* wp_ng_get_module_options
* wp_ng_get_module_option
* wp_ng_register_external_modules
* wp_ng_json_encode
* wp_ng_json_decode
* wp_ng_json_encode_shortcode
* wp_ng_get_language
* wp_ng_apply_translation
* wp_ng_create_onetime_nonce
* wp_ng_verify_onetime_nonce

= Hook Actions =
* wp_ng_invalidate_onetime_nonce




== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wp-ng` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->WP NG screen to configure the plugin

== Frequently Asked Questions ==


== Screenshots ==

1. Angular Modules.
2. Settings Page.
3. Logging Page.

== Frequently Asked Questions ==


== Upgrade Notice ==
Major Update.
* New feature logging with Rollbar
* New feature shortcodes for galleries, form, map, social
* New angular modules
* Update Angular v1.6.4
* Update angular foundation v0.11.5
* Update foundation to v6.3.1
* Update ui.bootstrap to v2.5.0

== Changelog ==

= 1.5.0 =
* Add wp-ng Built-in directives
* Add Module Rollbar
* Add Module Videogular
* Add Module rc-media module
* Add Module ngLocationSearch
* Add Module bgf.paginateAnything
* Add Module apiNG plugin instagram
* Add Module apiNG plugin facebook
* Add Module apiNG plugin flickr
* Add Module apiNG plugin tumblr
* Add Module apiNG plugin wikipedia
* Add Module apiNG plugin dailymotion
* Add Module apiNG plugin vimeo
* Add Module apiNG plugin youtube
* Add Module ngStickyFooter
* Add Module ngInput
* Add Module angular-sortable-view
* Add MutationObserver-shim for ngStickyFooter
* Various Bug bixing

= 1.4.0 =
* Update ngAntimoderate v1.0.4
* Update Angular v1.6.4
* Update angular foundation v0.11.5
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

