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

})(angular, wpNg);
