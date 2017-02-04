//Angular bootstrap application with modules. Author: Auban le Grelle
(function (angular, window) {
  'use strict';

  var wpNg = window.wpNg;


  //Asign document ready to wpNg
  wpNg.ready = angular.element(document).ready;

  //Set the default application element
  if ( angular.isDefined(wpNg.appElement) && angular.isString(wpNg.appElement) && wpNg.appElement ) {
    wpNg.appElement = angular.element(wpNg.appElement);
  }
  else {
    wpNg.appElement = angular.element(document.body);
  }


  //Function Check module dependencie.
  wpNg.isModuleDepLoaded = function( module_name, modules_dep ) {

    var modules_dep_error = [];

    modules_dep.forEach(function (dep_name, index) {
      try {
        angular.module(dep_name);

      }
      catch (err) {
        modules_dep_error.push(dep_name);
        console.error('Angular module "' + module_name + '" can not load dependency module "' + dep_name + '".');
      }
    });

    return modules_dep_error;
  };


  //Function to check if module is defined
  wpNg.isModuleLoaded = function( module_name ) {
    try {
      angular.module(module_name);
      return true;
    } catch (error) {
      return false;
    }
  };

  //Bootstrap the angular application
  window.deferredBootstrapper.bootstrap({
    element: wpNg.appElement,
    module: wpNg.appName,
    resolve: {
      WP_NG_CONFIG: ['$q', function ($q) {
        var deferred = $q.defer();
        deferred.resolve(wpNg.config);
        return deferred.promise;
      }]
    }
  });


  //Create Root Application with all dependencie modules
  wpNg.app = angular.module(wpNg.appName, wpNg.ngModules);

  //Filter config disable animation on element
  if ( angular.isDefined(wpNg.ngModules.ngAnimate) ) {
    wpNg.app.config(['$animateProvider', function ($animateProvider) {
      $animateProvider.classNameFilter(/^(?:(?!ng-animate-disabled).)*$/);
    }]);
  }

  //Configure Rest module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules.wpNgRest) ) {
    wpNg.app.config(['wpNgRestProvider', 'WP_NG_CONFIG', function (wpNgRestProvider, WP_NG_CONFIG) {

      if ( angular.isDefined(WP_NG_CONFIG.modules.wpNgRest.restNonceKey) && angular.isDefined(WP_NG_CONFIG.modules.wpNgRest.restNonceVal) ) {
        wpNgRestProvider.setNonce({
          key: WP_NG_CONFIG.modules.wpNgRest.restNonceKey,
          val: WP_NG_CONFIG.modules.wpNgRest.restNonceVal
        });
      }
      if ( angular.isDefined(WP_NG_CONFIG.modules.wpNgRest.restUrl) && angular.isDefined(WP_NG_CONFIG.modules.wpNgRest.restPath) ) {
        wpNgRestProvider.setRest({
          url: WP_NG_CONFIG.modules.wpNgRest.restUrl,
          path: WP_NG_CONFIG.modules.wpNgRest.restPath
        });
      }
      if ( angular.isDefined(WP_NG_CONFIG.modules.wpNgRest.restLangKey) && angular.isDefined(WP_NG_CONFIG.modules.wpNgRest.restLangVal) ) {
        wpNgRestProvider.setLang({
          key: WP_NG_CONFIG.modules.wpNgRest.restLangKey,
          val: WP_NG_CONFIG.modules.wpNgRest.restLangVal
        });
      }

    }]);
  }

  //Configure ngScrollbars module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules.ngScrollbars) ) {
    wpNg.app.config(['ScrollBarsProvider', 'WP_NG_CONFIG', function (ScrollBarsProvider, WP_NG_CONFIG) {

      var defaults = WP_NG_CONFIG.modules.ngScrollbars.defaults;

      ScrollBarsProvider.defaults = angular.isDefined(defaults) ? defaults : {};
    }]);
  }

  wpNg.app.config(['$compileProvider', '$logProvider', 'WP_NG_CONFIG', function ($compileProvider, $logProvider, WP_NG_CONFIG) {
      //Set debug Enable
      $logProvider.debugEnabled(WP_NG_CONFIG.enableDebug);
      $compileProvider.debugInfoEnabled(WP_NG_CONFIG.enableDebug);
    }]);


  //Run Application
  wpNg.app.run(['$rootScope', '$timeout', '$log', 'WP_NG_CONFIG', function ( $rootScope, $timeout, $log, WP_NG_CONFIG ) {

    $timeout(function() {
      //Cloak Animation Remove Preload Delay class
      angular.element('html').find(".ng-cloak-animation").removeClass('ng-cloak-animation');
      angular.element('html').find(".x-ng-cloak-animation").removeClass('x-ng-cloak-animation');
      angular.element('html').find("[ng-cloak-animation='']").removeAttr('ng-cloak-animation');
      angular.element('html').find("[x-ng-cloak-animation='']").removeAttr('x-ng-cloak-animation');
      angular.element('html').find("[data-ng-cloak-animation='']").removeAttr('data-ng-cloak-animation');

      //Preload Remove Preload Delay class
      angular.element('html').find(".ng-preload").removeClass('ng-preload');
      angular.element('html').find(".x-ng-preload").removeClass('x-ng-preload');
      angular.element('html').find("[ng-preload='']").removeAttr('ng-preload');
      angular.element('html').find("[x-ng-preload='']").removeAttr('x-ng-preload');
      angular.element('html').find("[data-ng-preload='']").removeAttr('data-ng-preload');



      //Foundation initialize
      if ( angular.isDefined(WP_NG_CONFIG.modules['mm.foundation']) ) {

        if ( angular.isDefined(WP_NG_CONFIG.modules['mm.foundation'].init) && WP_NG_CONFIG.modules['mm.foundation'].init === true ) {
          var element = angular.isDefined(WP_NG_CONFIG.modules['mm.foundation'].element) ? WP_NG_CONFIG.modules['mm.foundation'].element : 'body';

          if (typeof angular.element( element ).foundation === "function") {
            angular.element( element ).foundation();
            $log.info('Foundation initialized on element "' + element + '".');
          }
          else {
            $log.error('Function foundation not exist.');
          }
        }

      }

    }, 0);


    $log.info('WP NG Angular Run app: ' + wpNg.appName);
    $log.info('Environment:          ' + WP_NG_CONFIG.env);
    $log.info('Version Theme:        V' + WP_NG_CONFIG.themeVersion);
    $log.info('Debug Mode:           ' + WP_NG_CONFIG.enableDebug);
    $log.debug('Version WP:          V' + WP_NG_CONFIG.wpVersion);
    $log.debug('Version Angular:     V' + angular.version.full);
    $log.debug('Language Default:    ' + WP_NG_CONFIG.defaultLang);
    $log.debug('Language Current:    ' + WP_NG_CONFIG.currentLang);
    $log.debug('Url Base:            ' + WP_NG_CONFIG.baseUrl);

  }]);


  //wpNg Ready
  wpNg.ready( function() {
    console.info('WP NG Ready');

  });

}(angular, window));

