oddin.controller('SurveysController', function ($http, $scope, $stateParams, $state, $cookies, Disciplina, DisciplinaAula, DisciplinaMaterial, DisciplinaParticipante, Profile) {
	$scope.usuario = {
			'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
			'email': JSON.parse($cookies.get('session').substring(2)).person.email,
	}

	$scope.data_loaded = true;
	$scope.survey = {
		alternatives : [{}]
	}

	$scope.buscaEnquetes = function () {
		$http.get('/api/instructions/' + $stateParams.disciplinaID + '/surveys')
		.success(function (data) {
			$scope.surveys = data
		})
	};

	(function () {
			Disciplina.get({ id: $stateParams.disciplinaID },
					function (disciplina) {
							$scope.disciplina = disciplina
					},
					function (erro) {
							$scope.mensagem = { texto: 'Não foi possível obter o resultado.' }
					}
			)
	})();

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

	// $scope.createSurvey = function () {
	// 	console.log($scope.survey);
	// 	$scope.survey = {
	// 		choices : [{}]
	// 	}
	// }

	$scope.createSurvey = function () {
		$scope.data_loaded = false;
		$http.post('/api/instructions/' + $stateParams.disciplinaID + "/surveys", $scope.survey)
		.success(function (data) {
			$scope.surveys.push(data);
			$scope.survey = {
				choices : [{}]
			};
			$scope.data_loaded = true;
			Materialize.toast('Enquete criada com sucesso', 3000)
		})
	}

	$scope.updateSurvey = function (modalContent) {
		$scope.data_loaded = false;
		$http.put('/api/surveys/' + modalContent.id, modalContent)
		.success(function (data) {
			$scope.surveys.forEach( function (elem, i) {
				if(elem.id == data.id) {
					$scope.surveys[i] = data;
				}
			});
			$scope.data_loaded = true;
			Materialize.toast('Enquete atualizada com sucesso', 3000)
		})
	}

	$scope.deleteSurvey = function (modalContent) {
		$scope.data_loaded = false;
		$http.delete('/api/surveys/' + modalContent.id, modalContent)
		.success(function (data) {
			$scope.surveys.forEach( function (elem, i) {
				if(elem.id == data.id) {
					$scope.surveys.splice(i, 1);
				}
			});
			$scope.data_loaded = true;
			Materialize.toast('Enquete excluída com sucesso', 3000)
		})
	}

	$scope.closeSurvey = function (modalContent) {
		$scope.data_loaded = false;
		$http.post('/api/surveys/' + modalContent.id + '/close', modalContent)
		.success(function (data) {
			$scope.surveys.forEach( function (elem, i) {
				if(elem.id == data.id) {
					$scope.surveys[i] = data;
				}
			});
			$scope.data_loaded = true;
			Materialize.toast('Enquete encerrada com sucesso', 3000)
		})
	}

	$scope.makeChoice = function (survey) {
		if(!survey.choice) {
			Materialize.toast('Você deve selecionar uma alternativa antes de votar', 3000)
			return;
		}
		$scope.data_loaded = false
		$http.post('/api/alternatives/' + survey.choice + "/choose")
		.success(function (data) {
			$scope.surveys.forEach( function (elem, i) {
				if(elem.id == data.id) {
					$scope.surveys[i] = data;
				}
			});
			$scope.data_loaded = true;
			Materialize.toast('Voto realizado com sucesso', 3000)
		})
	}

	$scope.addNewAlternative = function () {
		// var newItemNo = $scope.choices.length+1;
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
