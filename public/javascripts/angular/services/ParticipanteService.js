oddin.factory('Participante', function($resource) {
  return $resource('/api/participants/:id')
});
