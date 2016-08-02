angular.module('oddin').factory('Login', function($resource) {
    return $resource('/loginTeste');
});
