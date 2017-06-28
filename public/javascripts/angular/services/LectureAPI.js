import oddin from '../app'

oddin.factory('LectureAPI', ['$http', 'env', function ($http, env) {
  var _index = function () {
    return $http.get(`${env.ws_url}/lectures`)
  }
  var _show = function (id) {
    return $http.get(`${env.ws_url}/lectures/${id}`)
  }
  var _create = function (lecture) {
    return $http.post(`${env.ws_url}/lectures`, lecture)
  }
  var _update = function (id, lecture) {
    return $http.put(`${env.ws_url}/lectures/${id}`, lecture)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/lectures/${id}`)
  }

  return {
    index: _index,
    show: _show,
    create: _create,
    update: _update,
    destroy: _destroy,
  }
}])
