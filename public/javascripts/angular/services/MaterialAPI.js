import oddin from '../app'

oddin.factory('MaterialAPI', ['$http', 'env', function ($http, env) {
  var _show = function (id) {
    return $http.get(`${env.ws_url}/materials/${id}`)
  }
  var _update = function (id, material) {
    return $http.put(`${env.ws_url}/materials/${id}`, material)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/materials/${id}`)
  }

  return {
    show: _show,
    update: _update,
    destroy: _destroy,
  }
}])
