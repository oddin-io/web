oddin.factory('Resposta', function($resource) {
    return $resource('/api/answers/:id');
});
