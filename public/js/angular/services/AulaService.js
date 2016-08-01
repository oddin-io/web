angular.module('oddin').factory('Aula', function($resource) {
    return $resource('/disciplinas/:id/aulas')
});

