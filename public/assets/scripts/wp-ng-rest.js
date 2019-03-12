(function (angular) {
  'use strict';


  var module_name = 'wpNgRest';
  var modules_dep = ['ngResource'];

  // Create module wp-ng rest module
  var wpNgRest = angular.module(module_name, modules_dep);


  wpNgRest.config(['$resourceProvider', '$httpProvider',  function($resourceProvider, $httpProvider) {
    $resourceProvider.defaults.cancellable = true;
    $httpProvider.interceptors.push('wpNgRestHttpInterceptor');
  }]);

  wpNgRest.provider('wpNgRest', [ function wpNgRestProvider() {

    this.nonce = {
      key: 'X-WP-NG-Nonce',
      val:''
    };

    this.rest = {
      url: 'localhost/',
      path: ''
    };

    this.lang = {
      key: 'X-WP-NG-Lang',
      val:''
    };


    this.$get = [ '$http', function( $http ) {
      var nonce = this.nonce;
      var rest = this.rest;
      var lang = this.lang;

      $http.defaults.useXDomain = true;

      return {
        getNonce: function() {
          return nonce;
        },
        getRest: function() {
          return rest;
        },
        getLang: function() {
          return lang;
        }
      };
    }];

    this.setNonce = function(nonce) {
      this.nonce = nonce;
    };

    this.setRest = function(rest) {
      this.rest = rest;
    };

    this.setLang = function(lang) {
      this.lang = lang;
    };

  }]);

  wpNgRest.factory( 'wpNgRestStatus', [ '$rootScope', 'wpNgRest', function ($rootScope, wpNgRest) {

    var nonce = wpNgRest.getNonce();

    var service = {

      reset: function() {
        return {
          success: false,
          statusCode: null,
          code: null,
          message: null
        };
      },
      setNonce: function (new_nonce) {
        nonce = new_nonce;
      },
      getNonce: function () {
        return nonce;
      },
      setSuccess: function(response) {
        var status = service.reset();

        status.success = true;
        status.statusCode = response.status;

        if (angular.isDefined(response.messages) && angular.isArray(response.messages)) {
          status.code = response.messages[0].code;
          status.message = response.messages[0].message;
        }
        else if (angular.isDefined(response.message) && angular.isObject(response.message)) {
          status.code = response.message.code;
          status.message = response.message.message;
        }
        else if (angular.isDefined(response.message) && angular.isString(response.message)) {
          status.message = response.message;
        }

        return status;
      },

      setError: function(response) {

        var status = service.reset();

        status.statusCode = response.status;

        if ( angular.isDefined(response.data) && angular.isObject(response.data)) {
          status.code = response.data.code;
          status.message = response.data.message;

          //Use on bulk action multi error messages
          if ( angular.isDefined(response.data.data) && angular.isObject(response.data.data) && angular.isDefined(response.data.data.errors) ) {
            status.errors = response.data.data.errors;
          }
        }
        else {
          status.code = response.status;
          status.message = 'An error occured on the request.';
        }

        return status;
      },

      sendEvent: function(name, args) {
        $rootScope.$broadcast(name, args);
      }

    };

    return service;

  }]);


  wpNgRest.factory('wpNgRestHttpInterceptor', ['$injector', function($injector){

    var retry_request = [];

    function _update_nonce(response) {

      var wpNgRestStatus = $injector.get("wpNgRestStatus");

      var nonce = wpNgRestStatus.getNonce();
      var nonce_val = response.headers(nonce.key);

      //Update nonce if is changed
      if (nonce_val && nonce_val !== nonce.val) {
        nonce.val = nonce_val;
        wpNgRestStatus.setNonce(nonce);
      }
    }


    return {
      request: function (request) {

        if (!angular.isString(request.url)) {
          return request;
        }

        //Set Headers if is request on rest api
        var wpNgRest = $injector.get("wpNgRest");
        var rest_url = wpNgRest.getRest().url + wpNgRest.getRest().path;

        var match_api_url = request.url.indexOf(rest_url) >= 0;

        if (match_api_url) {
          var wpNgRestStatus = $injector.get("wpNgRestStatus");
          var nonce = wpNgRestStatus.getNonce();
          var lang = wpNgRest.getLang();

          if(angular.isDefined(nonce.key) && angular.isString(nonce.key) && angular.isDefined(nonce.val) && angular.isString(nonce.val) && nonce.key.length > 0 && nonce.val.length > 0) {
            request.headers[nonce.key] = nonce.val;
          }

          if(angular.isDefined(lang.key) && angular.isString(lang.key) && angular.isDefined(lang.val) && angular.isString(lang.val) && lang.key.length > 0 && lang.val.length > 0 ) {
            request.headers[lang.key] = lang.val;
          }

          // Disable IE ajax request caching
          request.headers['If-Modified-Since']  = '0';
          //Disable caching
          request.headers['cache-control']      = 'private, max-age=0, no-cache';
        }

        return request;
      },
      response: function( response ) {

        _update_nonce(response);

        return response;
      },
      responseError: function(response) {

        var $q = $injector.get("$q");
        var retry_index = response.config ? retry_request.indexOf(response.config.url) : -1;

        if (response.status === 406 && retry_index === -1) {
          var deferred = $q.defer();

          _update_nonce(response);

          retry_request.push(response.config.url);

          //Resend request after update nonce
          $injector.get("$http")(response.config).then(
            function(resend_response) {

              _update_nonce(resend_response);

              delete retry_request[retry_index];
              deferred.resolve(resend_response);
            },function(resend_response) {

              if (resend_response.status === 406) {
                var $window = $injector.get("$window");

                //Reload page if error 406 nonce error. Force renew nonce on server
                $window.location.reload();
              }

              delete retry_request[retry_index];
              deferred.reject(resend_response);
            }
          );

          return deferred.promise;
        }
        else {
          return $q.reject(response);
        }
      }
    };

  }]);

}(angular));

