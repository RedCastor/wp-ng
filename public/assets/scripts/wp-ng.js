//Angular bootstrap application with modules. Author: Auban le Grelle
(function (angular, window) {
  'use strict';

  var wpNg = window.wpNg;

  //Cloak application element
  if ( wpNg.config.cloak === true ) {
    angular.element( wpNg.appElement ).addClass('ng-cloak');
  }

  //Preload application element
  if ( wpNg.config.preload === true ) {
    angular.element( wpNg.appElement ).addClass('ng-preload');
  }

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


  //Run Application
  wpNg.app.run(['$rootScope', '$injector', '$location', 'locationTools', '$timeout', '$log', 'WP_NG_CONFIG', function ( $rootScope, $injector, $location, locationTools, $timeout, $log, WP_NG_CONFIG ) {

    //Access root config
    $rootScope.wpNgConfig = WP_NG_CONFIG;


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


    //Workaround form not send if action not defined add action empty. (woocommerce add to cart).
    angular.element( wpNg.appElement ).find('form').each(function( index ) {

      if (
        angular.element(this).attr('action') === undefined &&
        angular.element(this).attr('data-ng-submit') === undefined &&
        angular.element(this).attr('ng-submit') === undefined
      ) {
        angular.element(this).attr('action', '');
      }
    });


    /**
     * Generic Query url call a function in service.
     *
     * This example inject the service $log and call the function debug with the query params
     * Example url: http://www.your-domain.com/#/?wpNgQuery={"service":"$log","call":"debug","params":["test"]}
     * Example encoded: http://www.your-domain.com/#/?wpNgQuery=%7B%22service%22%3A%22%24log%22%2C%22call%22%3A%22debug%22%2C%22params%22%3A%5B%22test%22%5D%7D
     *
     */
    $rootScope.$on('$locationChangeStart', function(event, newUrl, oldUrl, newState, oldState) {

      var search = $location.search();

      if ( angular.isDefined(search.wpNgQuery) ) {

        try {
          var query = locationTools.decode(search.wpNgQuery);

          $log.debug('WP-NG Query start.');
          $log.debug('WP-NG Query: ');
          $log.debug(query);

          var service = query.service;
          var call = query.call;
          var params = query.params;

          $log.debug('Service: ' + service);
          $log.debug('Call:' + call);


          if ( $injector.has(service) ) {
            service = $injector.get(service);
          }
          else {
            throw "Service " + service + " is not a service";
          }

          if ( angular.isFunction(service[call]) ) {
            service[call](params);
          }
          else {
            throw "Call " + call + " is not a function";
          }
        }
        catch(e) {
          $log.error('WP-NG Query Error.');
          $log.error(e);
        }
      }
    });


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

