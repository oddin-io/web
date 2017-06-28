import oddin from '../app'

oddin.factory('EventAPI', ['$http', 'env', function ($http, env) {
  var _index = function () {
    return $http.get(`${env.ws_url}/events`)
  }
  var _show = function (id) {
    return $http.get(`${env.ws_url}/events/${id}`)
  }
  var _create = function (event) {
    return $http.post(`${env.ws_url}/events`, event)
  }
  var _update = function (id, event) {
    return $http.put(`${env.ws_url}/events/${id}`, event)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/events/${id}`)
  }
  var _getInstructions = function (id) {
    return $http.get(`${env.ws_url}/events/${id}/instructions`)
  }

  return {
    index: _index,
    show: _show,
    create: _create,
    update: _update,
    destroy: _destroy,
    getInstructions: _getInstructions,
  }
}])
