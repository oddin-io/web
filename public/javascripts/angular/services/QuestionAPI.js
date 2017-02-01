oddin.factory("QuestionAPI", ["$http", function ($http) {
	var _getAnswers = function (id) {
		return $http.get('/api/questions/' + id + '/answers');
	};
	var _createAnswer = function (id, answer) {
		return $http.post('/api/questions/' + id + '/answers', answer);
	};
	var _upvote = function (id) {
		return $http.post('/api/questions/' + id + '/upvote');
	};
	var _destroyVote = function (id) {
		return $http.delete('/api/questions/' + id + '/vote');
	};

	return {
		getAnswers : _getAnswers,
		createAnswer : _createAnswer,
		upvote : _upvote,
		destroyVote : _destroyVote
	}
}]);
