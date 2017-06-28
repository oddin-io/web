import oddin from '../app'

oddin.factory('SurveyAPI', ['$http', 'env', function ($http, env) {
  var _update = function (id, survey) {
    return $http.put(`${env.ws_url}/surveys/${id}`, survey)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/surveys/${id}`)
  }
  var _close = function (id) {
    return $http.post(`${env.ws_url}/surveys/${id}/close`)
  }

  return {
    update: _update,
    destroy: _destroy,
    close: _close,
  }
}])
