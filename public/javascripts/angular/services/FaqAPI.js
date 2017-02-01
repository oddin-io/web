oddin.factory("FaqAPI", ["$http", function ($http) {
	var _update = function (id, faq) {
		return $http.put('/api/faqs/' + id, faq);
	};
	var _destroy = function (id) {
		return $http.delete('/api/faqs/' + id);
	};

	return {
		update: _update,
		destroy: _destroy
	}
}]);
