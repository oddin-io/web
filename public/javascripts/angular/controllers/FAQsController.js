oddin.controller('FAQsController', function ($http, $scope, $stateParams, $state, $cookies, Disciplina, DisciplinaAula, DisciplinaMaterial, DisciplinaParticipante, Profile) {
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

	$scope.usuario = {
			'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
			'email': JSON.parse($cookies.get('session').substring(2)).person.email,
	}
	$scope.data_loaded = true;

	$scope.buscaFAQs = function () {
		$http.get('/api/instructions/' + $stateParams.disciplinaID + '/faqs')
		.success(function (data) {
			$scope.faqs = data
		})
	};

	$scope.createFAQ = function () {
		$scope.data_loaded = false;
		$http.post('/api/instructions/' + $stateParams.disciplinaID + "/faqs", $scope.faq)
		.success(function (data) {
			$scope.faqs.push(data);
			$scope.faq = null;
			$scope.data_loaded = true;
			Materialize.toast('FAQ postada com sucesso', 3000);
		});
	}

	$scope.updateFAQ = function (modalContent) {
		$scope.data_loaded = false;
		$http.put('/api/faqs/' + modalContent.id, modalContent)
		.success(function (data) {
			$scope.faqs.forEach( function (elem, i) {
				if(elem.id == data.id) {
					$scope.faqs[i] = data;
				}
			});
			$scope.data_loaded = true;
			Materialize.toast('FAQ atualizada com sucesso', 3000)
		})
	}

	$scope.deleteFAQ = function (modalContent) {
		$scope.data_loaded = false;
		$http.delete('/api/faqs/' + modalContent.id)
		.success(function (data) {
			$scope.faqs.forEach( function (elem, i) {
				if(elem.id == data.id) {
					$scope.faqs.splice(i, 1);
				}
			});
			$scope.data_loaded = true;
			Materialize.toast('FAQ excluída com sucesso', 3000)
		})
	}

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
