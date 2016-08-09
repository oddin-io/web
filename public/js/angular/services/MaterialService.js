oddin.factory('Material', function($resource) {
  return $resource('/api/materials/:id')
});
