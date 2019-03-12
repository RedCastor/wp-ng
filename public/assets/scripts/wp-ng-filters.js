(function(angular, wpNg){
  'use strict';

  wpNg.app.filter('isEmpty', ['$filter', function( $filter ) {
    return function(object) {
        return angular.equals({}, object);
    };
  }]);


  wpNg.app.filter('html', ['$filter', '$sce' ,function($filter, $sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
    };
  }]);


  // Is in Dev not use in production
  wpNg.app.filter('groupByObject', [ '$interpolate', function ( $interpolate ) {
    var results={};

    return function (collection, object) {

      return _map_collection_by_object(collection, object);


      function _map_collection_by_object(collection, object) {

        var filteredInput = {};

        if (angular.isArray()) {
          filteredInput = [];
        }

        angular.forEach(collection, function (value, key) {
          var new_object = {};

          angular.forEach(object, function (filterVal, filterKey) {
            if (angular.isUndefined(value[filterKey])) {
              var exp = $interpolate(filterVal);
              new_object[filterKey] = exp(value);
            }
            else {
              new_object[filterVal] = value[filterKey];
              delete value[filterKey];
            }
          });

          if (!angular.equals({}, new_object)) {
            filteredInput[key] = new_object;
          }
        });
      }
    };
  }]);


  wpNg.app.filter('shuffle', [ function ($filter) {

    return function( data ) {

      var m = data.length, t, i;

      while( m ) {
        i = Math.floor(Math.random() * m--);
        t = data[m];
        data[m] = data[i];
        data[i] = t;
      }

      return data;
    };
  }]);

})(angular, wpNg);
