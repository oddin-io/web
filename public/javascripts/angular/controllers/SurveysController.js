oddin.controller('SurveysController', function ($http, $scope, $stateParams, $state, $cookies, Disciplina, DisciplinaAula, DisciplinaMaterial, DisciplinaParticipante, Profile) {
	$scope.usuario = {
			'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
			'email': JSON.parse($cookies.get('session').substring(2)).person.email,
	}
	$scope.data_loaded = true;

	$scope.surveys = [
		{
			id: 1,
			title: "Enquete 1",
			description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel dapibus mauris. Maecenas tristique, dolor vel fringilla accumsan, ipsum tellus tempor massa, vel ornare lorem nulla ut quam. Sed at risus quis purus convallis aliquam at et leo. Aliquam ullamcorper, sapien facilisis dapibus maximus, dolor ante viverra risus, at hendrerit risus magna eu urna. Integer ullamcorper, nulla vel tempus gravida, urna sapien eleifend massa, a accumsan ex sem bibendum tortor. Nam fringilla metus in orci pulvinar, at tristique turpis tincidunt. Aliquam eu suscipit ante. Teste blah blah blah blah",
			created_at: "12/12/2012",
			answers: [
				{
					id: 1,
					alternative: "a",
					voteCount: 10,
					text: "Lorem Ipsum",
				},
				{
					id: 2,
					alternative: "b",
					voteCount: 8,
					text: "Sit Dolor",
				},
			]
		},
		{
			id: 2,
			title: "Enquete 2",
			description: "Question 2",
			answer: "Answer 2"
		},
		{
			id: 3,
			title: "Enquete 3",
			description: "Question 3",
			answer: "Answer 3"
		},
		{
			id: 4,
			title: "Enquete 4",
			description: "Question 4",
			answer: "Answer 4"
		},
		{
			id: 5,
			title: "Enquete 5",
			description: "Question 5",
			answer: "Answer 5"
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
		if($("#answers-" + survey.id).css("display") == "none")
			return "Ver Respostas"
		else {
			return "Ocultar Respostas"
		}
	}
});
