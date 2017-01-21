oddin.factory("PresentationAPI", function ($http) {
	var _show = function (id) {
		return $http.get('/api/presentations/' + id);
	};
	var _close = function (id) {
		return $http.post('/api/presentations/' + id + '/close');
	};
	var _getMaterials = function (id) {
		return $http.get('/api/presentation/' + id + '/materials')
	};
	var _getQuestions = function (id) {
		return $http.get('/api/presentations/' + id + '/questions');
	};
	var _createMaterial = function (id) {
		return $http.post('/api/presentation/' + id + '/materials');
	};
	var _createQuestion = function (id, question) {
		return $http.post('/api/presentations/' + id + '/questions', question);
	};

	return {
		show: _show,
		close: _close,
		getMaterials: _getMaterials,
		getQuestions: _getQuestions,
		createMaterial: _createMaterial,
		createQuestion: _createQuestion
	}
});
