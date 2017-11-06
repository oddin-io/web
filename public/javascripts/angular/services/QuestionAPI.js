import oddin from '../app'

oddin.factory('QuestionAPI', ['$http', 'env', function ($http, env) {
  var _getAnswers = function (id) {
    return $http.get(`${env.ws_url}/questions/${id}/answers`)
  }
  var _createAnswer = function (id, answer) {
    return $http.post(`${env.ws_url}/questions/${id}/answers`, answer)
  }
  var _upvote = function (id) {
    return $http.post(`${env.ws_url}/questions/${id}/upvote`)
  }
  var _destroyVote = function (id) {
    return $http.delete(`${env.ws_url}/questions/${id}/vote`)
  }
  var _getMaterials = function (id) {
    return $http.get(`${env.ws_url}/questions/${id}/materials`)
  }

  return {
    getAnswers: _getAnswers,
    createAnswer: _createAnswer,
    upvote: _upvote,
    destroyVote: _destroyVote,
    getMaterials: _getMaterials,
  }
}])
