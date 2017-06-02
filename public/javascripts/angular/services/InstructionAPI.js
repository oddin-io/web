oddin.factory("InstructionAPI", ["$http", function ($http) {
	var _index = function () {
		return $http.get('/api/instructions/');
	};
	var _show = function (id) {
		return $http.get('/api/instructions/' + id);
	};
	var _create = function (instruction) {
		return $http.post('api/instructions', instruction);
	};
	var _destroy = function (id) {
		return $http.delete('api/instructions/' + id);
	};
	var _getProfile = function (id) {
		return $http.get('/api/instructions/' + id + '/profile');
	};
	var _getPresentations = function (id) {
		return $http.get('/api/instructions/' + id + '/presentations');
	};
	var _getNotices = function (id) {
		return $http.get('/api/instructions/' + id + '/notices');
	};
	var _getDates = function (id) {
		return $http.get('/api/instructions/' + id + '/dates');
	};
	var _getWorks = function (id) {
		return $http.get('/api/instructions/' + id + '/works');
	}
	var _getMaterials = function (id) {
		return $http.get('/api/instructions/' + id + '/materials');
	};
	var _getParticipants = function (id) {
		return $http.get('/api/instructions/' + id + '/participants');
	};
	var _getFAQs = function (id) {
		return $http.get('/api/instructions/' + id + '/faqs');
	};
	var _getSurveys = function (id) {
		return $http.get('/api/instructions/' + id + '/surveys');
	};
	var _getTests = function (id) {
		return $http.get('/api/instructions/' + id + '/tests');
	};
	var _createPresentation = function (id, presentation) {
		return $http.post('/api/instructions/' + id + '/presentations', presentation);
	};
	var _createNotice = function (id, notice) {
		return $http.post('/api/instructions/' + id + '/notices', notice);
	};
	var _createDate = function (id, date) {
		return $http.post('/api/instructions/' + id + '/dates', date);
	};
	var _createWork = function (id, work) {
		return $http.post('/api/instructions/' + id + "/works", work);
	};
	var _createMaterial = function (id) {
		return $http.post('/api/instructions/' + id + '/materials');
	};
	var _createFAQ = function (id, faq) {
		return $http.post('/api/instructions/' + id + '/faqs', faq);
	};
	var _createSurvey = function (id, survey) {
		return $http.post('/api/instructions/' + id + '/surveys', survey);
	};
	var _createTest = function (id, test) {
		return $http.post('/api/instructions/' + id + '/tests', test);
	};

	return {
		index: _index,
		show: _show,
		create: _create,
		destroy: _destroy,
		getProfile: _getProfile,
		getPresentations: _getPresentations,
		getNotices: _getNotices,
		getDates: _getDates,
		getWorks: _getWorks,
		getMaterials: _getMaterials,
		getParticipants: _getParticipants,
		getFAQs: _getFAQs,
		getSurveys: _getSurveys,
		getTests: _getTests,
		createPresentation: _createPresentation,
		createNotice: _createNotice,
		createDate: _createDate,
		createWork: _createWork,
		createMaterial: _createMaterial,
		createFAQ: _createFAQ,
		createSurvey: _createSurvey,
		createTest: _createTest
	}
}]);
