oddin.controller('FAQsController', ["$scope", "$stateParams", "InstructionAPI", "FaqAPI", "CurrentUser",
function ($scope, $stateParams, InstructionAPI, FaqAPI, CurrentUser) {

	$scope.usuario = CurrentUser;
	$scope.data_loaded = true;

	(function () {
		InstructionAPI.show($stateParams.disciplinaID)
		.then(function (response) {
			$scope.disciplina = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	})();

	$scope.buscaFAQs = function () {
		InstructionAPI.getFAQs($stateParams.disciplinaID)
		.then(function (response) {
			$scope.faqs = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	};

	$scope.createFAQ = function (faq) {
		$scope.data_loaded = false;
		var _faq = angular.copy(faq);
		delete $scope.faq;
		InstructionAPI.createFAQ($stateParams.disciplinaID, _faq)
		.then(function (response) {
			$scope.faqs.push(response.data);
			$scope.data_loaded = true;
			Materialize.toast('FAQ postada com sucesso', 3000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.updateFAQ = function (faq) {
		$scope.data_loaded = false;
		var _faq = angular.copy(faq);
		delete $scope.modalContent;
		FaqAPI.update(_faq.id, _faq)
		.then(function (response) {
			for(var i = 0; i < $scope.faqs.length; i++) {
				if($scope.faqs[i].id == response.data.id) {
					$scope.faqs[i] = response.data;
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('FAQ atualizada com sucesso', 3000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.deleteFAQ = function (faq) {
		$scope.data_loaded = false;
		FaqAPI.destroy(faq.id)
		.then(function (response) {
			for(var i = 0; i < $scope.faqs.length; i++) {
				if($scope.faqs[i].id == response.data.id) {
					$scope.faqs.splice(i, 1);
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('FAQ excluída com sucesso', 3000);
		})
		.catch(function (error) {
			console.log(error.data);
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
}]);
