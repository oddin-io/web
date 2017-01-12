oddin.controller('SurveysController', function ($http, $scope, $stateParams, $state, $cookies, Disciplina, DisciplinaAula, DisciplinaMaterial, DisciplinaParticipante, Profile) {
	$scope.usuario = {
			'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
			'email': JSON.parse($cookies.get('session').substring(2)).person.email,
	}
	$scope.data_loaded = true;
	$scope.survey = {
		choices : [{}]
	}
	$scope.surveys = [
		{
			id: 1, //criado no backend
			title: "Enquete 1",
			question: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel dapibus mauris. Maecenas tristique, dolor vel fringilla accumsan, ipsum tellus tempor massa, vel ornare lorem nulla ut quam. Sed at risus quis purus convallis aliquam at et leo. Aliquam ullamcorper, sapien facilisis dapibus maximus, dolor ante viverra risus, at hendrerit risus magna eu urna. Integer ullamcorper, nulla vel tempus gravida, urna sapien eleifend massa, a accumsan ex sem bibendum tortor. Nam fringilla metus in orci pulvinar, at tristique turpis tincidunt. Aliquam eu suscipit ante. Teste blah blah blah blah",
			created_at: "12/12/2012", //criado no backend
			choices: [
				{
					id: 1, //criado no backend
					voteCount: 10, //criado no backend
					text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
				},
				{
					id: 2,
					voteCount: 8,
					text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
				},
			]
		},
		{
			id: 2,
			title: "Enquete 2",
			question: "Question 2",
			choices: "Answer 2"
		},
		{
			id: 3,
			title: "Enquete 3",
			question: "Question 3",
			choices: "Answer 3"
		},
		{
			id: 4,
			title: "Enquete 4",
			question: "Question 4",
			choices: "Answer 4"
		},
		{
			id: 5,
			title: "Enquete 5",
			description: "Question 5",
			choices: "Answer 5"
		}
	];

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

	$scope.createSurvey = function () {
		console.log($scope.survey);
		$scope.survey = {
			choices : [{}]
		}
	}

	$scope.addNewChoice = function () {
		// var newItemNo = $scope.choices.length+1;
		$scope.survey.choices.push({});
	}

	$scope.removeChoice = function() {
	 var lastItem = $scope.survey.choices.length-1;
	 $scope.survey.choices.splice(lastItem);
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
