import oddin from '../app'

oddin.factory('PersonAPI', ['$http', 'env', function ($http, env) {
  var _index = function () {
    return $http.get(`${env.ws_url}/person`)
  }
  var _show = function (id) {
    return $http.get(`${env.ws_url}/person/${id}`)
  }
  var _create = function (person) {
    return $http.post(`${env.ws_url}/person`, person)
  }
  var _update = function (id, person) {
    return $http.put(`${env.ws_url}/person/${id}`, person)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/person/${id}`)
  }

  return {
    index: _index,
    show: _show,
    create: _create,
    update: _update,
    destroy: _destroy,
  }
}])
