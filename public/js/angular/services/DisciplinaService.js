angular.module('oddin').factory('Disciplina', function($resource) {
    return $resource('/disciplinas/:id');
});
