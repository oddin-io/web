import oddin from '../app'

oddin.factory('TestAPI', ['$http', 'env', function ($http, env) {
  var _update = function (id, test) {
    return $http.put(`${env.ws_url}/tests/${id}`, test)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/tests/${id}`)
  }
  var _getQuestions = function (id) {
    return $http.get(`${env.ws_url}/tests/${id}/test_questions`)
  }
  var _show = function (id) {
    return $http.get(`${env.ws_url}/tests/${id}`)
  }

  return {
    update: _update,
    destroy: _destroy,
    getQuestions: _getQuestions,
    show: _show,
  }
}])
