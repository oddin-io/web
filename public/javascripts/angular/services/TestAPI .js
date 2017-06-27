oddin.factory('TestAPI', ['$http', 'env', function ($http, env) {
  var _update = function (id, test) {
    return $http.put(`${env.ws_url}/tests/${id}`, test)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/tests/${id}`)
  }
  var _close = function (id) {
    return $http.post(`${env.ws_url}/tests/${id}/close`)
  }

  return {
    update: _update,
    destroy: _destroy,
    close: _close,
  }
}])
