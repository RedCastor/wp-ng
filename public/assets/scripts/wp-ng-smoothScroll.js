(function(angular, wpNg){
  'use strict';


  //Congigure and Run wp ng router if ui.router module is defined
  if ( angular.isDefined(wpNg.config.modules.smoothScroll) && wpNg.config.modules.smoothScroll.scroll_by_id === true ) {


    wpNg.app.run(['$rootScope', '$injector', '$location', '$timeout', '$interval', '$log', 'WP_NG_CONFIG', function ($rootScope, $injector, $location, $timeout, $interval, $log, WP_NG_CONFIG) {

      $log.debug('WP NG smoothScroll Run');

      var smoothScroll = null;
      var elems_selector = false;
      var is_offset_selector = false;
      var options;

      try {
        smoothScroll = $injector.get('smoothScroll');

        var config_smoothScroll = WP_NG_CONFIG.modules.smoothScroll;

        //Set smoothScroll options
        options = {
          duration: config_smoothScroll.duration || 1200,
          easing: (config_smoothScroll.easing && config_smoothScroll.easing.length) ? config_smoothScroll.easing : 'easeOutQuart',
          offset: config_smoothScroll.offset || 0,
          callbackAfter: function(element) {
            $timeout(function () {
              $location.path('/').replace();
              $location.hash('');
            }, 10);
          }
        };

        is_offset_selector = config_smoothScroll.offset_selector && config_smoothScroll.offset_selector.length;

        //Add offset for custom selector height
        if (is_offset_selector) {

          var selector_interval = $interval(function() {

            elems_selector = angular.element(config_smoothScroll.offset_selector);

            if ( elems_selector.length ) {
              angular.forEach(elems_selector, function (elem, index) {

                options.offset += angular.element(elem).height();
              });

              is_offset_selector = true;
              $interval.cancel(selector_interval);
            }
            else {
              is_offset_selector = false;
            }
          }, 100, 10);
        }

      }
      catch(err) {
        $log.debug('Angular module "smoothScroll" is not loaded !');
      }

      $rootScope.$on('$locationChangeSuccess', function(event) {

        $log.debug('$locationChangeSuccess | wp-ng-smooth-scroll.js');

        if (smoothScroll) {

          var hash = $location.hash().replace('#', '');

          var state = (hash.length) ? hash : '';
          var element = document.getElementById( state );

          if ( angular.isString(state) && state.length && element !== null ) {

            //Workaround Elementor disable click on link
            if (angular.isDefined(window.elementorFrontend) && angular.isDefined(elementorFrontend.hooks)) {
              elementorFrontend.getElements( '$document' ).off( 'click', 'a[href*="#"]' );
            }

            if ( !is_offset_selector || elems_selector.length ) {

              smoothScroll(element, options);
            }
          }
        }
      });

    }]);
  }
})(angular, wpNg);
