angular.module('oddin').factory('DisciplinaParticipante', function($resource) {
    return $resource('/api/instructions/:id/participants')
});

