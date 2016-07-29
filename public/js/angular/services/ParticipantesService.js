angular.module('oddin').factory('Participantes', function($resource) {
    return $resource('/disciplinas/:id/participantes')
})

