angular.module('oddin').factory('Duvida', function($resource) {
  return $resource('/questions/:id');
});
