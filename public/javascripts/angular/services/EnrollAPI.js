oddin.factory('EnrollAPI', ['$http', function ($http) {
  var _create = function (enroll) {
    return $http.post('/api/enrolls/', enroll)
  }
  var _destroy = function (id) {
    return $http.delete('/api/enrolls/' + id)
  }

  return {
    create: _create,
    destroy: _destroy,
  }
}])
