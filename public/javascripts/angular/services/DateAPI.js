oddin.factory('DateAPI', ['$http', function ($http) {
  var _update = function (id, date) {
    return $http.put('/api/dates/' + id, date)
  }
  var _destroy = function (id) {
    return $http.delete('/api/dates/' + id)
  }

  return {
    update: _update,
    destroy: _destroy,
  }
}])
