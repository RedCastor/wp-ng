(function (angular) {
  'use strict';


  var wpNgRest = angular.module('wpNgRest', [
    'ngResource'
  ]);

  wpNgRest.config(['$resourceProvider',  function($resourceProvider) {
    $resourceProvider.defaults.cancellable = true;
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

      if(angular.isDefined(nonce.key) && angular.isDefined(nonce.val) && nonce.key.length > 0 && nonce.val.length > 0) {
        $http.defaults.headers.common[nonce.key] = nonce.val;
      }

      if(angular.isDefined(lang.key) && angular.isDefined(lang.val) && lang.key.length > 0 && lang.val.length > 0 ) {
        $http.defaults.headers.common[lang.key] = lang.val;
      }

      $http.defaults.useXDomain = true;

      // Disable IE ajax request caching
      $http.defaults.headers.common['If-Modified-Since']  = '0';
      //Disable caching
      $http.defaults.headers.common['cache-control']      = 'private, max-age=0, no-cache';


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

  wpNgRest.factory( 'wpNgRestStatus', [ '$rootScope', function ($rootScope) {

    var service = {

      reset: function() {
        return {
          success: false,
          statusCode: null,
          code: null,
          message: null
        };
      },

      setSuccess: function(response) {
        var status = {
          success: true,
          statusCode: null,
          code: null,
          message: null
        };

        status.statusCode = response.status;

        if (response.messages !== undefined && angular.isArray(response.messages)) {
          status.code = response.messages[0].code;
          status.message = response.messages[0].message;
        }
        else if (response.message !== undefined && angular.isObject(response.message)) {
          status.code = response.message.code;
          status.message = response.message.message;
        }
        else if (response.message !== undefined) {
          status.message = response.message;
        }

        return status;
      },

      setError: function(response) {

        var status = {
          success: false,
          statusCode: null,
          code: null,
          message: null
        };

        status.statusCode = response.status;

        if (response.data === null || response.data === undefined) {
          status.code = response.status;
          status.message = 'An error occured on request';
        }
        else {
          status.code = response.data.code;
          status.message = response.data.message;

          //Use on bulk action multi error messages
          if ( angular.isDefined(response.data.data) && angular.isObject(response.data.data) && angular.isDefined(response.data.data.errors) ) {
            status.errors = response.data.data.errors;
          }
        }

        return status;
      },

      sendEvent: function(name, args) {
        $rootScope.$broadcast(name, args);
      }

    };

    return service;

  }]);

}(angular));

