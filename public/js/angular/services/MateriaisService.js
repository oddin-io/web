angular.module('oddin').factory('Materiais', function($resource) {
    return $resource('/disciplinas/:id/materiais')
})
