oddin.factory('LoginAPI', ['$http', 'env', function ($http, env) {
  var _login = function (user) {
    return $http.post(`${env.ws_url}/login`, user)
  }

  var _logout = function () {
    return $http.post(`${env.ws_url}/logout`)
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
