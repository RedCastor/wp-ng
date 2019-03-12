//Directive Source from
// ngBindHtmlCompile: https://github.com/incuna/angular-bind-html-compile
// initialValue https://github.com/glaucocustodio/angular-initial-value

(function(angular, wpNg){
  'use strict';



  wpNg.app.directive("goBack", ["$window", function ($window) {
    return {
      restrict: "A",
      link: function (scope, elem, attrs) {
        elem.bind("click", function () {
          $window.history.back();
        });
      }
    };
  }]);

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


  /**
   * ng-update-hidden
   * http://blog.sapiensworks.com/post/2013/06/22/Binding-AngularJs-Model-to-Hidden-Fields.aspx
   */
  wpNg.app.directive('ngUpdateHidden',function() {
    return function(scope, el, attr) {

      var model = attr.ngModel;

      scope.$watch(model, function(nv) {
        el.val(nv);
      });

    };
  });


  wpNg.app.directive("passwordMatch", [ function() {
    return {
      restrict: 'A',
      scope:true,
      require: 'ngModel',
      link: function (scope, elem , attrs, modelCtrl) {
        var checker = function () {

          //get the value of the first password
          var e1 = scope.$eval(attrs.ngModel);

          //get the value of the other password
          var e2 = scope.$eval(attrs.passwordMatch);
          return e1 === e2;
        };
        scope.$watch(checker, function (n) {

          //set the form control to valid if both
          //passwords are the same, else invalid
          modelCtrl.$setValidity("unique", n);
        });
      }
    };
  }]);

  wpNg.app.directive("numbersOnly", [ function() {

      return {
        restrict: 'A',
        scope: {
          minNumbers: '&minNumber'
        },
        require: 'ngModel',
        link: function(scope, elem, attrs, modelCtrl) {

          modelCtrl.$parsers.push(function (inputValue) {

            if (!inputValue && inputValue !== 0) {
              return undefined;
            }

            var min_num = parseInt(((scope.minNumbers() ? scope.minNumbers() : attrs.numbersOnly) || 0), 10);

            var transformedInput = inputValue ? inputValue.toString().replace(/[^\d]/g,'') : min_num.toString();

            if (parseInt(transformedInput, 10) < min_num){
              transformedInput = min_num.toString();
            }

            if (attrs.type === 'number') {
              transformedInput = parseInt(transformedInput, 10);
            }

            if (transformedInput !== inputValue) {


              modelCtrl.$setViewValue(transformedInput);
              modelCtrl.$render();
            }

            return transformedInput;
          });
        }
      };
    }]);


  /**
   * angular-inital-value
   * https://github.com/glaucocustodio/angular-initial-value
   * Version 0.0.6
   *
   * Add check if initial value is set or not set
   */
  wpNg.app.directive('initialValue', [ function() {

    var removeIndent = function(str) {

      var result = "";

      if(str && typeof(str) === 'string') {
        var arr = str.split("\n");
        angular.forEach(arr, function(it, key) {
          result += it.trim();
          if (key > 0) {
            result += '\n';
          }
        });
      }

      return result;
    };

      return{
        restrict: 'A',
        controller: ['$scope', '$element', '$attrs', '$parse', function($scope, $element, $attrs, $parse){

          var getter, setter, val, tag, values;
          tag = $element[0].tagName.toLowerCase();
          val = $attrs.initialValue || removeIndent($element.val());

          //Set boolean if string is boolean
          val = (val === 'true') ? true : val;
          val = (val === 'false') ? false : val;


          if (val === 'on' && $element.attr('type') === 'checkbox') {
            val = undefined;
          }

          //Bypass check attribut if initial value is set.
          if(angular.isUndefined(val) || val === '') {

            if(tag === 'input'){
              if($element.attr('type') === 'checkbox'){
                val = $element.val === undefined ? $element[0].checked : val;
              } else if($element.attr('type') === 'radio'){
                val = ($element[0].checked || $element.attr('selected') !== undefined) ? $element.val() : undefined;
              } else if($element.attr('type') === 'number'){
                val = ($element.val()) ? parseFloat($element.val()) : null;
              } else if($element.attr('type') === 'color' || $element.attr('type') === 'range'){
                val = $element[0].getAttribute('value');
              } else if($element.attr('type') === 'date') {
                val = new Date(val.trim());
              }
            } else if( tag === "select"){
              values = [];
              for (var i=0; i < $element[0].options.length; i++) {
                var option = $element[0].options[i];
                if(option.hasAttribute('selected') && $element[0].hasAttribute('multiple')) {
                  values.push(option.text);
                } else if (!$element[0][0].disabled) {
                  val = option.text;
                }
              }
            }
          }
          else if($element.attr('type') === 'number'){
            val = parseFloat(val, 10);
          }

          if (values !== undefined && values.length) {
            val = values;
          }

          if($attrs.ngModel && val !== undefined){
            getter = $parse($attrs.ngModel);
            setter = getter.assign;
            setter($scope, val);
          }
        }]
      };
    }]);


  /**
   * Get Element Size Width and Height width debounce
   *
   * This approach watches an elements height and width and assigns it to a variable
   * on the scope provided on your elements attribute
   * https://stackoverflow.com/questions/19048985/angularjs-better-way-to-watch-for-height-change
   */
  wpNg.app.directive('elSize', ['$parse', '$timeout', '$window', function($parse, $timeout, $window) {

    return function(scope, elem, attrs) {

      var fn = $parse(attrs.elSize);
      var debounce = scope.$eval(attrs.sizeDebounce) || 250;
      var viewport = scope.$eval(attrs.viewport) || false;

      var debounce_timeout = null;

      function fn_debounce (callback, interval, size) {
        $timeout.cancel(debounce_timeout);

        var args = size;

        debounce_timeout = $timeout(function () {
          callback(args);
        }, interval);
      }


      function fn_apply ( size ) {

        fn.assign(scope, size);
      }

      //Window change
      function fn_w_change( now ) {

        var height = viewport === true ? window.screen.height : elem.height();
        var width = viewport === true ? window.screen.width : elem.width();

        var size = { width: width, height: height };

        fn_debounce(fn_apply, (now === true ? 0 : parseInt(debounce, 10)), size);
      }


      //Watch elem change
      scope.$watch(function() {

        return { width: elem.width(), height: elem.height() };
      }, function(new_size, old_size) {

        if ( angular.equals(new_size, old_size) ) {
          fn_debounce(fn_apply, parseInt(debounce, 10), new_size);
        }
      }, true);

      //Bind resize event
      angular.element($window).on('resize', fn_w_change(true));

      //Observe Dom Element change
      if (typeof MutationObserver === 'function') {

        var observer = new MutationObserver(function(mutations) {

          fn_w_change();
        });

        observer.observe(elem[0], {
          childList: true,
          subtree: true,
          characterData: true,
          attributes: true
        });
      }


      scope.$on('$destroy', function () {
        angular.element($window).off('resize', fn_w_change);
      });
    };
  }]);

})(angular, wpNg);
