oddin.factory("AnswerAPI", ["$http", function ($http) {
	var _upvote = function (id) {
		return $http.post('/api/answers/' + id + '/upvote');
	};
	var _downvote = function (id) {
		return $http.post('/api/answers/' + id + '/downvote');
	};
	var _destroyVote = function (id) {
		return $http.delete('/api/answers/' + id + '/vote');
	};
	var _accept = function (id) {
		return $http.post('/api/answers/' + id + '/accept');
	}
	var _reject = function (id) {
		return $http.delete('/api/answers/' + id + '/accept');
	}

	return {
		upvote : _upvote,
		downvote : _downvote,
		destroyVote : _destroyVote,
		accept : _accept,
		reject : _reject
	}
}]);
