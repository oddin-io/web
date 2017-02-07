oddin.factory("LectureAPI", ["$http", function ($http) {
	var _index = function () {
		return $http.get('/api/lectures/');
	};
	var _show = function (id) {
		return $http.get('/api/lectures/' + id);
	};
	var _create = function (lecture) {
		return $http.post('/api/lectures/', lecture);
	};
	var _update = function (id, lecture) {
		return $http.put('/api/lectures/' + id, lecture);
	};
	var _destroy = function (id) {
		return $http.delete('/api/lectures/' + id);
	}

	return {
		index: _index,
		show: _show,
		create: _create,
		update: _update,
		destroy: _destroy
	}
}]);
