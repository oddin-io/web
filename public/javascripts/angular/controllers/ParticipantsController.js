oddin.controller('ParticipantsController', ["$scope", "$stateParams", "InstructionAPI", "CurrentUser",
function ($scope, $stateParams, InstructionAPI, CurrentUser) {

	$scope.usuario = CurrentUser;
	$scope.data_loaded = true;

	function buscaInfo() {
		InstructionAPI.show($stateParams.disciplinaID)
		.then(function (response) {
			$scope.disciplina = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.buscaParticipantes = function () {
		InstructionAPI.getParticipants($stateParams.disciplinaID)
		.then(function (response) {
			$scope.participantes = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}
	buscaInfo();
}]);
