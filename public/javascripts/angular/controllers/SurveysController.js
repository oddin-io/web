oddin.controller('SurveysController', function ($scope, $cookies, $stateParams, InstructionAPI, SurveyAPI, AlternativeAPI, CurrentUser) {

	(function () {
		InstructionAPI.show($stateParams.disciplinaID)
		.then(function (response) {
			$scope.disciplina = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	})();

	$scope.usuario = CurrentUser;
	$scope.data_loaded = true;
	$scope.survey = {
		alternatives : [{}]
	}

	$scope.buscaEnquetes = function () {
		InstructionAPI.getSurveys($stateParams.disciplinaID)
		.then(function (response) {
			$scope.surveys = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	};

	$scope.createSurvey = function (survey) {
		$scope.data_loaded = false;
		InstructionAPI.createSurvey($stateParams.disciplinaID, survey)
		.then(function (response) {
			$scope.surveys.push(response.data);
			$scope.survey = {
				alternatives : [{}]
			};
			$scope.data_loaded = true;
			Materialize.toast('Enquete criada com sucesso', 3000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.updateSurvey = function (survey) {
		$scope.data_loaded = false;
		var _survey = angular.copy(survey);
		delete $scope.modalContent;
		SurveyAPI.update(_survey.id, _survey)
		.then(function (response) {
			for(var i = 0; i < $scope.surveys.length; i++) {
				if($scope.surveys[i].id == _survey.id) {
					$scope.surveys[i] = response.data;
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Enquete atualizada com sucesso', 3000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.deleteSurvey = function (survey) {
		$scope.data_loaded = false;
		SurveyAPI.destroy(survey.id)
		.then(function () {
			for(var i = 0; i < $scope.surveys.length; i++) {
				if($scope.surveys[i].id == survey.id) {
					$scope.surveys.splice(i, 1);
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Enquete excluída com sucesso', 3000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.closeSurvey = function (survey) {
		$scope.data_loaded = false;
		SurveyAPI.close(survey.id)
		.then(function (response) {
			for(var i = 0; i < $scope.surveys.length; i++) {
				if($scope.surveys[i].id == survey.id) {
					$scope.surveys[i] = response.data;
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Enquete encerrada com sucesso', 3000)
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.makeChoice = function (survey) {
		if(!survey.choice) {
			Materialize.toast('Você deve selecionar uma alternativa antes de votar', 3000)
			return;
		}
		$scope.data_loaded = false;
		AlternativeAPI.choose(survey.choice)
		.then(function (response) {
			for(var i = 0; i < $scope.surveys.length; i++) {
				if($scope.surveys[i].id == survey.id) {
					$scope.surveys[i] = response.data;
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Voto realizado com sucesso', 3000)
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.displayAnswers = function (survey) {
		if($("#answers-" + survey.id).css("display") == "none")
			$("#answers-" + survey.id).css("display", "block");
		else {
			$("#answers-" + survey.id).css("display", "none");
		}
	}

	$scope.displayButton = function (survey) {
		if($("#answers-" + survey.id).css("display") == "none") {
			if($cookies.get('profile') == 0)
				return "Ver Alternativas"
			else {
				return "Ver Resultado"
			}
		}
		else {
			if($cookies.get('profile') == 0)
				return "Ocultar Alternativas"
			else {
				return "Ocultar Resultado"
			}
		}
	}

	$scope.addNewAlternative = function () {
		$scope.survey.alternatives.push({});
	}

	$scope.removeAlternative = function() {
		var lastItem = $scope.survey.alternatives.length-1;
		$scope.survey.alternatives.splice(lastItem);
	};

	$scope.openModalDeleteSurvey = function (survey) {
		$scope.modalContent = angular.copy(survey);
		$('#delete-enquete').openModal();
	}

	$scope.openModalCloseSurvey = function (survey) {
		$scope.modalContent = angular.copy(survey);
		$('#close-enquete').openModal();
	}

	$scope.openModalEditSurvey = function (survey) {
		$scope.modalContent = angular.copy(survey);
		$('#edit-enquete').openModal();
	}
});
