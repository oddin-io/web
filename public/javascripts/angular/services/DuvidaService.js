oddin.factory('Duvida', function($resource) {
  return $resource('/api/presentations/:id/questions');
});
