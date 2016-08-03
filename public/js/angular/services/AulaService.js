angular.module('oddin').factory('Aula', function($resource) {
  return $resource('/presentations/:id')
});
