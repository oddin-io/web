angular.module('oddin').factory('Participante', function($resource) {
    return $resource('/disciplinas/:id/participantes')
})

