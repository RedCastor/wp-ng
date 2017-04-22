//Directive Source from https://github.com/incuna/angular-bind-html-compile

(function(angular, wpNg){
  'use strict';

  wpNg.app.directive('ngBindHtmlCompile', ['$compile', function ($compile) {
    return {
      restrict: 'A',
      link: function (scope, element, attrs) {

        scope.$watch(
          function () {

            return scope.$eval(attrs.ngBindHtmlCompile);

          }, function (value) {

            // In case value is a TrustedValueHolderType, sometimes it
            // needs to be explicitly called into a string in order to
            // get the HTML string.
            element.html(value && value.toString());

            // If scope is provided use it, otherwise use parent scope
            var compileScope = scope;

            if (attrs.ngBindHtmlScope) {
              compileScope = scope.$eval(attrs.ngBindHtmlScope);
            }

            $compile(element.contents())(compileScope);
          }
        );

      }
    };
  }]);


  wpNg.app.directive("ifModuleLoaded", [ '$compile', function ($compile) {
    return {
      priority: 1000000,
      terminal: true,
      compile: function(element, attrs) {

        try {
          //Check Module exist
          angular.module(attrs.ifModuleLoaded);

          //remove ngIfModuleLoaded directive and recompile
          attrs.$set('ifModuleLoaded', null);
          return function(scope, element) {
            $compile(element)(scope);
          };
        }
        catch(err) {
          element.remove();
        }
      }
    };
  }]);

})(angular, wpNg);
