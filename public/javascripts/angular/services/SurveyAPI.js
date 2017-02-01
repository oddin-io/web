oddin.factory("SurveyAPI", ["$http", function ($http) {
	var _update = function (id, survey) {
		return $http.put('/api/surveys/' + id, survey);
	};
	var _destroy = function (id) {
		return $http.delete('/api/surveys/' + id);
	};
	var _close = function (id) {
		return $http.post('/api/surveys/' + id + '/close');
	};

	return {
		update: _update,
		destroy: _destroy,
		close: _close
	}
}]);
