<?php

/**
 * The file that defines the settings fields option descriptor
 *
 * @link       team@redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */


/**
 * Define general settings fields
 */
function wp_ng_settings_fields( $fields )
{

  $fields = array(
    'wp_ng_load_modules' => array(
      'title' => __('Modules', 'wp-ng'),
      'sections' => array(
        'modules' => array(
          'title' => 'Load Angular Modules',
          'display'=> 'table',
          'fields' => array(
            array(
              'name'        => 'ngRoute',
              'label'       => 'ngRoute',
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
              'label' => 'ngSanitize',
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
              'label' => 'ngAnimate',
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
                  'desc'        => __( 'Load ngAnimate.css style.', 'wp-ng'),
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
              'name'  => 'ngResource',
              'label' => 'ngResource',
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
              'label' => 'ngCookies',
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
              'label' => 'ngStorage',
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
              'label' => 'ngMessages',
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
              'label' => 'ngTouch',
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
              'label' => 'breakpointApp',
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
              'name'  => 'ui__dot__bootstrap',
              'label' => 'ui.bootstrap',
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
              'label' => 'mm.foundation',
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
                    'foundation-flex' => 'Style Foundation Flex'
                  ),
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
              'label' => 'ui.router',
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
              'label' => 'pascalprecht.translate',
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
              'label' => 'offClick',
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
              'label' => 'nya.bootstrap.select',
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
              'name'  => 'ngDialog',
              'label' => 'ngDialog',
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
              'label' => 'smoothScroll',
              'desc'  => wp_ng_settings_sections_desc_html(
                'ngSmoothScroll',
                __( 'A pure-javascript library and set of directives to scroll smoothly to an element with easing. Easing support contributed by Willem Liu with code from Gaëtan Renaudeau.', 'wp-ng'),
                '',
                'https://github.com/cferdinandi/smooth-scroll',
                'http://cferdinandi.github.io/smooth-scroll'
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
              'name'  => 'ngScrollbars',
              'label' => 'ngScrollbars',
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
              'name'  => 'duScroll',
              'label' => 'duScroll',
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
              'label' => 'slick',
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
              'label' => 'slickCarousel',
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
              'name'  => 'ngMagnify',
              'label' => 'ngMagnify',
              'desc'  => wp_ng_settings_sections_desc_html(
                'ng-magnify',
                __( 'AngularJS directive for simple image magnification.', 'wp-ng'),
                '',
                'https://github.com/jotielim/ng-magnify',
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
              'name'  => 'infinite-scroll',
              'label' => 'infinite-scroll',
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
              'label' => 'ui-leaflet',
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
              'label' => 'wpNgRest',
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
              'name'  => 'nemLogging',
              'label' => 'nemLogging',
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
              'label' => 'pageslide-directive',
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
              'name'  => 'ui__dot__validate',
              'label' => 'ui.validate',
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
              'name'  => 'ui__dot__grid',
              'label' => 'ui.grid',
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
              'label' => 'ui.select',
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
              'label' => 'ngAntimoderate',
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
              'label' => 'ngGeonames',
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
              'label' => 'ngColorUtils',
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
              'label' => 'socialLinks',
              'desc'  => wp_ng_settings_sections_desc_html(
                'angular-social-links',
                __( 'Geonames ( http://www.geonames.org ) Bsed on ui-leaflet directive structure ( https://github.com/angular-ui/ui-leaflet ).', 'wp-ng'),
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
              'name'  => 'ngFileUpload',
              'label' => 'ngFileUpload',
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
              'label' => 'angular-loading-bar',
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
              'label' => 'angular-svg-round-progressbar',
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
              'name'  => 'angularProgressbar',
              'label' => 'angularProgressbar',
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
              'label' => 'xeditable',
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
              'label' => 'ngTagsInput',
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
              'label' => 'hl.sticky',
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
              'name'  => 'focus-if',
              'label' => 'focus-if',
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
              'name'  => 'angularLazyImg',
              'label' => 'angularLazyImg',
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
          ),
        ),
      ),
    ),
    'wp_ng_general' => array(
      'title' => __('General', 'wp-ng'),
      'sections' => array(
        'general' => array(
          'title' => __('General Settings', 'wp-ng'),
          'fields' => array(
            array(
              'name'        => 'app_name',
              'label'       => __('Application name', 'wp-ng'),
              'global'      => true,
              'placeholder' => 'wpng.root',
              'default'     => 'wpng.root',
              'type'        => 'text',
              'sanitize_callback' => 'sanitize_file_name'
            ),
            array(
              'name'        => 'app_element',
              'label'       => __('Application DOM Element', 'wp-ng'),
              'global'      => true,
              'placeholder' => 'body',
              'default'     => 'body',
              'type'        => 'text',
              'sanitize_callback' => 'sanitize_text_field'
            ),
            array(
              'name'        => 'combine_ng_modules',
              'label'       => __('Combine modules', 'wp-ng'),
              'desc'        => __( 'Combine the modules script and style. Combine create file in cache based on modification timestamp and module loaded in current context.' , 'wp-ng'),
              'global'      => true,
              'default'     => 'on',
              'type'        => 'checkbox',
              'sanitize_callback' => ''
            ),
            array(
              'name'        => 'ng-cloak',
              'label'       => __('Document Cloak', 'wp-ng'),
              'desc'        => __( 'Cloak the document. More info see' , 'wp-ng') . ' ( directive <a target="blank" href="https://docs.angularjs.org/api/ng/directive/ngCloak">ngCloak</a> )',
              'global'      => true,
              'default'     => 'off',
              'type'        => 'checkbox',
              'sanitize_callback' => ''
            ),
            array(
              'name'        => 'ng-preload',
              'label'       => __('Document Preload', 'wp-ng'),
              'desc'        => __( 'Preload the document. Class ng-preload is add to document tag html for disable transition and set visibility to hidden on all document.' , 'wp-ng'),
              'global'      => true,
              'default'     => 'off',
              'type'        => 'checkbox',
              'sanitize_callback' => ''
            ),
            array(
              'name'        => 'cache_hours',
              'label'       => __('Cache File Hours', 'wp-ng'),
              'desc'        => __( 'Remove file in cache base on timestamp and your hours value.' , 'wp-ng'),
              'global'      => true,
              'default'     => 48,
              'type'        => 'number',
              'sanitize_callback' => ''
            ),
            array(
              'name'        => 'purge_cache',
              'action'      => array( 'Wp_Ng_Admin_Fields_Action', 'purge_cache' ),
              'label'       => __('Purge Cache', 'wp-ng'),
              'desc'        => sprintf( __( 'Purge the cache directory. Number of file in cache: %s script, %s style' , 'wp-ng'), count(glob(Wp_Ng_Cache::cache_dir( WP_NG_PLUGIN_NAME ) . '*.js')), count(glob(Wp_Ng_Cache::cache_dir( WP_NG_PLUGIN_NAME ) . '*.css')) ),
              'global'      => true,
              'default'     => 'off',
              'type'        => 'checkbox',
              'sanitize_callback' => ''
            ),
          ),
        ),
      ),
    ),
    'wp_ng_advanced' => array(
      'title' => __('Advanced', 'wp-ng'),
      'sections' => array(
        'advanced' => array(
          'title' => __('Adanced Settings', 'wp-ng'),
          'fields' => array(
            array(
              'name'        => 'disable_wpautop',
              'label'       => __('Disable wpautop', 'wp-ng'),
              'desc'        => __('Disbable the automatic paragraph in all content.', 'wp-ng'),
              'global'      => true,
              'default'     => 'off',
              'type'        => 'checkbox',
              'sanitize_callback' => ''
            ),
            array(
              'name'        => 'disable_tinymce_verify_html',
              'label'       => __('Disable Verify Html', 'wp-ng'),
              'desc'        => __('Disbable the verify html in wp editor.', 'wp-ng'),
              'global'      => true,
              'default'     => 'off',
              'type'        => 'checkbox',
              'sanitize_callback' => ''
            ),
          ),
        ),
      ),
    ),
  );

  return $fields;
}
add_filter('wp_ng_settings_fields', 'wp_ng_settings_fields');










