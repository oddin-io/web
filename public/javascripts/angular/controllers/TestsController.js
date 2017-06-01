oddin.controller("TestsController", ["$scope", "$cookies", "$stateParams", "InstructionAPI", "TestAPI", "AlternativeAPI", "CurrentUser", "ManageList",
function ($scope, $cookies, $stateParams, InstructionAPI, TestAPI, AlternativeAPI, CurrentUser, ManageList) {
	$scope.user = CurrentUser;
	/*$scope.newTest = {alternatives:[{}]};

	(function getInfo() {
		$scope.load = false;
		InstructionAPI.show($stateParams.instructionID)
		.then(function (response) {
			$scope.instruction = response.data;
		})
		.catch(function () {
			Materialize.toast("Erro ao carregar informações da disciplina", 3000);
		})
		.finally(function () {
			$scope.load = true;
		})
	})();

	(function findTests() {
		$scope.load = false;
		InstructionAPI.getTests($stateParams.instructionID)
		.then(function (response) {
			$scope.tests = response.data;
		})
		.catch(function () {
			Materialize.toast("Erro ao carregar Testes", 3000);
		})
		.finally(function () {
			$scope.load = true;
		})
	})();

	$scope.createTest = function (newTest) {
		$scope.load = false;
		InstructionAPI.createTest($stateParams.instructionID, newTest)
		.then(function (response) {
			$scope.tests.push(response.data);
			Materialize.toast("Teste criado", 3000);
		})
		.catch(function (error) {
			Materialize.toast("Não foi possível criar o teste", 3000);
		})
		.finally(function () {
			$scope.newTest = {alternatives: [{}]};
			$scope.load = true;
		})
	}

	$scope.updateTest = function (modalTest) {
		$scope.load = false;
		StestAPI.update(modalTest.id, modalTest)
		.then(function (response) {
			ManageList.updateItem($scope.tests, response.data);
			Materialize.toast("Teste atualizado", 3000);
		})
		.catch(function () {
			Materialize.toast("Erro ao atualizar Teste", 3000);
		})
		.finally(function () {
			$scope.load = true;
		})
	}

	$scope.deleteTest = function (modalTest) {
		$scope.load = false;
		StestAPI.destroy(modalTest.id)
		.then(function (response) {
			ManageList.deleteItem($scope.tests, modalTest);
			Materialize.toast("Teste deletado", 3000);
		})
		.catch(function () {
			Materialize.toast("Erro ao excluir teste", 3000);
		})
		.finally(function () {
			$scope.load = true;
		})
	}

	$scope.closeTest = function (modalTest) {
		$scope.load = false;
		StestAPI.close(modalTest.id)
		.then(function (response) {
			ManageList.updateItem($scope.tests, response.data);
			Materialize.toast("Teste encerrado", 3000);
		})
		.catch(function () {
			Materialize.toast("Erro ao encerrar teste", 3000);
		})
		.finally(function () {
			$scope.load = true;
		})
	}

	$scope.makeChoice = function (test) {
		if(!test.choice) {
			Materialize.toast("Você deve selecionar uma alternativa antes de votar", 3000)
			return;
		}
		$scope.load = false;
		AlternativeAPI.choose(survey.choice)
		.then(function (response) {
			ManageList.updateItem($scope.surveys, response.data);
			Materialize.toast("Voto realizado com sucesso", 3000)
		})
		.catch(function () {
			Materialize.toast("Erro ao votar", 3000);
		})
		.finally(function () {
			$scope.load = true;
		})
	}

	$scope.addNewAlternative = function (newTest) {
		newTest.alternatives.push({});
	}

	$scope.removeAlternative = function(newTest) {
		var lastItem = newTest.alternatives.length-1;
		newTest.alternatives.splice(lastItem);
	};

	$scope.displayAnswers = function (test) {
		if($("#answers-" + test.id).css("display") == "none")
			$("#answers-" + test.id).css("display", "block");
		else {
			$("#answers-" + test.id).css("display", "none");
		}
	}

	$scope.displayAlternativesButton = function (test) {
		if($("#answers-" + test.id).css("display") == "none") {
			if($cookies.get("profile") == 0)
				return "Ver Alternativas"
			else {
				return "Ver Resultado"
			}
		}
		else {
			if($cookies.get("profile") == 0)
				return "Ocultar Alternativas"
			else {
				return "Ocultar Resultado"
			}
		}
	}*/

	$scope.modalEdit = function (test) {
		$scope.modalTest = angular.copy(test);
		$("#modal-edit").openModal();
	}

	$scope.modalDelete = function (test) {
		$scope.modalTest = angular.copy(test);
		$("#modal-delete").openModal();
	}

	$scope.modalClose = function (test) {
		$scope.modalTest = angular.copy(test);
		$("#modal-close").openModal();
	}
}]);
