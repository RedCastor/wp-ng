(function(angular, wpNg){
  'use strict';


  //Congigure and Run wp ng router if ui.router module is defined
  if ( angular.isDefined(wpNg.config.modules['ui.router']) ) {

    /**
     * Configure Router
     */
    wpNg.app.config(['$locationProvider', '$stateProvider', '$urlRouterProvider', 'WP_NG_CONFIG',
      function ($locationProvider, $stateProvider, $urlRouterProvider, WP_NG_CONFIG) {

        var $log =  angular.injector(['ng']).get('$log');
        var config_router = WP_NG_CONFIG.modules['ui.router'];

        //Set if state not found to root state. Not only wrap route to fix change ng-location-search.
        $urlRouterProvider.otherwise('/');

        //Always register Base State even not base url to prevent location search
        var base = {
          name: 'base',
          url: '/',
          template: config_router.templates.base
        };

        $stateProvider.state(base);

        if (config_router.states) {

          angular.forEach(config_router.states, function (state, key) {

            //Define state rest api template if no template is defined
            if (!state.templateUrl && !state.template && state.post) {

              //Resolve Extend
              state.resolve = angular.extend({}, state.resolve, {
                postObj: {service: 'wpNgRouterPostService'}
              });

              //State Extend
              state = angular.extend({}, state, {
                templateProvider: ['postObj', function (postObj) {

                  var content = config_router.templates.notFound;

                  if (angular.isDefined(postObj.content)) {

                    content = postObj.content.rendered;
                  }

                  return content;
                }]
              });

              //Define default controller if not exist
              if (!state.controller || state.controller.length === 0) {
                state.controller = 'wpNgRouterPostController';
              }
            }

            //Resolve
            state.resolve = (state.resolve && angular.isObject(state.resolve)) ? state.resolve : {};

            //Inject the string service with argument state
            angular.forEach(state.resolve, function (value, key) {

              state.resolve[key] = ['$injector', '$timeout', '$location', '$window', '$state', function ($injector, $timeout, $location, $window, $state) {

                var service = $injector.get(value.service)(state);

                if (angular.isFunction(service.then)) {
                  service.then(
                    function (success) {},
                    function (error) {

                      $timeout(function () {

                        var redirect = value.redirect;

                        if (angular.isString(redirect) && redirect.length > 0) {

                          $log.debug('UI Router redirect resolve error');
                          $log.debug(redirect);

                          //Is Internal route url
                          var state_url = redirect.split('/#')[1] || false;

                          if (state_url) {
                            var resolveError = state_url.split(/\?|#/);
                            $location.path(resolveError[0]);

                            if (resolveError[1]) {
                              $location.search(resolveError[1]);
                            }
                            if (resolveError[2]) {
                              $location.hash(resolveError[2]);
                            }
                            $location.replace();
                          }
                          else if (wpNg.isUrl(redirect)) {
                            $window.location.href = redirect;
                          }
                          else {
                            $state.go(redirect);
                          }
                        }
                        else {
                          $state.go('base');
                        }
                      });
                    }
                  );
                }

                return service;
              }];
            });

            $stateProvider.state(state);
          });
        }
      }
    ]);


    wpNg.app.run(['$rootScope', '$window', '$location', '$log', 'WP_NG_CONFIG', '$state', function ($rootScope, $window, $location, $log, WP_NG_CONFIG, $state) {

      $log.debug('WP NG Router Run');
      $log.debug($state.get());

      var config_router = WP_NG_CONFIG.modules['ui.router'];
      var wrap_exclude = '';

      //Find Exclude wrap
      if (config_router.wrap_exclude && config_router.wrap_exclude.length > 0 ) {
        wrap_exclude = angular.element(config_router.wrap).find(config_router.wrap_exclude);
      }

      //Wrapper for select view
      if (wrap_exclude.length === 0 && config_router.wrap && config_router.wrap.length > 0 ) {
        angular.element(config_router.wrap).html(config_router.templates.wrapperStart + angular.element(config_router.wrap).html() + config_router.templates.wrapperEnd);
      }

      //Prevent UI-Router State Change
      $rootScope.preventState = {
        enable: false,
        change: false
      };
      if (angular.isDefined(config_router.preventState)) {
        angular.extend($rootScope.preventState, config_router.preventState);
      }

      //Selected View
      $rootScope.selectView = '';

      //State loading status
      $rootScope.stateIsLoading = false;

      //UI-Router change location if state change and is not base URL.
      $rootScope.$on('$stateChangeStart', function (ev, toState, toParams, fromState, fromParams) {

        $rootScope.stateIsLoading = true;

        var base_url = (toState.baseUrl && toState.baseUrl.length > 0) ? toState.baseUrl : WP_NG_CONFIG.baseUrl;

        if ($rootScope.preventState.enable) {

          //Redirect if the state change is not on base URL
          var url = $window.location.protocol + '//' + $window.location.host + $window.location.pathname;
          var to_url = $state.href(toState.name);

          $log.debug(to_url);
          $log.debug(url);
          $log.debug(base_url);

          if (url !== base_url && to_url !== '#/') {
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


      $rootScope.$on('$locationChangeStart', function (ev, newUrl, oldUrl) {

        //Prevent State Change by $stateChangeStart
        if ($rootScope.preventState.change === true) {
          ev.preventDefault();
        }
      });

    }]);


    //Service Post
    wpNg.app.factory('wpNgRouterPostService', ['$injector', '$log', 'WP_NG_CONFIG', function ($injector, $log, WP_NG_CONFIG) {

      var rest_url = WP_NG_CONFIG.rest.url + WP_NG_CONFIG.rest.namespace;

      return function (state) {

        //Inject $resource from ngResource
        try {
          var $resource = $injector.get('$resource');

          var state_resource = $resource(rest_url + '/:base/:id',
            {base: '@base', id: '@id'},
            {
              get: {
                method: 'GET',
                isArray: false,
                cache: true
              }
            });

          return state_resource.get({base: state.post.restBase, id: state.post.id}).$promise;
        }
        catch (err) {
          $log.debug('Angular module "ngResource" is not loaded !');

          return false;
        }
      };

    }]);


    //Controller Post
    wpNg.app.controller('wpNgRouterPostController', ['$scope', 'WP_NG_CONFIG', 'postObj', function ($scope, WP_NG_CONFIG, postObj) {

      var vm = this;

      //Copy post property to this (controllerAs) view model.
      angular.extend(vm, postObj);

    }]);

  }

})(angular, wpNg);
