import oddin from '../app'

oddin.factory('PresentationAPI', ['$http', 'env', function ($http, env) {
  var _show = function (id) {
    return $http.get(`${env.ws_url}/presentations/${id}`)
  }
  var _close = function (id) {
    return $http.post(`${env.ws_url}/presentations/${id}/close`)
  }
  var _getMaterials = function (id) {
    return $http.get(`${env.ws_url}/presentations/${id}/materials`)
  }
  var _getQuestions = function (id) {
    return $http.get(`${env.ws_url}/presentations/${id}/questions`)
  }
  var _getRequests = function (id) {
    return $http.get(`${env.ws_url}/presentations/${id}/requests`)
  }
  var _createMaterial = function (id) {
    return $http.post(`${env.ws_url}/presentations/${id}/materials`)
  }
  var _createQuestion = function (id, question) {
    return $http.post(`${env.ws_url}/presentations/${id}/questions`, question)
  }
  var _createRequest = function (id) {
    return $http.post(`${env.ws_url}/presentations/${id}/requests`)
  }
  var _updateRequest = function (id) {
    return $http.put(`${env.ws_url}/requests/${id}`)
  }

  return {
    show: _show,
    close: _close,
    getMaterials: _getMaterials,
    getQuestions: _getQuestions,
    getRequests: _getRequests,
    createMaterial: _createMaterial,
    createQuestion: _createQuestion,
    createRequest: _createRequest,
    updateRequest: _updateRequest,
  }
}])
