angular.module('oddin').factory('Disciplina', function($resource) {
  return $resource('/api/instructions/:id');
});
