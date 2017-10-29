import oddin from '../app'

oddin.factory('TestQuestionAPI', ['$http', 'env', function ($http, env) {
  var _create = function (id, testQuestion) {
    return $http.post(`${env.ws_url}/tests/${id}/test_questions`, testQuestion)
  }
  var _update = function (id, testQuestion) {
    return $http.put(`${env.ws_url}/test_questions/${id}`, testQuestion)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/test_questions/${id}`)
  }

  return {
    create: _create,
    update: _update,
    destroy: _destroy,
  }
}])