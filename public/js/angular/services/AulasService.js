angular.module('oddin').factory('Aulas', function($resource) {
    return $resource('/disciplinas/:id/aulas');
});
