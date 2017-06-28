import oddin from '../app'

oddin.factory('SubmissionAPI', ['$http', 'env', function ($http, env) {
  var _show = function (id) {
    return $http.get(`${env.ws_url}/submissions/${id}`)
  }
  var _update = function (id, submission) {
    return $http.put(`${env.ws_url}/submissions/${id}`, submission)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/submissions/${id}`)
  }
  var _createMaterial = function (id) {
    return $http.post(`${env.ws_url}/submissions/${id}/materials`)
  }

  return {
    show: _show,
    update: _update,
    destroy: _destroy,
    createMaterial: _createMaterial,
  }
}])
