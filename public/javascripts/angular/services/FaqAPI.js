import oddin from '../app'

oddin.factory('FaqAPI', ['$http', 'env', function ($http, env) {
  var _update = function (id, faq) {
    return $http.put(`${env.ws_url}/faqs/${id}`, faq)
  }
  var _destroy = function (id) {
    return $http.delete(`${env.ws_url}/faqs/${id}`)
  }

  return {
    update: _update,
    destroy: _destroy,
  }
}])
