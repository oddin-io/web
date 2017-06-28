import oddin from '../app'

oddin.factory('DateAPI', ['$http', 'env', function ($http, env) {
  var _update = function (id, date) {
    return $http.put(`${env.ws_url}/dates/${id}`, date)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/dates/${id}`)
  }

  return {
    update: _update,
    destroy: _destroy,
  }
}])
