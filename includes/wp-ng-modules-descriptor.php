<?php

/**
 * The file that defines the modules fields descriptor
 *
 * @link       team@redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */


/**
 * Define modules fields
 */
function wp_ng_modules_fields( $fields = array() )
{

  //Todo Support ui-router Post types
  //$post_types = get_post_types( array('public'   => true,) );


  $fields['wp_ng_load_modules'] = array(
    'title' => __('Modules', 'wp-ng'),
    'sections' => array(
      'modules' => array(
        'title' => 'Load Angular Modules',
        'display'=> 'table',
        'actions' => array(
          array(
            'function_to_add' => array( 'Wp_Ng_Admin_Fields_Action', 'clean_wp_cache' ),
            'priority' => 100
          )
        ),
        'fields' => array(
          array(
            'name'  => 'rcRollbar',
            'label' => 'Angular Log Rollbar',
            'title' => 'rcRollbar',
            'desc'  => wp_ng_settings_sections_desc_html(
              'rc-rollbar',
              __( 'Angular wrapper for sending log to Rollbar.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/rc-rollbar',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'access_token',
                'placeholder' => 'Client Access Token',
                'default'     => '',
                'type'        => 'text',
              ),
              array(
                'name'        => 'track_error',
                'desc'        => 'Track Error',
                'default'     => 'on',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'track_warning',
                'desc'        => 'Track Warning',
                'default'     => 'on',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'track_debug',
                'desc'        => 'Track Debug',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'track_info',
                'desc'        => 'Track Info',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'        => 'angular-json-pretty',
            'label'       => 'Angular Json Pretty',
            'title'       => 'angular-json-pretty',
            'desc'        => wp_ng_settings_sections_desc_html(
              'angular-json-pretty',
              __( 'A directive make json object or string printed in human readable way.', 'wp-ng'),
              '',
              'https://github.com/leftstick/angular-json-pretty',
              'http://leftstick.github.io/angular-json-pretty/'
            ),
            'type'        => 'sub_fields',
            'sub_fields'  => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'        => 'ngRoute',
            'label'       => 'Angular Route',
            'title'       => 'ngRoute',
            'desc'        => wp_ng_settings_sections_desc_html(
              'angular-route',
              __( 'The ngRoute module provides routing and deeplinking services and directives for angular apps.', 'wp-ng'),
              '',
              'https://docs.angularjs.org/api/ngRoute',
              'http://embed.plnkr.co/dd8Nk9PDFotCQu4yrnDg/'
            ),
            'type'        => 'sub_fields',
            'sub_fields'  => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngSanitize',
            'label' => 'AngularSanitize',
            'title' => 'ngSanitize',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-sanitize',
              __( 'The ngSanitize module provides functionality to sanitize HTML.', 'wp-ng'),
              '',
              'https://docs.angularjs.org/api/ngSanitize',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngAnimate',
            'label' => 'Angular Animate',
            'title' => 'ngAnimate',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-animate',
              __( 'The ngAnimate module provides support for CSS-based animations (keyframes and transitions) as well as JavaScript-based animations via callback hooks.', 'wp-ng'),
              '',
              'https://docs.angularjs.org/api/ngAnimate',
              'http://theoinglis.github.io/ngAnimate.css'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'label_for'        => __( 'Load ngAnimate.css style.', 'wp-ng'),
                'default'     => 'ngAnimate',
                'type'        => 'select',
                'options'     => array(
                  ''                => __('No Style', 'wp-ng'),
                  'ngAnimate'      => 'Simple',
                  'ngAnimate-all'  => 'All',
                ),
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngResource',
            'label' => 'Angular Resource',
            'title' => 'ngResource',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-resource',
              __( 'The ngResource module provides interaction support with RESTful services via the $resource service.', 'wp-ng'),
              '',
              'https://docs.angularjs.org/api/ngResource',
              'http://codepen.io/akshay1713/pen/dGeGax'
              ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngCookies',
            'label' => 'Angular Cookies',
            'title' => 'ngCookies',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-cookies',
              __( 'The ngCookies module provides a convenient wrapper for reading and writing browser cookies.', 'wp-ng'),
              '',
              'https://docs.angularjs.org/api/ngCookies',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngStorage',
            'label' => 'Angular Storage',
            'title' => 'ngStorage',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ngstorage',
              __( 'An AngularJS module that makes Web Storage working in the Angular Way. Contains two services: $localStorage and $sessionStorage.', 'wp-ng'),
              '',
              'https://github.com/gsklee/ngStorage',
              'http://plnkr.co/edit/3vfRkvG7R9DgQxtWbGHz?p=preview'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngMessages',
            'label' => 'Angular Messages',
            'title' => 'ngMessages',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-messages',
              __( 'The ngMessages module provides enhanced support for displaying messages within templates.', 'wp-ng'),
              '',
              'https://docs.angularjs.org/api/ngMessages/directive/ngMessages',
              'http://plnkr.co/edit/ZAaObu?p=preview'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngTouch',
            'label' => 'Angular Touch',
            'title' => 'ngTouch',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-touch',
              __( 'The ngTouch module provides touch events and other helpers for touch-enabled devices.', 'wp-ng'),
              '',
              'https://docs.angularjs.org/api/ngTouch',
              'http://jsfiddle.net/ExpertSystem/zw6Uh'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'breakpointApp',
            'label' => 'Breakpoint Application',
            'title' => 'breakpointApp',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angularjs-breakpoint',
              __( 'Add the breakpoint directive to the body tag Define as many breakpoints as you want in an object Current breakpoint class and window width available in scope.', 'wp-ng'),
              '',
              'https://github.com/snapjay/angularjs-breakpoint',
              'http://snapjay.github.io/angularjs-breakpoint'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'bs__dot__screenSize',
            'label' => 'Bootstrap Screen Size',
            'title' => 'bs.screenSize',
            'desc'  => wp_ng_settings_sections_desc_html(
              'bootstrap-screensize',
              __( 'Angular v1.x module for screen width/height and Bootstrap\'s breakpoints. 
              Updates the properties on screen resize. 
              Configure the debounce rate for performance requirements.', 'wp-ng'),
              '',
              'https://github.com/jvdownie/bootstrap-screensize'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ismobile',
            'label' => 'is a mobile',
            'title' => 'ismobile',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-ismobile',
              __( 'A Angular wrapper provider-service for isMobile (https://github.com/kaimallea/isMobile).', 'wp-ng'),
              '',
              'https://github.com/ronnyhaase/angular-ismobile',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angular-inview',
            'label' => 'Visible viewport',
            'title' => 'angular-inview',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-inview',
              __( 'Check if a DOM element is or not in the browser current visible viewport.', 'wp-ng'),
              '',
              'https://github.com/thenikso/angular-inview',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ui__dot__bootstrap',
            'label' => 'Angular UI Bootstrap',
            'title' => 'ui.bootstrap',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-bootstrap',
              __( ' AngularJS directives specific to Bootstrap.', 'wp-ng'),
              '',
              'https://angular-ui.github.io/bootstrap',
              'https://angular-ui.github.io/bootstrap/#/accordion'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script',
                'label'       => 'Script',
                'label_for'        => __( 'Load Script.', 'wp-ng'),
                'default'     => '',
                'type'        => 'select',
                'options'     => array(
                  ''                => __('No Script', 'wp-ng'),
                  'bootstrap'      => 'Script Bootstrap',
                ),
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'label_for'        => __( 'Load style.', 'wp-ng'),
                'default'     => '',
                'type'        => 'select',
                'options'     => array(
                  ''                => __('No Style', 'wp-ng'),
                  'bootstrap'      => 'Style Bootstrap',
                ),
              ),
              array(
                'name'        => 'style_checkbox',
                'label'       => 'Style Awesome Checkbox',
                'desc'        => __( 'Load style awesome checkbox.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_font-awesome',
                'label'       => 'Style Font Awesome',
                'desc'        => __( 'Load style font awesome.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'mm__dot__foundation',
            'label' => 'Angular foundation 6',
            'title' => 'mm.foundation',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-foundation-6',
              __( 'This project is a port of the AngularUI team\'s excellent angular-bootstrap project for use in the Foundation framework.', 'wp-ng'),
              '',
              'https://circlingthesun.github.io/angular-foundation-6',
              'https://circlingthesun.github.io/angular-foundation-6/#!#accordion'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script',
                'label'       => 'Script',
                'label_for'        => __( 'Load Script.', 'wp-ng'),
                'default'     => '',
                'type'        => 'select',
                'options'     => array(
                  ''                => __('No Script', 'wp-ng'),
                  'foundation'      => 'Script Foundation',
                ),
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'label_for'        => __( 'Load style.', 'wp-ng'),
                'default'     => '',
                'type'        => 'select',
                'options'     => array(
                  ''                => __('No Style', 'wp-ng'),
                  'foundation'      => 'Style Foundation',
                  'foundation-flex' => 'Style Foundation Flex',
                ),
              ),
              array(
                'name'        => 'style_bs3-2-zf6',
                'label'       => 'Style Bootstrap 3 to Foundation 6',
                'desc'        => __( 'Load style bridge for bootstrap 3 (<a href="https://github.com/RedCastor/bs3-2-zf6" target="_blank">bs3-2-zf6</a>).', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_checkbox',
                'label'       => 'Style Awesome Checkbox',
                'desc'        => __( 'Load style awesome checkbox.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_font-awesome',
                'label'       => 'Style Font Awesome',
                'desc'        => __( 'Load style font awesome.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_fix',
                'label'       => 'Style Fix Foundation',
                'desc'        => __( 'Load style fix for angular foundation.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_motion-ui',
                'label'       => 'Style Motion UI',
                'desc'        => __( 'Load style motion-ui.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script_motion-ui',
                'label'       => 'Script Motion UI',
                'desc'        => __( 'Load script motion-ui.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ui__dot__router',
            'label' => 'Angular UI Router',
            'title' => 'ui.router',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-ui-router',
              __( 'Routing frameworks for SPAs update the browser\'s URL as the user navigates through the app.', 'wp-ng'),
              '',
              'https://ui-router.github.io/',
              'https://ui-router.github.io/sample-app-ng1'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'prevent_base_url',
                'label'       => 'Prevent Base Url',
                'desc'        => __('Enable prevent if is not base url', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'wrap',
                'label'       => __('Wrap Inner Element (selector)', 'wp-ng'),
                'default'     => '',
                'placeholder' => __('Selector', 'wp-ng') . ' ( #main )',
                'type'        => 'text',
              ),
              array(
                'name'        => 'wrap_exclude',
                'label'       => __('Exclude Wrap Inner Element (selector)', 'wp-ng'),
                'default'     => '',
                'placeholder' => __('Selector', 'wp-ng'),
                'type'        => 'text',
              ),
              array(
                'name'        => 'base_page_id',
                'label'       => __( 'Enter the id of the base page', 'wp-ng'),
                'desc'        => __( 'Enter the id of the base page', 'wp-ng'),
                'type'        => 'number',
                'default'     => 0,
              ),
              array(
                'name'        => 'routed_post_types',
                'label'       => __( 'Enable Routed Post Type', 'wp-ng'),
                'desc'        => __( 'Enable Routed Post Type', 'wp-ng'),
                'type'        => 'multiselect',
                'default'     => '',
                //'options'     => wp_parse_args($post_types, array()),
                'options'     => array('page' => 'Page')
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'pascalprecht__dot__translate',
            'label' => 'Angular Translate',
            'title' => 'pascalprecht.translate',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-translate',
              __( 'i18n for your Angular app, made easy!', 'wp-ng'),
              '',
              'https://angular-translate.github.io',
              'https://angular-translate.github.io'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script_static',
                'label'       => 'Script static files',
                'desc'        => __( 'Load script static files.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script_cookie',
                'label'       => 'Script storage cookie',
                'desc'        => __( 'Load script storage cookie.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'offClick',
            'label' => 'Off Click',
            'title' => 'offClick',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-off-click',
              __( 'It\'s like click, but when you don\'t click on your element.', 'wp-ng'),
              '',
              'https://github.com/TheSharpieOne/angular-off-click',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'nya__dot__bootstrap__dot__select',
            'label' => 'nya Bootstrap Select',
            'title' => 'nya.bootstrap.select',
            'desc'  => wp_ng_settings_sections_desc_html(
              'nya-bootstrap-select',
              __( 'nya-bootstrap-select v2 is an AngularJS directive set inspired by @silviomoreto \'s bootstrap-select .', 'wp-ng'),
              '',
              'http://nya.io/nya-bootstrap-select',
              'http://nya.io/nya-bootstrap-select/#!/examples/basic-usage'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'oi__dot__select',
            'label' => 'OI Select',
            'title' => 'oi.select',
            'desc'  => wp_ng_settings_sections_desc_html(
              'oi.select',
              __( 'AngularJS directive of select element.', 'wp-ng'),
              '',
              'https://github.com/tamtakoe/oi.select',
              'https://tamtakoe.github.io/oi.select/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngDialog',
            'label' => 'Angular Dialog',
            'title' => 'ngDialog',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-dialog',
              __( 'ngDialog is ~10KB (minified), has minimalistic API, is highly customizable through themes and has only AngularJS as dependency.', 'wp-ng'),
              '',
              'https://github.com/likeastore/ngDialog',
              'http://likeastore.github.io/ngDialog'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'smoothScroll',
            'label' => 'Smooth Scroll',
            'title' => 'smoothScroll',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ngSmoothScroll',
              __( 'A pure-javascript library and set of directives to scroll smoothly to an element with easing. Easing support contributed by Willem Liu with code from Gaëtan Renaudeau.', 'wp-ng'),
              '',
              'https://github.com/d-oliveros/ngSmoothScroll',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'scroll_by_id',
                'label'       => 'Scroll by element ID',
                'desc'        => __('Enable Scroll by element ID', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'duration',
                'placeholder' => __('Duration of scroll', 'wp-ng'),
                'default'     => '800',
                'type'        => 'number',
              ),
              array(
                'name'        => 'offset',
                'placeholder' => __('Offset end scroll', 'wp-ng'),
                'default'     => '0',
                'type'        => 'number',
              ),
              array(
                'name'        => 'easing',
                'label'       => 'Easing animation',
                'desc'        => __( 'Easing animation.', 'wp-ng'),
                'type'        => 'select',
                'default'     => 'easeOutQuart',
                'options'     => array(
                  'easeInQuad' => 'easeInQuad',
                  'easeOutQuad' => 'easeOutQuad',
                  'easeInOutQuad' => 'easeInOutQuad',
                  'easeInCubic' => 'easeInCubic',
                  'easeOutCubic' => 'easeOutCubic',
                  'easeInOutCubic' => 'easeInOutCubic',
                  'easeInQuart' => 'easeInQuart',
                  'easeOutQuart' => 'easeOutQuart',
                  'easeInOutQuart' => 'easeInOutQuart',
                  'easeInQuint' => 'easeInQuint',
                  'easeOutQuint' => 'easeOutQuint',
                  'easeInOutQuint' => 'easeInOutQuint',
                ),
              ),
              array(
                'name'        => 'offset_selector',
                'label'       => __('Offset selector', 'wp-ng'),
                'default'     => '.hl-sticky',
                'placeholder' => __('Selector', 'wp-ng') . ' ( .hl-sticky )',
                'type'        => 'text',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngTinyScrollbar',
            'label' => 'Angular Tiny Scroll Bar',
            'title' => 'ngTinyScrollbar',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ngTinyScrollbar',
              __( 'An angular directive port of the TinyScrollbar.', 'wp-ng'),
              '',
              'https://github.com/yads/ngTinyScrollbar',
              'https://yads.github.io/ngTinyScrollbar/demo.html'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngScrollbars',
            'label' => 'Angular Scroll Bars',
            'title' => 'ngScrollbars',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-scrollbars',
              __( 'This is a set of customized scrollbars for AngularJS that allows you to apply consistent styles and behavior across different browsers (including Firefox) that\'s built around Malihu\'s jQuery Custom Scrollbar by Manos Malihutsakis.', 'wp-ng'),
              '',
              'https://github.com/iominh/ng-scrollbars',
              'http://iominh.github.io/ng-scrollbars/18_update_scrollbars.html'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angular-nicescroll',
            'label' => 'Angular Nicescroll',
            'title' => 'angular-nicescroll',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-nicescroll',
              __( 'This directive is for jquery-nicescroll in angular js whithout writing single line of javascript code.', 'wp-ng'),
              '',
              'https://github.com/tushariscoolster/angular-nicescroll',
              'http://tushariscoolster.github.io/angular-nicescroll/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'duScroll',
            'label' => 'Angular Scroll',
            'title' => 'duScroll',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-scroll',
              __( 'Angular is only dependency (no jQuery). 8K minified or 2K gzipped.', 'wp-ng'),
              '',
              'https://github.com/oblador/angular-scroll',
              'http://oblador.github.io/angular-scroll'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'slick',
            'label' => 'Angular Slick Carousel 1',
            'title' => 'slick',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-slick',
              __( 'Angular directive for slick jquery carousel.', 'wp-ng'),
              '',
              'https://github.com/vasyabigi/angular-slick',
              'http://vasyabigi.github.io/angular-slick'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_theme',
                'label'       => 'Style Theme',
                'desc'        => __( 'Load Theme style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'admin_gallery',
                'label'       => 'Add admin gallery in create gallery',
                'desc'        => __( 'Add the admin media gallery in create gallery.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'slickCarousel',
            'label' => 'Angular Slick Carousel 2',
            'title' => 'slickCarousel',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-slick-carousel',
              __( 'Angular directive for slick-carousel.', 'wp-ng'),
              '',
              'https://github.com/devmark/angular-slick-carousel',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_theme',
                'label'       => 'Style Theme',
                'desc'        => __( 'Load Theme style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angularGrid',
            'label' => 'Angular Grid',
            'title' => 'angularGrid',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angulargrid',
              __( 'A Grid Pinterest like responsive masonry grid system for angular.', 'wp-ng'),
              '',
              'https://github.com/s-yadav/angulargrid',
              'http://ignitersworld.com/lab/angulargrid/index.html#demo'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngMagnify',
            'label' => 'Angular Magnify Zoom',
            'title' => 'ngMagnify',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-magnify',
              __( 'AngularJS directive for simple image magnification.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/ng-magnify',
              'https://redcastor.github.io/ng-magnify/examples/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'infinite-scroll',
            'label' => 'Infinite Scroll',
            'title' => 'infinite-scroll',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ngInfiniteScroll',
              __( 'ngInfiniteScroll is a directive for AngularJS to evaluate an expression when the bottom of the directive\'s element approaches the bottom of the browser window, which can be used to implement infinite scrolling.', 'wp-ng'),
              '',
              'https://sroze.github.io/ngInfiniteScroll/',
              'https://sroze.github.io/ngInfiniteScroll/demo_basic.html'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ui-leaflet',
            'label' => 'Angular UI leaflet MAP',
            'title' => 'ui-leaflet',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ui-leaflet',
              __( 'AngularJS directive for the Leaflet Javascript Library. This software aims to easily embed maps managed by Leaflet on your project.', 'wp-ng'),
              '',
              'http://angular-ui.github.io/ui-leaflet',
              'http://angular-ui.github.io/ui-leaflet/#!/examples/simple-map'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script_layers',
                'label'       => 'Script layers',
                'desc'        => __( 'Load script layers.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script_layer-google',
                'label'       => 'Script layer google map',
                'desc'        => __( 'Load script layer google map.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script_awesome-markers',
                'label'       => 'Script awesome markers',
                'desc'        => __( 'Load script awesome markers.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script_vector-markers',
                'label'       => 'Script vector markers',
                'desc'        => __( 'Load script vector markers.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style leaflet.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_awesome-markers',
                'label'       => 'Style awesome markers',
                'desc'        => __( 'Load style awesome markers.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_vector-markers',
                'label'       => 'Style vector markers',
                'desc'        => __( 'Load style vector markers.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'google_map_version',
                'placeholder' => 'Google Map version',
                'default'     => '3',
                'type'        => 'number',
              ),
              array(
                'name'        => 'google_map_key',
                'placeholder' => 'Google Map Application Key',
                'default'     => '',
                'type'        => 'text',
                'sanitize_callback' => 'sanitize_text_field',
              ),
              array(
                'name'        => 'mapbox_access_token',
                'placeholder' => 'mapbox access token',
                'default'     => '',
                'type'        => 'text',
                'sanitize_callback' => 'sanitize_text_field',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'wpNgRest',
            'label' => 'WP Angular Rest API',
            'title' => 'wpNgRest',
            'desc'  => wp_ng_settings_sections_desc_html(
              '',
              __( 'AngularJS provider to work with RESTful wordpress.', 'wp-ng'),
              WP_NG_PLUGIN_VERSION,
              '',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'isoCurrencies',
            'label' => 'WP Angular Iso Currencies',
            'title' => 'isoCurrencies',
            'desc'  => wp_ng_settings_sections_desc_html(
              '',
              __( 'AngularJS provider to work with woocommerce currency.', 'wp-ng'),
              WP_NG_PLUGIN_VERSION,
              '',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'nemLogging',
            'label' => 'Angular Log Levels',
            'title' => 'nemLogging',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-simple-logger',
              __( 'To have simplified log levels where a supporting angular module\'s log levels are independent of the application.', 'wp-ng'),
              '',
              'https://github.com/nmccready/angular-simple-logger',
              'http://nmccready.github.io/angular-simple-logger/example'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'pageslide-directive',
            'label' => 'Page Slide Directive',
            'title' => 'pageslide-directive',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-pageslide-directive',
              __( 'An AngularJS directive which slides another panel over your browser to reveal an additional interaction pane.', 'wp-ng'),
              '',
              'https://github.com/dpiccone/ng-pageslide',
              'http://dpiccone.github.io/ng-pageslide/examples'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'trTrustpass',
            'label' => 'Angular Trustpass',
            'title' => 'trTrustpass',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-trustpass',
              __( 'The trusty password security checklist. This is a simple password strength meter & validator inspired by MailChimp\'s signup form.', 'wp-ng'),
              '',
              'https://github.com/Trustroots/trustpass',
              'https://trustroots.github.io/trustpass/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ui__dot__validate',
            'label' => 'Angular UI Validate',
            'title' => 'ui.validate',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-ui-validate',
              __( 'General-purpose validator for ngModel.', 'wp-ng'),
              '',
              'https://github.com/angular-ui/ui-validate',
              'https://htmlpreview.github.io/?https://github.com/angular-ui/ui-validate/master/demo/index.html'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ui__dot__mask',
            'label' => 'Angular UI Mask',
            'title' => 'ui.mask',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-ui-mask',
              __( 'Apply a mask on an input field so the user can only type pre-determined pattern.', 'wp-ng'),
              '',
              'https://github.com/angular-ui/ui-mask',
              'https://htmlpreview.github.io/?https://github.com/angular-ui/ui-mask/master/demo/index.html'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'checklist-model',
            'label' => 'Angular Checkbox List',
            'title' => 'checklist-model',
            'desc'  => wp_ng_settings_sections_desc_html(
              'checklist-model',
              __( 'AngularJS directive for list of checkboxes.', 'wp-ng'),
              '',
              'https://github.com/vitalets/checklist-model',
              'http://vitalets.github.io/checklist-model/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ui__dot__grid',
            'label' => 'Angular UI Grid',
            'title' => 'ui.grid',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-ui-grid',
              __( 'An AngularJS data grid.', 'wp-ng'),
              '',
              'http://ui-grid.info',
              'http://ui-grid.info/docs/#/tutorial'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ui__dot__select',
            'label' => 'Angular UI Select',
            'title' => 'ui.select',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-ui-select',
              __( 'AngularJS select,search,... input.', 'wp-ng'),
              '',
              'http://angular-ui.github.io/ui-select',
              'http://angular-ui.github.io/ui-select/#examples'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style-selectize',
                'label'       => 'Style Selectize',
                'desc'        => __( 'Load style selectize.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ui__dot__select__dot__zf6',
            'label' => 'Angular UI-SELECT Zurb Foundation 6',
            'title' => 'ui.select.zf6',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ui-select-zf6',
              __( 'ui-select Foundation 6 ui-select Zurb Foundation 6. CSS Foundation 6.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/ui-select-zf6',
              'https://redcastor.github.io/ui-select-zf6/demo/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ui__dot__swiper',
            'label' => 'Angular UI Swiper',
            'title' => 'ui.swiper',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-ui-swiper',
              __( 'Most modern mobile touch slider for angular js.', 'wp-ng'),
              '',
              'https://github.com/nebulr/ui-swiper',
              'http://nebulr.github.io/ui-swiper/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'admin_gallery',
                'label'       => 'Add admin gallery in create gallery',
                'desc'        => __( 'Add the admin media gallery in create gallery.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ui__dot__event',
            'label' => 'Angular UI Event',
            'title' => 'ui.event',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-ui-event',
              __( 'Bind a callback to any event not natively supported by Angular. For Blurs, Focus, Double-Clicks or any other event you may choose that isn\'t built-in.', 'wp-ng'),
              '',
              'https://github.com/angular-ui/ui-event',
              'https://htmlpreview.github.io/?https://github.com/angular-ui/ui-event/master/demo/index.html'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngAntimoderate',
            'label' => 'Angular Image Lazyload',
            'title' => 'ngAntimoderate',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-antimoderate',
              __( 'Angular Antimoderate CSS3 filter.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/ng-antimoderate',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'wp_images',
                'label' 	  => 'wp images',
                'desc'        => __( 'Lazyload wp images (You must regenerate thumbnails for new image size micro)', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngGeonames',
            'label' => 'Angular Geonames',
            'title' => 'ngGeonames',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-geonames',
              __( 'Geonames ( http://www.geonames.org ) Based on ui-leaflet directive structure ( https://github.com/angular-ui/ui-leaflet ).', 'wp-ng'),
              '',
              'https://github.com/RedCastor/ng-geonames',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'username',
                'placeholder' => 'Username',
                'default'     => 'demo',
                'type'        => 'text',
                'sanitize_callback' => 'sanitize_text_field',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngColorUtils',
            'label' => 'Angular Color Utils',
            'title' => 'ngColorUtils',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-color-utils',
              __( 'Color Utils', 'wp-ng'),
              'This modules include factory hex2rgba',
              'https://github.com/RedCastor/ng-color-utils',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'socialLinks',
            'label' => 'Social Links',
            'title' => 'socialLinks',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-social-links',
              __( 'Flexible and easy social sharing directives for Twitter, Google Plus, Facebook, Pinterest, StumbleUpon, LinkedIn, and Reddit.', 'wp-ng'),
              '',
              'https://github.com/fixate/angular-social-links',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => '720kb__dot__socialshare',
            'label' => 'Social Share',
            'title' => '720kb.socialshare',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-social-links',
              __( 'Angular Socialshare is an angularjs directive for sharing urls and content on social networks such as (facebook, google+, twitter, pinterest and so on).', 'wp-ng'),
              '',
              'https://github.com/720kb/angular-socialshare',
              'https://720kb.github.io/angular-socialshare'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'via_facebook',
                'label'       => 'Facebook',
                'placeholder' => 'Facebook App ID',
                'default'     => '',
                'type'        => 'text',
              ),
              array(
                'name'        => 'via_twitter',
                'label'       => 'Twitter',
                'placeholder' => 'Twitter Username',
                'default'     => '',
                'type'        => 'text',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => '720kb__dot__tooltips',
            'label' => 'Angular Tooltips',
            'title' => '720kb.tooltips',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-tooltips',
              __( 'Angular Tooltips is an AngularJS directive that generates a tooltip on your element.', 'wp-ng'),
              '',
              'https://github.com/720kb/angular-tooltips',
              'https://720kb.github.io/angular-tooltips/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngFileUpload',
            'label' => 'Angular File Upload',
            'title' => 'ngFileUpload',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-file-upload',
              __( 'Lightweight Angular directive to upload files.', 'wp-ng'),
              '',
              'https://github.com/danialfarid/ng-file-upload',
              'https://angular-file-upload.appspot.com/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angular-loading-bar',
            'label' => 'Angular Loading Bar',
            'title' => 'angular-loading-bar',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-loading-bar',
              __( 'The idea is simple: Add a loading bar / progress bar whenever an XHR request goes out in angular.', 'wp-ng'),
              '',
              'https://github.com/chieffancypants/angular-loading-bar',
              'https://chieffancypants.github.io/angular-loading-bar'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angular-svg-round-progressbar',
            'label' => 'Angular SVG Round Progressbar',
            'title' => 'angular-svg-round-progressbar',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-svg-round-progressbar',
              __( 'AngularJS module that uses SVG to create a circular progressbar.', 'wp-ng'),
              '',
              'https://github.com/crisbeto/angular-svg-round-progressbar',
              'http://crisbeto.github.io/angular-svg-round-progressbar'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angularjs-gauge',
            'label' => 'Angular Gauge',
            'title' => 'angularjs-gauge',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angularjs-gauge',
              __( 'angular-gauge is a highly customizable gauge directive for Angular JS apps and dashboards. It provides multitude of options to customize as per your needs.', 'wp-ng'),
              '',
              'https://github.com/ashish-chopra/angular-gauge',
              'https://ashish-chopra.github.io/angular-gauge/#/demos'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angularProgressbar',
            'label' => 'Angular Progressbar',
            'title' => 'angularProgressbar',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-progressbar',
              '<a href="http://kimmobrunfeldt.github.io/progressbar.js" target="_blank">Progressbar.js</a>' . __( ' support for AngularJS.', 'wp-ng'),
              '',
              'https://github.com/felipecamposclarke/angular-progressbar',
              'http://kimmobrunfeldt.github.io/progressbar.js'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'xeditable',
            'label' => 'Angular-xeditable',
            'title' => 'xeditable',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-xeditable',
              __( 'Angular-xeditable is a bundle of AngularJS directives that allows you to create editable elements in your projects.', 'wp-ng'),
              '',
              'https://github.com/vitalets/angular-xeditable',
              'https://vitalets.github.io/angular-xeditable'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngTagsInput',
            'label' => 'Angular Tags Input',
            'title' => 'ngTagsInput',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-tags-input',
              __( 'Tags input directive for AngularJS. Check out the ngTagsInput website for more information.', 'wp-ng'),
              '',
              'http://mbenford.github.io/ngTagsInput',
              'http://mbenford.github.io/ngTagsInput/demos'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'hl__dot__sticky',
            'label' => 'Angular Sticky',
            'title' => 'hl.sticky',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-sticky',
              __( 'Pure javascript AngularJS directive to make elements stick when scrolling.', 'wp-ng'),
              '',
              'http://harm-less.github.io/angular-sticky',
              'http://harm-less.github.io/angular-sticky/#/demo/simple'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngStickyFooter',
            'label' => 'Angular Sticky Footer',
            'title' => 'ngStickyFooter',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-sticky-footer',
              __( 'Sticky Footer.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/ng-sticky-footer',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'focus-if',
            'label' => 'Angular Focus if',
            'title' => 'focus-if',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-focus-if',
              __( 'An attribute directive that will trigger focus on an element under specified conditions. It can also be used as a cross-browser replacement for the autofocus attribute.', 'wp-ng'),
              '',
              'https://github.com/hiebj/ng-focus-if/blob/master/README.md',
              'http://plnkr.co/edit/MJS3zRk079Mu72o5A9l6?p=preview'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngInput',
            'label' => 'Angular Text Input Effect',
            'title' => 'ngInput',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-input',
              __( 'ng-input is a fork from <a href="https://github.com/codrops/TextInputEffects">codrops - Text Input Effects</a>, to work with angular directives.', 'wp-ng'),
              '',
              'https://github.com/cesardeazevedo/ng-input',
              'http://cesardeazevedo.github.io/ng-input/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angularLazyImg',
            'label' => 'Angular Lazy Image',
            'title' => 'angularLazyImg',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-lazy-img',
              __( 'Lightweight lazy load images plugin. Only 1kb after gziping. Pure JavaScript, only Angular as dependency.', 'wp-ng'),
              '',
              'https://github.com/Pentiado/angular-lazy-img',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'LiveSearch',
            'label' => 'Angular Live Search',
            'title' => 'LiveSearch',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-livesearch',
              __( 'Angular Live Search.', 'wp-ng'),
              '',
              'https://github.com/mauriciogentile/angular-livesearch',
              'http://plnkr.co/edit/ad3Sq9?p=info'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'com__dot__2fdevs__dot__videogular',
            'label' => 'Videogular',
            'title' => 'com.2fdevs.videogular',
            'desc'  => wp_ng_settings_sections_desc_html(
              'rc-videogular',
              __( 'Videogular is an HTML5 video player for AngularJS. Videogular is a wrapper over the HTML5 video tag, so you just could add whatever you want. This provides a very powerful, but simple to use solution, for everybody.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/rc-videogular',
              'http://www.videogular.com/examples/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script__dot__plugins__dot__buffering',
                'label'       => 'Script buffering',
                'desc'        => __( 'Load script buffering.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script__dot__plugins__dot__controls',
                'label'       => 'Script layer controls',
                'desc'        => __( 'Load script controls.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script__dot__plugins__dot__overlayplay',
                'label'       => 'Script overlay play',
                'desc'        => __( 'Load script overlay play.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'script__dot__plugins__dot__poster',
                'label'       => 'Script poster',
                'desc'        => __( 'Load script poster.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style videogular.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'rc-videogular__dot__plugins__dot__youtube',
            'label' => 'Videogular Youtube',
            'title' => 'rc-videogular.plugins.youtube',
            'desc'  => wp_ng_settings_sections_desc_html(
              'rc-videogular',
              __( 'Videogular youtube plugin.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/rc-videogular',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'rc-videogular__dot__plugins__dot__vimeo',
            'label' => 'Videogular Vimeo',
            'title' => 'rc-videogular.plugins.vimeo',
            'desc'  => wp_ng_settings_sections_desc_html(
              'rc-videogular',
              __( 'Videogular vimeo plugin.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/rc-videogular',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'satellizer',
            'label' => 'Angular Satellizer',
            'title' => 'satellizer',
            'desc'  => wp_ng_settings_sections_desc_html(
              'satellizer',
              __( 'Satellizer is a simple to use, end-to-end, token-based authentication module for AngularJS with built-in support for Google, Facebook, LinkedIn, Twitter, Instagram, GitHub, Bitbucket, Yahoo, Twitch, Microsoft (Windows Live) OAuth providers, as well as Email and Password sign-in.', 'wp-ng'),
              '',
              'https://github.com/sahat/satellizer',
              'https://satellizer-sahat.rhcloud.com/#/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngProgressButtonStyles',
            'label' => 'Angular Progress Button Styles',
            'title' => 'ngProgressButtonStyles',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-progress-button-styles',
              __( 'A set of flat and 3D progress button styles where the button itself serves as a progress indicator. 3D styles are used for showing the progress indication on one side of the button while rotating the button in perspective.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/ng-progress-button-styles',
              'https://redcastor.github.io/ng-progress-button-styles/demo/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angular-sortable-view',
            'label' => 'Angular Sortable View',
            'title' => 'angular-sortable-view',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-sortable-view',
              __( 'This is a simple library written as a module for AngularJS for sorting elements in the UI. It supports both single elements list, and multiple connected lists, where an element can be moved from one to another.', 'wp-ng') .
              __('This library requires no dependencies whatsoever (except angular.js of course), so you no longer need to include jQuery and jQueryUI and angularUI which altogether gives the size of around 340kB minified. Whereas the angular-sortable-view is only ***5kB minified!***.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/angular-sortable-view',
              'http://kamilkp.github.io/angular-sortable-view/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angular-img-cropper',
            'label' => 'Angular Image Cropper',
            'title' => 'angular-img-cropper',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-img-cropper-redcastor',
              __( 'Insert the icons in 30 seconds using the new Icon Sets technology.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/angular-img-cropper',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'webicon',
            'label' => 'Angular WebIcon',
            'title' => 'webicon',
            'desc'  => wp_ng_settings_sections_desc_html(
              'webicon',
              __( 'Insert the icons in 30 seconds using the new Icon Sets technology.', 'wp-ng'),
              '',
              'https://github.com/icons8/webicon',
              'https://icons8.github.io/webicon/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'      => 'svg_icons',
                'type'      => 'file',
                'options'   => array(
                  'mime'      => 'image/svg+xml',
                  'button_label' => __('Select svg file', 'wp-ng'),
                )
              ),
              array(
                'name'        => 'spinners',
                'desc'        => __('Load SVG Spinners.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'      => 'alias',
                'placeholder' => __( 'Enter the alias', 'wp-ng'),
                'default'     => '',
                'type'      => 'text',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'rcDialog',
            'label' => 'Angular Dialog Modal',
            'title' => 'rcDialog',
            'desc'  => wp_ng_settings_sections_desc_html(
              'rc-dialog',
              __( 'Angular Directive Modal Wrapper for "Bootstrap", "Foundation" and "ngDialog".', 'wp-ng'),
              '',
              'https://github.com/RedCastor/rc-dialog',
              'https://redcastor.github.io/rc-dialog/demo/bs/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'rcMedia',
            'label' => 'Angular Media',
            'title' => 'rcMedia',
            'desc'  => wp_ng_settings_sections_desc_html(
              'rc-media',
              __( 'Angular module to manage file gallery and upload file with crop.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/rc-media',
              'https://redcastor.github.io/rc-media/demo/zf/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_dialog',
                'label'       => 'Style Dialog',
                'desc'        => __( 'Load dialog style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_select',
                'label'       => 'Style Select',
                'desc'        => __( 'Load select style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_zf',
                'label'       => 'Style Foundatin',
                'desc'        => __( 'Load Foundation style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'rcGallery',
            'label' => 'Angular Gallery',
            'title' => 'rcGallery',
            'desc'  => wp_ng_settings_sections_desc_html(
              'rc-gallery',
              __( 'Angular wrapper for Unitegallery and Galleria.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/rc-gallery',
              'https://redcastor.github.io/rc-gallery/demo/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'scriptUnitegallery',
                'label'       => 'Load Unite Gallery',
                'desc'        => __( 'Load unitegallery plugin.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'scriptGalleria',
                'label'       => 'Load Galleria',
                'desc'        => __( 'Load galleria plugin.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'admin_gallery',
                'label'       => 'Add admin gallery in create gallery',
                'desc'        => __( 'Add the admin media gallery in create gallery.', 'wp-ng'),
                'type'        => 'multiselect',
                'options'     => array(
                  'unitegallery' => 'Unitegallery',
                  'galleria'     => 'Galleria',
                ),
              ),
              array(
                'name'        => 'admin_gallery_themes_unitegallery',
                'label'       => 'Themes Unite Gallery',
                'desc'        => __( 'Load themes Unite Gallery.', 'wp-ng'),
                'type'        => 'multiselect',
                'options'     => array(
                  'default'   => 'Default',
                  'compact'   => 'Compact',
                  'slider'    => 'Slider',
                  'sliderfull'    => 'Slider Full',
                  'carousel'  => 'Carousel',
                  'tiles'     => 'Tiles',
                  'tilesgrid' => 'Tiles Grid',
                  'grid'      => 'Grid',
                  'video'     => 'Video'
                ),
              ),
              array(
                'name'        => 'admin_gallery_themes_galleria',
                'label'       => 'Themes Galleria',
                'desc'        => __( 'Load themes Galleria.', 'wp-ng'),
                'type'        => 'multiselect',
                'options'     => array(
                  'classic'   => 'Classic',
                  'fullscreen'   => 'FullScreen',
                ),
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'rcGalleria',
            'label' => 'Galleria wrapper',
            'title' => 'rcGalleria',
            'desc'  => wp_ng_settings_sections_desc_html(
              'rc-galleria',
              __( 'AngularJS wrapper for galleria.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/rc-galleria',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'rcHttp',
            'label' => 'Angular Http',
            'title' => 'rcHttp',
            'desc'  => wp_ng_settings_sections_desc_html(
              'rc-http',
                __( 'Angular Directive http request', 'wp-ng'),
              '',
              'https://github.com/RedCastor/rc-http'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'jtt_aping',
            'label' => 'Angular apiNG',
            'title' => 'jtt_aping',
            'desc'  => wp_ng_settings_sections_desc_html(
              'apiNG',
              __( 'apiNG is an AngularJS module that enables you to receive and display data from one or more sources. The data can be aggregated, limited and ordered. The complete setup is dead simple, just by adding data-attributes to your html.', 'wp-ng'),
              '',
              'https://github.com/JohnnyTheTank/apiNG',
              'http://aping.js.org/#demo'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'jtt_aping_instagram',
            'label' => 'Angular apiNG Instagram',
            'title' => 'jtt_aping_instagram',
            'desc'  => wp_ng_settings_sections_desc_html(
              'apiNG-plugin-instagram',
              __( 'apiNG-plugin-instagram is a Instagram REST API plugin for apiNG.', 'wp-ng'),
              '',
              'https://github.com/JohnnyTheTank/apiNG-plugin-instagram',
              'https://aping.readme.io/docs/demos'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'access_token',
                'label'       => 'Instagram',
                'placeholder' => __( 'Access Token', 'wp-ng'),
                'default'     => '',
                'type'        => 'text',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'jtt_aping_facebook',
            'label' => 'Angular apiNG Facebook',
            'title' => 'jtt_aping_facebook',
            'desc'  => wp_ng_settings_sections_desc_html(
              'apiNG-plugin-facebook',
              __( 'apiNG-plugin-facebook is a Facebook Graph API plugin for apiNG.', 'wp-ng'),
              '',
              'https://github.com/JohnnyTheTank/apiNG-plugin-facebook',
              'https://aping.readme.io/docs/demos'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'access_token',
                'label'       => 'Facebook',
                'placeholder' => __( 'Access Token', 'wp-ng'),
                'default'     => '',
                'type'        => 'text',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'jtt_aping_codebird',
            'label' => 'Angular apiNG Twitter',
            'title' => 'jtt_aping_codebird',
            'desc'  => wp_ng_settings_sections_desc_html(
              'apiNG-plugin-codebird',
              __( 'apiNG-plugin-codebird is a Twitter REST API plugin for apiNG.', 'wp-ng'),
              '',
              'https://github.com/JohnnyTheTank/apiNG-plugin-codebird',
              'https://aping.readme.io/docs/demos'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'bearer_token',
                'label'       => 'Twitter',
                'placeholder' => __( 'Bearer Token', 'wp-ng'),
                'default'     => '',
                'type'        => 'text',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'jtt_aping_flickr',
            'label' => 'Angular apiNG Flickr',
            'title' => 'jtt_aping_flickr',
            'desc'  => wp_ng_settings_sections_desc_html(
              'apiNG-plugin-flickr',
              __( 'apiNG-plugin-flickr is a Flickr API plugin for apiNG.', 'wp-ng'),
              '',
              'https://github.com/JohnnyTheTank/apiNG-plugin-flickr',
              'https://aping.readme.io/docs/demos'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'jtt_aping_tumblr',
            'label' => 'Angular apiNG Tumblr',
            'title' => 'jtt_aping_tumblr',
            'desc'  => wp_ng_settings_sections_desc_html(
              'apiNG-plugin-tumblr',
              __( 'apiNG-plugin-tumblr is a Tumblr API plugin for apiNG.', 'wp-ng'),
              '',
              'https://github.com/JohnnyTheTank/apiNG-plugin-tumblr',
              'https://aping.readme.io/docs/demos'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'api_key',
                'label'       => 'Tumblr',
                'placeholder' => __( 'Api Key', 'wp-ng'),
                'default'     => '',
                'type'        => 'text',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'jtt_aping_wikipedia',
            'label' => 'Angular apiNG Wikipedia',
            'title' => 'jtt_aping_wikipedia',
            'desc'  => wp_ng_settings_sections_desc_html(
              'apiNG-plugin-wikipedia',
              __( 'apiNG-plugin-wikipedia is a wikipedia API plugin for apiNG.', 'wp-ng'),
              '',
              'https://github.com/JohnnyTheTank/apiNG-plugin-wikipedia',
              'https://aping.readme.io/docs/demos'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'jtt_aping_dailymotion',
            'label' => 'Angular apiNG Dailymotion',
            'title' => 'jtt_aping_dailymotion',
            'desc'  => wp_ng_settings_sections_desc_html(
              'apiNG-plugin-dailymotion',
              __( 'apiNG-plugin-dailymotion is a Dailymotion Data API plugin for apiNG.', 'wp-ng'),
              '',
              'https://github.com/JohnnyTheTank/apiNG-plugin-dailymotion',
              'https://aping.readme.io/docs/demos'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'jtt_aping_vimeo',
            'label' => 'Angular apiNG Vimeo',
            'title' => 'jtt_aping_vimeo',
            'desc'  => wp_ng_settings_sections_desc_html(
              'apiNG-plugin-vimeo',
              __( 'apiNG-plugin-vimeo is a Vimeo Data API plugin for apiNG.', 'wp-ng'),
              '',
              'https://github.com/JohnnyTheTank/apiNG-plugin-vimeo',
              'https://aping.readme.io/docs/demos'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'access_token',
                'label'       => 'Vimeo',
                'placeholder' => __( 'Access Token', 'wp-ng'),
                'default'     => '',
                'type'        => 'text',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'jtt_aping_youtube',
            'label' => 'Angular apiNG YouTube',
            'title' => 'jtt_aping_youtube',
            'desc'  => wp_ng_settings_sections_desc_html(
              'apiNG-plugin-youtube',
              __( 'apiNG-plugin-youtube is a Youtube Data API v3 plugin for apiNG.', 'wp-ng'),
              '',
              'https://github.com/JohnnyTheTank/apiNG-plugin-youtube',
              'https://aping.readme.io/docs/demos'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'api_key',
                'label'       => 'YouTube',
                'placeholder' => __( 'Api Key', 'wp-ng'),
                'default'     => '',
                'type'        => 'text',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'jtt_aping_openweathermap',
            'label' => 'Angular apiNG Open Weather Map',
            'title' => 'jtt_aping_openweathermap',
            'desc'  => wp_ng_settings_sections_desc_html(
              'apiNG-plugin-openweathermap',
              __( 'apiNG-plugin-openweathermap is a OpenWeatherMap API plugin for apiNG.', 'wp-ng'),
              '',
              'https://github.com/JohnnyTheTank/apiNG-plugin-openweathermap',
              'https://aping.readme.io/docs/demos'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'api_key',
                'label'       => 'Open Weather Map',
                'placeholder' => __( 'Api Key', 'wp-ng'),
                'default'     => '',
                'type'        => 'text',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'vButton',
            'label' => 'Angular pressable button',
            'title' => 'vButton',
            'desc'  => wp_ng_settings_sections_desc_html(
              'v-button',
              __( '!!!!! Not compatible with "angular-foundation-6". AngularJS directives allow you to create buttons with a nice ripple effect and "busy" indicator. Inspired by Google material design.', 'wp-ng'),
              '',
              'https://github.com/LukaszWatroba/v-button',
              'http://lukaszwatroba.github.io/v-button/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_valitycss',
                'label'       => 'Style ValityCss',
                'desc'        => __( 'Load style.', 'wp-ng') . ' ValityCss',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'vModal',
            'label' => 'Angular modal component',
            'title' => 'vModal',
            'desc'  => wp_ng_settings_sections_desc_html(
              'v-modal',
              __( 'Simple, flexible and beautiful modal dialogs in AngularJS.', 'wp-ng'),
              '',
              'https://github.com/LukaszWatroba/v-modal',
              'http://lukaszwatroba.github.io/v-modal/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_valitycss',
                'label'       => 'Style ValityCss',
                'desc'        => __( 'Load style.', 'wp-ng') . ' ValityCss',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'vAccordion',
            'label' => 'Angular multi-level accordion',
            'title' => 'vAccordion',
            'desc'  => wp_ng_settings_sections_desc_html(
              'v-accordion',
              __( '- Allows for a nested structure<br>- Works with (or without) ng-repeat<br>- Allows multiple sections to be open at once', 'wp-ng'),
              '',
              'https://github.com/LukaszWatroba/v-accordion',
              'http://lukaszwatroba.github.io/v-accordion/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_valitycss',
                'label'       => 'Style ValityCss',
                'desc'        => __( 'Load style.', 'wp-ng') . ' ValityCss',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'vTabs',
            'label' => 'Angular dynamic tabs',
            'title' => 'vTabs',
            'desc'  => wp_ng_settings_sections_desc_html(
              'v-tabs',
              __( 'Dynamic, flexible and accessible AngularJS tabs.<br>- Easy to use and customize<br>- Keyboard accessible<br>- Works with (or without) ng-repeat', 'wp-ng'),
              '',
              'https://github.com/LukaszWatroba/v-tabs',
              'http://lukaszwatroba.github.io/v-tabs/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_valitycss',
                'label'       => 'Style ValityCss',
                'desc'        => __( 'Load style.', 'wp-ng') . ' ValityCss',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'vTextfield',
            'label' => 'Angular dynamic validation',
            'title' => 'vTextfield',
            'desc'  => wp_ng_settings_sections_desc_html(
              'v-textfield',
              __( "User-friendly text fields in AngularJS. You can use vTextfild to show (hide) validation messages, error/success input indicators, or interactive Float Labels. It basically adds classes to the v-textfield directive.", 'wp-ng'),
              '',
              'https://github.com/LukaszWatroba/v-textfield',
              'http://lukaszwatroba.github.io/v-textfield/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_valitycss',
                'label'       => 'Style ValityCss',
                'desc'        => __( 'Load style.', 'wp-ng') . ' ValityCss',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ng-sweet-alert',
            'label' => 'Angular dynamic alert',
            'title' => 'ng-sweet-alert',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-sweet-alert',
              __( "ng-sweet-alert is an directive for sweet alert [sweetalert]. Integration of sweet alert becomes very easy with angular js.<br>There is no need to write a single line of javascript code. Only few html attribute is enough to use sweetalert.", 'wp-ng'),
              '',
              'https://github.com/tushariscoolster/ng-sweet-alert',
              'http://tushariscoolster.github.io/ng-sweet-alert/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angular-owl-carousel-2',
            'label' => 'Angular Owl Carousel - 2',
            'title' => 'angular-owl-carousel-2',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-owl-carousel2',
              __( "https://github.com/emalikterzi/angular-owl-carousel-2.", 'wp-ng'),
              '',
              'https://github.com/emalikterzi/angular-owl-carousel-2',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_theme-default',
                'label'       => 'Style Theme Default',
                'desc'        => __( 'Load Theme Default style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_theme-green',
                'label'       => 'Style Theme Green',
                'desc'        => __( 'Load Theme Green style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'admin_gallery',
                'label'       => 'Add admin gallery in create gallery',
                'desc'        => __( 'Add the admin media gallery in create gallery.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'rcPhotoswipe',
            'label' => 'Angular PhotoSwipe',
            'title' => 'rcPhotoswipe',
            'desc'  => wp_ng_settings_sections_desc_html(
              'rc-photoswipe',
              __( "AngularJS Wrapper directive for PhotoSwipe.", 'wp-ng'),
              '',
              'https://github.com/m00s/angular-photoswipe',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angular__dot__backtop',
            'label' => 'Angular Scroll Top Button',
            'title' => 'angular.backtop',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-backtop',
              __( "A simple Angular.js directive to create \"Back to top\" button when user reaches the end of the page.", 'wp-ng'),
              '',
              'https://github.com/padsbanger/angular-backtop',
              'http://michal-lach.pl/angular-backtop/demo/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngLocationSearch',
            'label' => 'Angular Location Search',
            'title' => 'ngLocationSearch',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-location-search',
              __( 'Angular Location Search directive.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/ng-location-search',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'bgf__dot__paginateAnything',
            'label' => 'Angular Pagination',
            'title' => 'bgf.paginateAnything',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-paginate-anything',
              __( 'Angular Directive to Paginate Anything.', 'wp-ng'),
              '',
              'https://github.com/begriffs/angular-paginate-anything',
              'http://begriffs.github.io/angular-paginate-anything/?page=1&perPage=5'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngImageDimensions',
            'label' => 'Angular Image Dimensions',
            'title' => 'ngImageDimensions',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-image-dimensions',
              __( 'Angular directive for getting and displaying image dimensions in the view.', 'wp-ng'),
              '',
              'https://github.com/skyout/angular-image-dimensions',
              'http://scott-lanning.com/angular-image-dimensions/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angular-gridster2',
            'label' => 'Angular Gridster 2',
            'title' => 'angular-gridster2',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-gridster2-1',
              __( 'An implementation of gridster-like widgets for Angular JS.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/angular-gridster2-1',
              'https://tiberiuzuld.github.io/angular-gridster2/angularjs/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'duParallax',
            'label' => 'Angular Parallax',
            'title' => 'duParallax',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-parallax',
              __( 'Lightweight and highly performant AngularJS directive for parallax scrolling. Script is just 1.6K and about 40K gzipped with dependencies.', 'wp-ng'),
              '',
              'https://github.com/oblador/angular-parallax',
              'http://oblador.github.io/angular-parallax/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'dragularModule',
            'label' => 'Angular Drag and Drop',
            'title' => 'dragularModule',
            'desc'  => wp_ng_settings_sections_desc_html(
              'dragular',
              __( 'Angular drag&drop based on dragula.', 'wp-ng'),
              '',
              'https://github.com/luckylooke/dragular',
              'http://luckylooke.github.io/dragular/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ng-slide-down',
            'label' => 'Angular Slide up and down',
            'title' => 'ng-slide-down',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-slide-down',
              __( 'AngularJS directive for vertical slide down animation.', 'wp-ng'),
              '',
              'https://github.com/TheRusskiy/ng-slide-down',
              'http://jsfiddle.net/therusskiy/JR3C7/4/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angular__dot__vertilize',
            'label' => 'Angular Vertically Equalize',
            'title' => 'angular.vertilize',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-vertilize',
              __( 'An AngularJS directive to vertically equalize a group of elements with varying heights. In other words, it dynamically makes a group of elements the same height.', 'wp-ng'),
              '',
              'https://github.com/Sixthdim/angular-vertilize',
              'http://sixthdim.github.io/angular-vertilize/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'swipe',
            'label' => 'Angular Swipe Gesture',
            'title' => 'swipe',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-swipe',
              __( 'Simple vertical/horizontal swipe gesture directives and a swipe service for angular js >= 1.6. Small extension of the existing angular $swipe service.', 'wp-ng'),
              '',
              'https://github.com/adzialocha/angular-swipe',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngScrollSpy',
            'label' => 'Angular ScrollSpy',
            'title' => 'ngScrollSpy',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-ScrollSpy.js',
              __( 'ng-ScrollSpy is an AngularJS module for navigation highlighting.', 'wp-ng'),
              '',
              'https://github.com/patrickmarabeas/ng-ScrollSpy.js',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'snapscroll',
            'label' => 'Angular Snap Scroll',
            'title' => 'snapscroll',
            'desc'  => wp_ng_settings_sections_desc_html(
              'ng-ScrollSpy.js',
              __( 'angular-snapscroll adds vertical scroll-and-snap functionality to angular.', 'wp-ng'),
              '',
              'https://github.com/joelmukuthu/angular-snapscroll',
              'http://joelmukuthu.github.io/angular-snapscroll/#0'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'angular-flatpickr',
            'label' => 'Angular Flat Pickr',
            'title' => 'angular-flatpickr',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-flatpickr',
              __( 'An angular directive to use flatpickr.', 'wp-ng'),
              '',
              'https://github.com/archsaber/angular-flatpickr',
              'https://chmln.github.io/flatpickr/examples/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'label_for'        => __( 'Load style.', 'wp-ng'),
                'default'     => '',
                'type'        => 'select',
                'options'     => array(
                  ''                => __('No Style', 'wp-ng'),
                  'flatpickr'      => 'Style Flatpickr',
                ),
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'ngRateIt',
            'label' => 'Angular RateIt',
            'title' => 'ngRateIt',
            'desc'  => wp_ng_settings_sections_desc_html(
              'angular-rateit',
              __( 'This directive was inspired by the jQuery (star)rating plugin RateIt. However this package will work without jQuery and is very light weight.', 'wp-ng'),
              '',
              'https://github.com/akempes/angular-rateit',
              'http://akempes.github.io/angular-rateit/'
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'  => 'oc__dot__lazyLoad',
            'label' => 'Angular Lazy Load',
            'title' => 'oc.lazyLoad',
            'desc'  => wp_ng_settings_sections_desc_html(
              'oclazyload',
              __( 'Lazy load modules & components in AngularJS.', 'wp-ng'),
              '',
              'https://oclazyload.readme.io/docs/getting-started',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields' => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
        ),
      ),
    ),
  );

  return $fields;
}
add_filter('wp_ng_settings_fields', 'wp_ng_modules_fields');










