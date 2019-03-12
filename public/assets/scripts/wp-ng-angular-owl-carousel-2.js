(function (angular, wpNg) {
  'use strict';

  //Decorator angular-owl-carousel-2
  wpNg.app.config(['$provide', function($provide) {

    $provide.decorator('ngOwlCarouselDirective', ['$delegate', '$window', 'WP_NG_CONFIG', function $ngOwlCarouselDecorator($delegate, $window, WP_NG_CONFIG) {

      var directive = $delegate[0];

      var compile = directive.compile;

      directive.compile = function(tElement, tAttrs) {
        var link = compile.apply(this, arguments);

        return function(scope, elem, attrs, owlCtrl) {
          link.apply(this, arguments);

          var owl = angular.element('.owl-carousel', elem);
          var aotElements = [];

          //Owl Animation
          //Owl Animation
          owlCtrl.applyAnimation = function ( target, current, timeout ) {

            var min = target.minimum();
            var size = target.settings && (target.settings.center || target.settings.autoWidth || target.settings.dotsData ? 1 : target.settings.dotsEach || target.settings.items);

            current = !current ? target.current() : current;

            var display_items = [];

            //Find clones for current visible items
            for (var i = 0; i < size; i++) {

              var index = target.relative(current) + i;
              var clones = target.clones(index);

              clones.push(index + min);
              display_items.push(clones);
            }

            //Animate items
            angular.forEach(aotElements, function(aot_elem, key) {

              var is_visible = false;

              angular.forEach(display_items, function(display_item, item_key) {
                if ( display_item.indexOf(key) !== -1 ){
                  is_visible = item_key;
                }
              });

              if ( is_visible || key >= current && key < current + size ){
                aotElements[key].AOTanimate(true, parseInt(is_visible * timeout, 10) );
              }
              else {
                aotElements[key].AOTanimate(false);
              }

            });
          };

          /**
           * Events
           */
          // Fired after init
          owl.on('initialized.owl.carousel', function(event) {

            if (typeof event.target.AOTinitAll === 'function') {

              aotElements = event.target.AOTinitAll(event.relatedTarget.options.itemElement);
              owlCtrl.applyAnimation( event.relatedTarget);
            }
          });

          // Fired before current slide change
          owl.on('change.owl.carousel', function(event) {

            if (typeof event.target.AOTanimate === 'function' && event.property.name === 'position') {
              owlCtrl.applyAnimation( event.relatedTarget, event.property.value );
            }
          });


          owl.on('loaded.owl.lazy', function (event) {
            if (
              angular.isDefined(WP_NG_CONFIG.scripts.objectFitImages) &&
              angular.isDefined($window.objectFitImages) &&
              angular.isFunction($window.objectFitImages)) {
              objectFitImages(WP_NG_CONFIG.scripts.objectFitImages.element);
            }
          });

        };

      };

      return $delegate;
    }]);
  }]);

})(angular, wpNg);
