angular.module('oddin').factory('DisciplinaMaterial', function($resource) {
    return $resource('/api/instructions/:id/materials')
});
