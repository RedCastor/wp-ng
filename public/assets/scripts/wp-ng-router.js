(function(angular, wpNg){
  'use strict';


  //Run wp ng router if ui.router module is defined
  if ( angular.isDefined(wpNg.config.modules['ui.router']) ) {
    wpNg.app.run(['$rootScope', '$window', '$location', '$log', 'WP_NG_CONFIG', '$state', function ( $rootScope, $window, $location, $log, WP_NG_CONFIG, $state ) {

      $log.debug('WP NG Router Run');

      //Prevent UI-Router State Change
      $rootScope.preventState = {
        enable: false,
        change: false
      };
      if (angular.isDefined(WP_NG_CONFIG.modules['ui.router'].preventState)) {
        angular.extend($rootScope.preventState, WP_NG_CONFIG.modules['ui.router'].preventState);
      }

      //Selected View
      $rootScope.selectView = '';
      if ( angular.isDefined(WP_NG_CONFIG.modules['ui.router'].selectView) ) {
        $rootScope.selectView = WP_NG_CONFIG.modules['ui.router'].selectView;
      }

      //State loading status
      $rootScope.stateIsLoading = false;

      //UI-Router change location if state change and is not base URL.
      $rootScope.$on('$stateChangeStart', function (ev, toState, toParams, fromState, fromParams) {

        $rootScope.stateIsLoading = true;

        if ($rootScope.preventState.enable) {

          //Redirect if the state change is not on base URL
          var to_url = $state.href(toState.name);
          var url = $window.location.protocol + '//' + $window.location.host + $window.location.pathname;
          var base_url = WP_NG_CONFIG.baseUrl;

          $log.debug(to_url);
          $log.debug(url);
          $log.debug(base_url);

          if (url !== base_url && to_url !== '#/' ) {
            ev.preventDefault();
            $rootScope.preventState.change = true;
            $window.location.replace(base_url + to_url);
          }
        }
      });

      $rootScope.$on('$stateChangeSuccess', function (ev, toState, toParams, fromState, fromParams) {

        //Change the view
        $rootScope.selectView = toState.name;
        //End Loading state
        $rootScope.stateIsLoading = false;
      });


      $rootScope.$on('$locationChangeStart', function(ev, newUrl, oldUrl) {

        //Prevent State Change by $stateChangeStart
        if ($rootScope.preventState.change === true) {
          ev.preventDefault();
        }
      });

    }]);
  }

})(angular, wpNg);
