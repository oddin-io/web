oddin.controller('FAQsController', function ($http, $scope, $stateParams, $state, $cookies, Disciplina, DisciplinaAula, DisciplinaMaterial, DisciplinaParticipante, Profile) {
	$scope.usuario = {
			'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
			'email': JSON.parse($cookies.get('session').substring(2)).person.email,
	}
	$scope.data_loaded = true;

	$scope.faqs = [
		{
			id: 1,
			question: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel dapibus mauris. Maecenas tristique, dolor vel fringilla accumsan, ipsum tellus tempor massa, vel ornare lorem nulla ut quam. Sed at risus quis purus convallis aliquam at et leo. Aliquam ullamcorper, sapien facilisis dapibus maximus, dolor ante viverra risus, at hendrerit risus magna eu urna. Integer ullamcorper, nulla vel tempus gravida, urna sapien eleifend massa, a accumsan ex sem bibendum tortor. Nam fringilla metus in orci pulvinar, at tristique turpis tincidunt. Aliquam eu suscipit ante. Teste blah blah blah blah",
			answer: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel dapibus mauris. Maecenas tristique, dolor vel fringilla accumsan, ipsum tellus tempor massa, vel ornare lorem nulla ut quam. Sed at risus quis purus convallis aliquam at et leo. Aliquam ullamcorper, sapien facilisis dapibus maximus, dolor ante viverra risus, at hendrerit risus magna eu urna. Integer ullamcorper, nulla vel tempus gravida, urna sapien eleifend massa, a accumsan ex sem bibendum tortor. Nam fringilla metus in orci pulvinar, at tristique turpis tincidunt. Aliquam eu suscipit ante."
		},
		{
			id: 2,
			question: "Question 2",
			answer: "Answer 2"
		},
		{
			id: 3,
			question: "Question 3",
			answer: "Answer 3"
		},
		{
			id: 4,
			question: "Question 4",
			answer: "Answer 4"
		},
		{
			id: 5,
			question: "Question 5",
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

	$scope.displayAnswer = function (faq) {
		if($("#answer-" + faq.id).css("display") == "none")
			$("#answer-" + faq.id).css("display", "block");
		else {
			$("#answer-" + faq.id).css("display", "none");
		}
	}

	$scope.displayButton = function (faq) {
		if($("#answer-" + faq.id).css("display") == "none")
			return "Ver Resposta"
		else {
			return "Ocultar Resposta"
		}
	}

	$scope.openModalEditFAQ = function (faq) {
		$scope.modalContent = angular.copy(faq);
		$('#edit-faq').openModal();
	}

	$scope.openModalDeleteFAQ = function (faq) {
		$scope.modalContent = angular.copy(faq);
		$('#delete-faq').openModal();
	}
});
