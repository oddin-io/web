oddin.factory("TestAPI", ["$http", function ($http) {
	var _update = function (id, test) {
		return $http.put('/api/tests/' + id, test);
	};
	var _destroy = function (id) {
		return $http.delete('/api/tests/' + id);
	};
	var _close = function (id) {
		return $http.post('/api/tests/' + id + '/close');
	};

	return {
		update: _update,
		destroy: _destroy,
		close: _close
	}
}]);
