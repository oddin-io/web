angular.module('oddin').factory('Material', function($resource) {
    return $resource('/materials')
})
