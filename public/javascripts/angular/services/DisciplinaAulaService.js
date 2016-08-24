oddin.factory('DisciplinaAula', function($resource) {
    return $resource('/api/instructions/:id/presentations')
});
