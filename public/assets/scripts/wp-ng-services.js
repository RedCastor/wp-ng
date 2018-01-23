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

})(angular, wpNg);
