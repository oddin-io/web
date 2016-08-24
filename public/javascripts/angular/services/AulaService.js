oddin.factory('Aula', function($resource) {
  return $resource('/api/presentations/:id')
});
