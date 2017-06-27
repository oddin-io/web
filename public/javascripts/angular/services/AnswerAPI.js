oddin.factory('AnswerAPI', ['$http', 'env', function ($http, env) {
  var _upvote = function (id) {
    return $http.post(`${env.ws_url}/answers/${id}/upvote`)
  }
  var _downvote = function (id) {
    return $http.post(`${env.ws_url}/answers/${id}/downvote`)
  }
  var _destroyVote = function (id) {
    return $http.delete(`${env.ws_url}/answers/${id}/vote`)
  }
  var _accept = function (id) {
    return $http.post(`${env.ws_url}/answers/${id}/accept`)
  }
  var _reject = function (id) {
    return $http.delete(`${env.ws_url}/answers/${id}/accept`)
  }

  return {
    upvote: _upvote,
    downvote: _downvote,
    destroyVote: _destroyVote,
    accept: _accept,
    reject: _reject,
  }
}])
