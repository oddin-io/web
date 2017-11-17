oddin.factory('TestResponseAPI', ['$http', 'env', function ($http, env) {
  var _create = function (testId, testResponse) {
    return $http.post(`${env.ws_url}/tests/${testId}/test_responses`, testResponse)
  }

  return {
    create: _create,
  }
}])