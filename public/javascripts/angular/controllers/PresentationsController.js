oddin.controller('PresentationsController', function ($scope, $stateParams, InstructionAPI, PresentationAPI, CurrentUser) {
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

	$scope.buscaAulas = function () {
		InstructionAPI.getPresentations($stateParams.disciplinaID)
		.then(function (response) {
			$scope.aulas = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.criaAula = function (presentation) {
		var _presentation = angular.copy(presentation);
		delete $scope.aula;
		$scope.data_loaded = false;
		InstructionAPI.createPresentation($stateParams.disciplinaID, _presentation)
		.then(function (response) {
			$scope.aulas.push(response.data);
			$scope.data_loaded = true;
			Materialize.toast('A aula ' + response.data.subject + ' foi criada', 4000);
		})
		.catch(function (error) {
			Materialize.toast('Não foi possível criar uma nova aula', 3000);
		})
	}

	$scope.fechaAula = function (aula) {
		$scope.data_loaded = false;
		var index = $scope.aulas.indexOf(aula);

		PresentationAPI.close(aula.id)
		.then(function (response) {
			$scope.aulas[index] = response.data;
			$scope.data_loaded = true;
			Materialize.toast('A aula ' + aula.subject + ' foi finalizada', 3000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.openModalCloseLecture = function (aula) {
		$scope.modalContent = aula;
			$('#modal-fecha-aula').openModal();
	}
	buscaInfo();
});
