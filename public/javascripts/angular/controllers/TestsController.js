oddin.controller("TestsController", ["$scope", "$stateParams", "InstructionAPI", "CurrentUser", 
function ($scope,  $stateParams, InstructionAPI,CurrentUser, ) {
	$scope.user = CurrentUser;
	$scope.newTest = { questions:[], alternatives:[] };

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

	$scope.addNewAlternative = function (newTest) {
		newTest.alternatives.push({});
	}

	$scope.removeAlternative = function(newTest) {
		var lastItem = newTest.alternatives.length-1;
		newTest.alternatives.splice(lastItem);
	}

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
