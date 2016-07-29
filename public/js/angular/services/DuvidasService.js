angular.module('oddin').factory('Duvidas', function($resource) {
    return $resource('/aulas/:id');
});

