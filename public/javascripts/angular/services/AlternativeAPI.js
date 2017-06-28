import oddin from '../app'

oddin.factory('AlternativeAPI', ['$http', 'env', function ($http, env) {
  var _choose = function (id) {
    return $http.post(`${env.ws_url}/alternatives/${id}/choose`)
  }

  return {
    choose: _choose,
  }
}])
