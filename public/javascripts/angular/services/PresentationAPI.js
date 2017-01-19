oddin.factory("PresentationAPI", function ($http) {
	var _show = function (id) {
		return $http.get('api/presentations/' + id);
	};
	var _close = function (id) {
		return $http.post('api/presentations/' + id + '/close');
	};
	var _getQuestions = function (id) {
		return $http.get('api/presentations/' + id + '/questions');
	};
	var _createQuestion = function (id, question) {
		return $http.post('api/presentations/' + id + '/questions', question);
	};

	return {
		show: _show,
		close: _close,
		getQuestions: _getQuestions,
		createQuestion: _createQuestion
	}
});
