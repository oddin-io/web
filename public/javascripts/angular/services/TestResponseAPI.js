import oddin from '../app'

oddin.factory('TestResponseAPI', ['$http', 'env', function ($http, env) {
  var _create = function (testId, testResponse) {
    return $http.post(`${env.ws_url}/tests/${testId}/test_responses`, testResponse)
  }

  var _show = function(testId)  {
  	return $http.get(`${env.ws_url}/tests/${testId}}/test_responses`)
  }

  return {
    create: _create,
    show: _show,
  }
}])