//Angular Config application modules. Author: Auban le Grelle
(function (angular, wpNg) {
  'use strict';

  //Configure LazyLoad modules.
  if ( angular.isDefined(wpNg.config.modules['oc.lazyLoad']) ) {
    wpNg.app.config(['$ocLazyLoadProvider', 'WP_NG_CONFIG' , function($ocLazyLoadProvider, WP_NG_CONFIG) {

      $ocLazyLoadProvider.config(WP_NG_CONFIG.modules['oc.lazyLoad']);
    }]);
  }

  //Configure Rollbar module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules.rcRollbar) ) {
    wpNg.app.config(['RollbarProvider', 'WP_NG_CONFIG', function (RollbarProvider, WP_NG_CONFIG) {

      var payload = {
        environment: WP_NG_CONFIG.env,
        framework: 'WP-NG'
      };

      if ( angular.isDefined(WP_NG_CONFIG.modules.rcRollbar.payload) ) {
        WP_NG_CONFIG.modules.rcRollbar.payload = angular.extend({}, payload, WP_NG_CONFIG.modules.rcRollbar.payload);
      }

      RollbarProvider.init(WP_NG_CONFIG.modules.rcRollbar);
    }]);
  }


  //Filter config disable animation on element with class 'ng-animate-disabled'
  if ( angular.isDefined(wpNg.ngModules.ngAnimate) ) {
    wpNg.app.config(['$animateProvider', function ($animateProvider) {
      $animateProvider.classNameFilter(/^(?:(?!ng-animate-disabled).)*$/);
    }]);
  }


  //Configure Antimoderae module provider
  if ( angular.isDefined(wpNg.config.modules.ngAntimoderate) ) {
    wpNg.app.config(['$ngAntimoderateProvider', 'WP_NG_CONFIG', function ($ngAntimoderateProvider, WP_NG_CONFIG) {
      $ngAntimoderateProvider.setSrc( WP_NG_CONFIG.modules.ngAntimoderate.src );
    }]);
  }


  //Configure Rest module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules.wpNgRest) ) {
    wpNg.app.config(['wpNgRestProvider', 'WP_NG_CONFIG', function (wpNgRestProvider, WP_NG_CONFIG) {

      if ( angular.isDefined(WP_NG_CONFIG.modules.wpNgRest.restNonceKey) && angular.isDefined(WP_NG_CONFIG.modules.wpNgRest.restNonceVal) ) {
        wpNgRestProvider.setNonce({
          key: WP_NG_CONFIG.modules.wpNgRest.restNonceKey,
          val: WP_NG_CONFIG.modules.wpNgRest.restNonceVal,
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

  //Configure Iso Currencies module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules.isoCurrencies) ) {
    wpNg.app.config(['isoCurrenciesProvider', 'WP_NG_CONFIG', function (isoCurrenciesProvider, WP_NG_CONFIG) {

      if ( angular.isDefined(WP_NG_CONFIG.modules.isoCurrencies.code) ) {
        isoCurrenciesProvider.setByCode(WP_NG_CONFIG.modules.isoCurrencies.code);
      }

      if ( angular.isDefined(WP_NG_CONFIG.modules.isoCurrencies.text) ) {
        isoCurrenciesProvider.setText(WP_NG_CONFIG.modules.isoCurrencies.text);
      }

      if ( angular.isDefined(WP_NG_CONFIG.modules.isoCurrencies.fraction) ) {
        isoCurrenciesProvider.setFraction(WP_NG_CONFIG.modules.isoCurrencies.fraction);
      }

      if ( angular.isDefined(WP_NG_CONFIG.modules.isoCurrencies.symbol) ) {
        isoCurrenciesProvider.setSymbol(WP_NG_CONFIG.modules.isoCurrencies.symbol);
      }

      if ( angular.isDefined(WP_NG_CONFIG.modules.isoCurrencies.position) ) {
        isoCurrenciesProvider.setPosition(WP_NG_CONFIG.modules.isoCurrencies.position);
      }

      if ( angular.isDefined(WP_NG_CONFIG.modules.isoCurrencies.decimalSep) ) {
        isoCurrenciesProvider.setDecimalSep(WP_NG_CONFIG.modules.isoCurrencies.decimalSep);
      }

      if ( angular.isDefined(WP_NG_CONFIG.modules.isoCurrencies.thousandSep) ) {
        isoCurrenciesProvider.setThousandSep(WP_NG_CONFIG.modules.isoCurrencies.thousandSep);
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

  //Configure webicon module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules.webicon) ) {
    wpNg.app.config(['$webiconProvider', 'WP_NG_CONFIG', function ($webiconProvider, WP_NG_CONFIG) {

      if ( angular.isDefined(WP_NG_CONFIG.modules.webicon.sources) && angular.isObject(WP_NG_CONFIG.modules.webicon.sources) ) {

        angular.forEach(WP_NG_CONFIG.modules.webicon.sources, function (value, key) {
          $webiconProvider.svgSet(key, value);
        });
      }

      if ( angular.isDefined(WP_NG_CONFIG.modules.webicon.alias) && angular.isObject(WP_NG_CONFIG.modules.webicon.alias) ) {

        angular.forEach(WP_NG_CONFIG.modules.webicon.alias, function (value, key) {
          $webiconProvider.alias(value, key);
        });
      }

      if ( angular.isDefined(WP_NG_CONFIG.modules.webicon.icon) && angular.isObject(WP_NG_CONFIG.modules.webicon.icon) ) {

        angular.forEach(WP_NG_CONFIG.modules.webicon.icon, function (value, key) {
          $webiconProvider.icon(key, value);
        });
      }
    }]);
  }

  //Configure ui.select module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules['ui.select']) ) {
    wpNg.app.config(['uiSelectConfig', 'WP_NG_CONFIG', function (uiSelectConfig, WP_NG_CONFIG) {

      uiSelectConfig.theme = WP_NG_CONFIG.modules['ui.select'].theme;
    }]);
  }

  //Configure rcMedia module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules.rcMedia) ) {
    wpNg.app.config(['rcMediaProvider', 'WP_NG_CONFIG', function (rcMediaProvider, WP_NG_CONFIG) {

      rcMediaProvider.setRest({
        url: WP_NG_CONFIG.modules.rcMedia.restUrl,
        path: WP_NG_CONFIG.modules.rcMedia.restPath
      });

      rcMediaProvider.useLocale(WP_NG_CONFIG.currentLang);
    }]);
  }

  //Configure rcGalleryUitegallery module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules.rcGalleryUnitegallery) ) {
    wpNg.app.config(['rcGalleryUnitegalleryProvider', 'WP_NG_CONFIG', function (rcGalleryUnitegalleryProvider, WP_NG_CONFIG) {

      if ( angular.isDefined(WP_NG_CONFIG.modules.rcGalleryUnitegallery.urls) ) {
        rcGalleryUnitegalleryProvider.setUrls( WP_NG_CONFIG.modules.rcGalleryUnitegallery.urls );
      }
    }]);
  }

  //Configure rcGalleryGalleria module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules.rcGalleryGalleria) ) {
    wpNg.app.config(['rcGalleryGalleriaProvider', 'WP_NG_CONFIG', function (rcGalleryGalleriaProvider, WP_NG_CONFIG) {

      if ( angular.isDefined(WP_NG_CONFIG.modules.rcGalleryGalleria.urls) ) {
        rcGalleryGalleriaProvider.setUrls( WP_NG_CONFIG.modules.rcGalleryGalleria.urls );
      }

      if ( angular.isDefined(WP_NG_CONFIG.modules.rcGalleryGalleria.themeUrls) ) {
        rcGalleryGalleriaProvider.setThemeUrls( WP_NG_CONFIG.modules.rcGalleryGalleria.themeUrls );
      }
    }]);
  }

  //Configure rcGalleria module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules.rcGalleria) ) {
    wpNg.app.config(['rcGalleriaProvider', 'WP_NG_CONFIG', function (rcGalleriaProvider, WP_NG_CONFIG) {

      rcGalleriaProvider.setPath( WP_NG_CONFIG.modules.rcGalleria.path );
      rcGalleriaProvider.setTheme( WP_NG_CONFIG.modules.rcGalleria.theme );
      rcGalleriaProvider.setOptions( WP_NG_CONFIG.modules.rcGalleria.options );
    }]);
  }

  //Configure 720kb.socialshare module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules['720kb.socialshare']) ) {
    wpNg.app.config(['socialshareConfProvider', 'WP_NG_CONFIG', function (socialshareConfProvider, WP_NG_CONFIG) {

      socialshareConfProvider.configure(WP_NG_CONFIG.modules['720kb.socialshare']);
    }]);
  }

  //Configure jtt_aping module provider if module is declared in modules.
  if ( angular.isDefined(wpNg.config.modules.jtt_aping) ) {
    wpNg.app.config(['$provide', 'WP_NG_CONFIG', function ($provide, WP_NG_CONFIG) {

      $provide.value('apingDefaultSettings', {
        //templateUrl: '<PATH_TO_YOUR_DEFAULT_DESIGN>',
        //items: 20, //items per request
        //maxItems: 100, //max items per aping
        //orderBy: 'timestamp',
        //orderReverse: 'true',
        //model: 'social',
        //getNativeData: false,
        //removeDoubles: false,
        apingApiKeys: {
          instagram: [
            {'access_token': WP_NG_CONFIG.modules.jtt_aping.instagram.access_token}
          ],
          facebook: [
            {'access_token': WP_NG_CONFIG.modules.jtt_aping.facebook.access_token}
          ],
          twitter: [
            {'bearer_token': WP_NG_CONFIG.modules.jtt_aping.twitter.bearer_token}
          ],
          vimeo: [
            {'access_token': WP_NG_CONFIG.modules.jtt_aping.vimeo.access_token}
          ],
          youtube: [
            {'apiKey': WP_NG_CONFIG.modules.jtt_aping.youtube.apiKey}
          ],
          tumblr: [
            {'api_key': WP_NG_CONFIG.modules.jtt_aping.tumblr.api_key}
          ],
          openweathermap: [
            {'api_key': WP_NG_CONFIG.modules.jtt_aping.openweathermap.api_key}
          ]
        }
      });
    }]);
  }

  //Set the Debug Mode
  wpNg.app.config(['$compileProvider', '$logProvider', '$qProvider', '$locationProvider', 'WP_NG_CONFIG',
    function ($compileProvider, $logProvider, $qProvider, $locationProvider, WP_NG_CONFIG) {
      //Set debug Enable
      $logProvider.debugEnabled(WP_NG_CONFIG.enableDebug);
      $compileProvider.debugInfoEnabled(WP_NG_CONFIG.enableDebug);


      //Disable error Rejections
      $qProvider.errorOnUnhandledRejections(WP_NG_CONFIG.errorOnUnhandledRejections);

      //Set Html5 false and hash prefix to empty backward compatibility to 1.5
      $locationProvider.html5Mode(WP_NG_CONFIG.html5Mode).hashPrefix(WP_NG_CONFIG.hashPrefix);
  }]);


  //Add function to form directive for validate form on submit
  // example: $scope.myFormName.$setTouched();
  // example: $scope.myFormName.$validate();
  wpNg.app.config([ '$provide', function($provide) {

    $provide.decorator('formDirective', ['$delegate', function $formDecorator($delegate) {

      var fn = $delegate[0].controller.prototype;

      function control (form, callback) {
        if (form.$invalid) {

          angular.forEach(form, function(control, name) {
            // Excludes internal angular properties
            if (typeof name === 'string' && name.charAt(0) !== '$') {
              control[callback]();
            }
          });
        }
      }

      if (!('$setTouched' in fn)) {
        fn.$setTouched = function() {
          control(this, '$setTouched');
        };
      }

      if (!('$validate' in fn)) {
        fn.$validate = function() {
          control(this, '$validate');
        };
      }

      return $delegate;
    }]);
  }]);

})(angular, wpNg);
