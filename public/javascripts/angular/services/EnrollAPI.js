import oddin from '../app'

oddin.factory('EnrollAPI', ['$http', 'env', function ($http, env) {
  var _create = function (enroll) {
    return $http.post(`${env.ws_url}/enrolls`, enroll)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/enrolls/${id}`)
  }

  return {
    create: _create,
    destroy: _destroy,
  }
}])
