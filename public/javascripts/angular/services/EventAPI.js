oddin.factory("EventAPI", ["$http", function ($http) {
	var _index = function () {
		return $http.get('/api/events/');
	};
	var _show = function (id) {
		return $http.get('/api/events/' + id);
	};
	var _create = function (event) {
		return $http.post('/api/events/', event);
	};
	var _update = function (id, event) {
		return $http.put('/api/events/' + id, event);
	};
	var _destroy = function (id) {
		return $http.delete('/api/events/' + id);
	};
	var _getInstructions = function (id) {
		return $http.get('/api/events/' + id + '/instructions');
	};

	return {
		index: _index,
		show: _show,
		create: _create,
		update: _update,
		destroy: _destroy,
		getInstructions: _getInstructions
	}
}]);
