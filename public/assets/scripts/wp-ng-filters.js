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

})(angular, wpNg);
