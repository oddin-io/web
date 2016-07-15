angular.module('oddin-auth').factory('Login', function($resource) {
    return $resource('/');
});
