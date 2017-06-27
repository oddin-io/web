oddin.factory('PresentationAPI', ['$http', 'env', function ($http, env) {
  var _show = function (id) {
    return $http.get(`${env.ws_url}/presentations/${id}`)
  }
  var _close = function (id) {
    return $http.post(`${env.ws_url}/presentations/${id}/close`)
  }
  var _getMaterials = function (id) {
    return $http.get(`${env.ws_url}/presentation/${id}/materials`)
  }
  var _getQuestions = function (id) {
    return $http.get(`${env.ws_url}/presentations/${id}/questions`)
  }
  var _createMaterial = function (id) {
    return $http.post(`${env.ws_url}/presentation/${id}/materials`)
  }
  var _createQuestion = function (id, question) {
    return $http.post(`${env.ws_url}/presentations/${id}/questions`, question)
  }

  return {
    show: _show,
    close: _close,
    getMaterials: _getMaterials,
    getQuestions: _getQuestions,
    createMaterial: _createMaterial,
    createQuestion: _createQuestion,
  }
}])
