import oddin from '../app'

oddin.factory('LoginAPI', ['$http', 'env', function ($http, env) {
  var _login = function (user) {
    return $http.post(`${env.ws_url}/session`, user)
  }

  var _logout = function () {
    return $http.delete(`${env.ws_url}/session`)
  }

  var _recoverPassword = function (user) {
    return $http.post(`${env.ws_url}/recover-password`, user)
  }

  var _redefinePassword = function (user) {
    return $http.post(`${env.ws_url}/redefine-password`, user)
  }

  return {
    login: _login,
    logout: _logout,
    recoverPassword: _recoverPassword,
    redefinePassword: _redefinePassword,
  }
}])
