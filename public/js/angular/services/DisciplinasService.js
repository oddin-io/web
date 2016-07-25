angular.module('oddin').factory('Disciplinas', function($resource) {
    return $resource('/disciplinas/:id');
});

