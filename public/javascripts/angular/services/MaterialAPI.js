oddin.factory("MaterialAPI", ["$http", function ($http) {
	var _show = function (id) {
		return $http.get('/api/materials/' + id);
	}
	var _update = function (id, material) {
		return $http.put('/api/materials/' + id, material);
	};
	var _destroy = function (id) {
		return $http.delete('/api/materials/' + id);
	}

	return {
		show: _show,
		update: _update,
		destroy: _destroy
	}
}]);
