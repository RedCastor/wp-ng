//Angular Elementor Compatibility. Author: Auban le Grelle
(function (angular, window) {
  'use strict';

  var wpNg = window.wpNg;


  //Run Angular Application
  wpNg.app.run(['$rootScope', '$compile', '$q', '$injector', '$timeout', '$window', '$log', 'WP_NG_CONFIG',
    function ( $rootScope, $compile, $q, $injector, $timeout, $window, $log, WP_NG_CONFIG )
  {

    //Timeout use for angular ready
    $timeout(function () {

      //Compilation Element
      function compile ( $element ) {
        var deferred = $q.defer();

        deferred.resolve($compile( $element )($rootScope));

        return deferred.promise;
      }


      //Workaround elementor check empty element if height under 1 on timeout 200ms
      //Example oc.lazyLoad
      function element_size($content) {

        if ( 1 > $content.height() && $content.find('.elementor-widget-container').children().length !== 0 ) {
          //Set the height to 1
          $content.height(1);

          $timeout(function () {
            if ($content.height() === 1) {
              $content.height('');
              angular.element($window).triggerHandler('resize');
            }
          }, 300);
        }
      }

      //Elementor Widget Ready
      if (angular.isDefined(window.elementorFrontend) && angular.isDefined(elementorFrontend.hooks)) {

        elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($element, $) {

          //Compile Element promise
          compile($element).then(function ($content) {

            //Cloak Remove
            $content.find(".ng-cloak").removeClass('ng-cloak');
            $content.find(".x-ng-cloak").removeClass('x-ng-cloak');
            $content.find("[ng-cloak='']").removeAttr('ng-cloak');
            $content.find("[data-ng-cloak='']").removeAttr('data-ng-cloak');

            angular.element($window).triggerHandler('resize');

            element_size($content);
            $log.debug('wpNg Elementor Widget Compiled');
          });

        });

      }

    }, 0);

  }]);


  //wpNg ready init elementor widget ready.
  wpNg.ready(function() {

    if (angular.isDefined(window.elementorFrontend) && angular.isDefined(elementorFrontend.hooks)) {

      var is_removed_action_widget = false;
      var remove_action_widget = function() {
        if ( !is_removed_action_widget ) {
          elementorFrontend.hooks.removeAction('frontend/element_ready/widget', init_widget);
          is_removed_action_widget = true;
        }
      };

      var init_widget = function ($content, $) {

        if ( 1 > $content.height() && $content.find('.elementor-widget-container').children().length !== 0 ) {
          //Set the height to 1
          $content.height(1);

          setTimeout(function () {
            if ($content.height() === 1) {
              $content.height('');

              $content
                .removeClass( 'elementor-widget-empty' )
                //.addClass( 'elementor-widget-' + editModel.get( 'widgetType' ) + ' elementor-widget-can-edit' )
                .children( '.elementor-widget-empty-icon' )
                .remove();

              angular.element(window).triggerHandler('resize');

              remove_action_widget();
            }
          }, 2500);
        }
      };

      elementorFrontend.hooks.addAction('frontend/element_ready/widget', init_widget);
    }
  });

}(angular, window));

