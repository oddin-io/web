oddin.factory("PersonAPI", ["$http", function ($http) {
	var _index = function () {
		return $http.get('/api/person/');
	};
	var _show = function (id) {
		return $http.get('/api/person/' + id);
	};
	var _create = function (person) {
		return $http.post('/api/person/', person);
	};
	var _update = function (id, person) {
		return $http.put('/api/person/' + id, person);
	};
	var _destroy = function (id) {
		return $http.delete('/api/person/' + id);
	}

	return {
		index: _index,
		show: _show,
		create: _create,
		update: _update,
		destroy: _destroy
	}
}]);
