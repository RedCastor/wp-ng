(function(angular, wpNg){
  'use strict';

  //Location Tool provide a encode and decode URI.
  wpNg.app.factory('locationTools', [ function() {
    return {
      encode: function(data) {
        return encodeURIComponent(JSON.stringify(data));
      },
      decode: function(str) {
        var uri = null;

        str = decodeURIComponent(str);
        try {
          uri =  JSON.parse(str);
        }catch(e) {
          uri = str;
        }

        return uri;
      }
    };
  }]);


  /**
   * Parse from source to dest from key source.
   * @param key
   * @param data
   * @param remove
   */
  wpNg.app.factory('parserTools', ['$location', 'locationTools',  function($location, locationTools) {
    return {
      fromSrcKey: function (dst, src, src_key, loc_remove) {

        if (!angular.isString(src_key) || !angular.isObject(src) || !angular.isObject(dst) ) {
          return {};
        }

        var dst_key = src[src_key];

        if (!dst_key || !angular.isObject(dst[dst_key])) {
          return {};
        }

        delete src[src_key];

        angular.forEach(src, function (_value, _key) {
          var _dst_value = dst[dst_key][_key];

          try {
            _value = locationTools.decode(_value);
          }
          catch (e) {

          }

          if (angular.isObject(_value)) {
            _dst_value = angular.isObject(_dst_value) ? _dst_value : {};
            dst[dst_key][_key] = angular.extend(_dst_value, _value);
          }
          else {
            dst[dst_key][_key] = _value;
          }

          if (loc_remove === true) {
            $location.search(_key, null);
          }

        });


        if (loc_remove === true) {
          $location.replace();
        }

        return dst[dst_key];
      }
    };
  }]);


})(angular, wpNg);
