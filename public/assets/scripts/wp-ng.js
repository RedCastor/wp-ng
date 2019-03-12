//Angular bootstrap application with modules. Author: Auban le Grelle
(function (angular, window) {
  'use strict';

  var wpNg = window.wpNg;

  //Asign document ready to wpNg
  wpNg.ready = angular.element(document).ready;

  //Set the default application element
  if ( angular.isDefined(wpNg.appElement) && angular.isString(wpNg.appElement) && wpNg.appElement ) {
    wpNg.$appElement = angular.element(wpNg.appElement);
  }
  else {
    wpNg.$appElement = angular.element(document.body);
  }

  //Cloak application element
  if ( wpNg.config.cloak === true ) {
    wpNg.$appElement.addClass('ng-cloak');
  }

  //Preload application element
  if ( wpNg.config.preload === true ) {
    wpNg.$appElement.addClass('ng-preload');
  }

  //Add function wpNg.merge
  wpNg.merge = function (dst) {

    var slice = [].slice;
    var isArray = Array.isArray;

    function baseExtend(dst, objs, deep) {

      for (var i = 0, ii = objs.length; i < ii; ++i) {

        var obj = objs[i];

        if (!angular.isObject(obj) && !angular.isFunction(obj)) {
          continue;
        }

        var keys = Object.keys(obj);

        for (var j = 0, jj = keys.length; j < jj; j++) {

          var key = keys[j];
          var src = obj[key];

          if (deep && angular.isObject(src)) {

            if (!angular.isObject(dst[key])) {
              dst[key] = isArray(src) ? [] : {};
            }

            baseExtend(dst[key], [src], true);
          } else {

            dst[key] = src;
          }
        }
      }

      return dst;
    }

    return baseExtend(dst, slice.call(arguments, 1), true);
  };


  wpNg.forceReloadJS = function (src_url_contains) {

    angular.forEach(angular.element('script:empty[src*="' + src_url_contains + '"]'), function(el, index) {
      var oldSrc = angular.element(el).attr('src');
      var t = +new Date();
      var newSrc = oldSrc + '?' + t;

      angular.element(el).remove();
      angular.element('<script/>').attr('src', newSrc).appendTo('head');
    });
  };

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

  //Function to convert string to camelcase
  wpNg.camelize = function (str) {
    return str.replace(/\W+(.)/g, function(match, chr)
    {
      return chr.toUpperCase();
    });
  };

  //Function to check is url
  wpNg.isUrl = function (url)
  {
    if (url.indexOf('/') === 0) {return true;} // URL does not contain a single slash (= relative)
    if (url.indexOf('//') === 0) {return true;} // URL is protocol-relative (= absolute)
    if (url.indexOf('://') === -1) {return false;} // URL has protocol (= relative)

    return false;
  };

  //Function to create one time event
  wpNg.one = function (el, eventNames, fn) {

    function addListenerMulti(el, eventNames, listener) {
      var events = eventNames.split(' ');
      for (var i=0, iLen=events.length; i<iLen; i++) {
        el.addEventListener(events[i], listener, false);
      }
    }

    function removeListenerMulti(el, eventNames, listener) {
      var events = eventNames.split(' ');
      for (var i=0, iLen=events.length; i<iLen; i++) {
        el.removeEventListener(events[i], listener, false);
      }
    }

    function handler(event) {
      try{
        fn(event);
      } finally {
        removeListenerMulti(el, eventNames, handler);
      }
    }

    addListenerMulti(el, eventNames, handler);
  };

  //Bootstrap the angular application
  window.deferredBootstrapper.bootstrap({
    element: wpNg.$appElement,
    module: wpNg.appName,
    resolve: {
      WP_NG_CONFIG: ['$q', '$$cookieReader', function ($q, $$cookieReader) {
        var deferred = $q.defer();

        var cookie_config = angular.fromJson($$cookieReader().wpNgConfig) || {};

        //Merge config with cookie config (Used config cookie on WP_CACHE enabled).
        wpNg.config = wpNg.merge(wpNg.config, cookie_config);

        deferred.resolve(wpNg.config);
        return deferred.promise;
      }]
    }
  });


  //Create Root Application with all dependencie modules
  wpNg.app = angular.module(wpNg.appName, wpNg.ngModules);


  //Run Application
  wpNg.app.run(['$rootScope', '$injector', '$window', '$location', '$timeout', '$log', 'WP_NG_CONFIG',
    function ( $rootScope, $injector, $window, $location, $timeout, $log, WP_NG_CONFIG ) {

      //Access root config
      $rootScope.wpNgConfig = WP_NG_CONFIG;

      //Foundation initialize
      function foundationInit() {
        var element = 'body';

        if (angular.isObject(WP_NG_CONFIG.modules['mm.foundation']) && WP_NG_CONFIG.modules['mm.foundation'].init) {

          element = WP_NG_CONFIG.modules['mm.foundation'].element || 'body';
        }

        if (typeof angular.element(element).foundation === "function") {
          angular.element(element).foundation();
        }
        else {
          $log.error('Function foundation not exist.');
        }

        return element;
      }

      //Object fit images polyfill
      function objectFitImagesInit() {

        //Initialize Extra Script objectFitImages if exist.
        //ObjectFit associate with ngAntomoderate
        if (
          angular.isDefined(WP_NG_CONFIG.scripts.objectFitImages) &&
          angular.isDefined($window.objectFitImages) &&
          angular.isFunction($window.objectFitImages)) {

          objectFitImages(WP_NG_CONFIG.scripts.objectFitImages.element);

          $log.debug('objectFitImages Initialized');
        }
      }


      //Timeout use for angular ready
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

        //Initialize Extra Script objectFitImages if exist.
        //ObjectFit associate with ngAntomoderate
        objectFitImagesInit();

        //Initialize Extra script AOS if exist.
        if (angular.isDefined(WP_NG_CONFIG.scripts.aos) && angular.isDefined($window.AOS)) {

          AOS.init(WP_NG_CONFIG.scripts.aos);

          $log.debug('AOS Initialized');
        }

        //Initialize Extra script AOT if exist.
        if (angular.isDefined(WP_NG_CONFIG.scripts.aot) && angular.isDefined(WP_NG_CONFIG.scripts.aot.selector) && typeof document.querySelector('body').AOTinitAll === 'function') {

          document.querySelector(WP_NG_CONFIG.scripts.aot.selector).AOTinitAll(WP_NG_CONFIG.scripts.aot.options);

          $log.debug('AOT Initialized');
        }

        //Foundation initialize
        var element = foundationInit();
        if (element) {
          $log.info('Foundation initialized on element "' + element + '".');
        }


        //Initialize Extra script Scrollify if exist.
        if ( angular.isDefined( wpNg.config.scripts.scrollify ) && angular.isDefined( angular.element.scrollify ) ) {

          var scrollify_config = wpNg.config.scripts.scrollify;

          scrollify_config.before = function(i, panels) {

          };

          scrollify_config.after = function(i, panels) {

          };

          scrollify_config.afterRender = function() {

            if(angular.isDefined(wpNg.config.scripts.scrollify.moveClick)) {
              angular.element(wpNg.config.scripts.scrollify.moveClick).on('click', jQuery.scrollify.move);
            }

            if (angular.isDefined(wpNg.config.scripts.scrollify.nextClick)) {
              angular.element(wpNg.config.scripts.scrollify.nextClick).on('click', jQuery.scrollify.next);
            }

            if (angular.isDefined(wpNg.config.scripts.scrollify.previousClick)) {
              angular.element(wpNg.config.scripts.scrollify.previousClick).on('click', jQuery.scrollify.previous);
            }

            angular.element('body').addClass('is-scrollify');

            $log.debug('Scrollify Initialized');
          };

          //Fix negative offset on the last interstitialSection with add bottom padding positive offset.
          if (scrollify_config.offset < 0) {
            var $sections = angular.element('body').find(scrollify_config.interstitialSection);

            $sections[$sections.length - 1].style.paddingBottom = Math.abs(scrollify_config.offset) + 'px';
          }

          angular.element.scrollify(scrollify_config);
        }

      }, 0);


      //Workaround form not send if action not defined add action empty. (woocommerce add to cart).
      wpNg.$appElement.find('form').each(function( index ) {

        if (
          angular.element(this).attr('action') === undefined &&
          angular.element(this).attr('data-ng-submit') === undefined &&
          angular.element(this).attr('ng-submit') === undefined
        ) {
          angular.element(this).attr('action', '');
        }
      });

      //Event used to reinit some plugins or modules after lazyloaded
      var timeout_oclazyload;

      $rootScope.$on('ocLazyLoad.moduleLoaded', function(e, module) {

        $timeout.cancel(timeout_oclazyload);

        timeout_oclazyload = $timeout(function() {

          //Foundation reInitialize (prevent foundation plugins loaded after first init)
          foundationInit();

          //ObjectFit reInitialize (prevent object fit plugins loaded after first init)
          objectFitImagesInit();
        }, 0);
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
            var locationTools = $injector.get('locationTools');
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

    }
  ]);

  //Initialize Extra script Web Font Loader if exist.
  if ( angular.isDefined( wpNg.config.scripts.WebFont ) ) {
    window.WebFontConfig = wpNg.config.scripts.WebFont;

    var html = document.querySelector('html');
    html.classList.add('wf-load');

    //Remove class load
    window.WebFontConfig.loading = function(familyName, fvd) {
      html.classList.remove('wf-load');
    };

    //Add class font family active
    window.WebFontConfig.fontactive = function(familyName, fvd) {
      html.classList.add('wf-' + familyName.replace(/[^a-zA-Z0-9]/g, '').toLowerCase() + '-active');
      html.classList.add('wf-animated');
    };

    //Add class font family inactive
    window.WebFontConfig.fontinactive = function(familyName, fvd) {
      html.classList.add('wf-' + familyName.replace(/[^a-zA-Z0-9]/g, '').toLowerCase() + '-inactive');
      html.classList.add('wf-animated');
    };

    //Create one time event for remove at transitionEnd. This is for compatibility with ng-animate
    wpNg.one(html, 'transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd', function () {
      html.classList.remove('wf-animated');
    });

  }

  //Initialize Extra script Animsition if exist.
  if ( angular.isDefined( wpNg.config.scripts.animsition ) ) {

    angular.element(wpNg.config.scripts.animsition.element).addClass(wpNg.config.scripts.animsition.class);

    wpNg.ready( function() {

      var $animsition = angular.element(wpNg.config.scripts.animsition.element + '.' + wpNg.config.scripts.animsition.class);
      var animsition_config = angular.extend( {
        loadingParentElement: $animsition.parent(),
        overlayParentElement: $animsition.parent(),
      }, wpNg.config.scripts.animsition.config );

      animsition_config.transition = function (url) {
        window.location.href = url;
      };

      $animsition.animsition(animsition_config);
    });
  }

  //wpNg Ready
  wpNg.ready( function() {

    var str_ready = 'Ready: ';
    var str_love = 'Love Review it: ';

    if((window.navigator.userAgent.indexOf('Chrome') !== -1 )) {
      var style = 'line-height: 1.5; font-size: 24px; background-image: url("' + wpNg.config.distUrl + 'images/icon-128x128.png"); color: transparent; background-repeat: no-repeat; background-size: contain';
      var color = '#21759A';
      console.group('WP NG');
      console.log('%c00', style);
      console.log('%c' + str_ready + '%c' + wpNg.config.githubUrl, '', 'color: ' + color);
      console.log('%c' + str_love + '%c' + wpNg.config.wpUrl, '', 'color: ' + color);
      console.groupEnd();
    }
    else {
      console.info( str_ready + wpNg.config.githubUrl );
      console.info( str_love + wpNg.config.wpUrl );
    }
  });

}(angular, window));

