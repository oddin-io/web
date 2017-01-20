oddin.factory("WorkAPI", function ($http) {
	var _show = function (id) {
		return $http.get('/api/works/' + id);
	};
	var _update = function (id, work) {
		return $http.put('/api/works/' + id, work);
	};
	var _destroy = function (id) {
		return $http.delete('/api/works/' + id);
	};
	var _createMaterial = function (id) {
		return $http.post('/api/works/' + id + '/materials');
	};
	var _createSubmission = function (id, submission) {
		return $http.post('/api/works/' + id + '/submissions', submission);
	};
	var _getSubmissions = function (id) {
		return $http.get('/api/works/' + id + '/submissions');
	};

	return {
		show: _show,
		update: _update,
		destroy: _destroy,
		createMaterial: _createMaterial,
		createSubmission: _createSubmission,
		getSubmissions: _getSubmissions
	}
});
