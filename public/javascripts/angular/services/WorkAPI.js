import oddin from '../app'

oddin.factory('WorkAPI', ['$http', 'env', function ($http, env) {
  var _show = function (id) {
    return $http.get(`${env.ws_url}/works/${id}`)
  }
  var _update = function (id, work) {
    return $http.put(`${env.ws_url}/works/${id}`, work)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/works/${id}`)
  }
  var _createMaterial = function (id) {
    return $http.post(`${env.ws_url}/works/${id}/materials`)
  }
  var _createSubmission = function (id, submission) {
    return $http.post(`${env.ws_url}/works/${id}/submissions`, submission)
  }
  var _getSubmissions = function (id) {
    return $http.get(`${env.ws_url}/works/${id}/submissions`)
  }

  return {
    show: _show,
    update: _update,
    destroy: _destroy,
    createMaterial: _createMaterial,
    createSubmission: _createSubmission,
    getSubmissions: _getSubmissions,
  }
}])
