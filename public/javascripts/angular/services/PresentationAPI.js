oddin.factory("PresentationAPI", function ($http) {
	var _close = function (id) {
		return $http.post('api/presentations/' + id + '/close');
	}

	return {
		close: _close
	}
})
