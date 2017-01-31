oddin.controller('AdminEventShowController', function ($scope, $stateParams, CurrentUser, InstructionAPI, EventAPI, LectureAPI, $filter, ManageList) {
	$scope.user = CurrentUser;
	$scope.data_loaded = true;

	function setSeason(instructions) {
		instructions.forEach(function(instruction) {
			var _year = $filter('date')(instruction.start_date, 'yyyy');
			var _semester = $filter('date')(instruction.start_date, 'MM') < 7 ? 1 : 2;
			var _season = _year + "/" + _semester;
			instruction.season = _season;
		})
	}

	(function getInfo() {
		$scope.load = false;
		EventAPI.show($stateParams.eventID)
		.then(function (response) {
			$scope.event = response.data;
		})
		.catch(function () {
			Materialize.toast("Erro ao carregar informações do curso", 3000);
		})
		.finally(function () {
			$scope.load = true;
		})
	})();

	(function findInstructions() {
		$scope.load = false;
		InstructionAPI.index()
		.then(function (response) {
			$scope.instructions = response.data;
			setSeason($scope.instructions);
		})
		.catch(function () {
			Materialize.toast("Erro ao carregar disciplinas cadastradas", 3000);
		})
		.finally(function () {
			$scope.load = true;
		})
	})();

	$scope.findLectures = function () {
		$scope.load = false;
		LectureAPI.index()
		.then(function(response) {
			$scope.lectures = response.data;
		})
		.catch(function(error) {
			Materialize.toast("Erro ao carregar disciplinas disponíveis", 3000);
		})
		.finally(function () {
			$scope.load = true;
		})
	}

	// $scope.createInstruction = function (instruction) {
	// 	$scope.data_loaded = false;
	// 	var _instruction = angular.copy(instruction);
	// 	delete $scope.modalContent;
	// 	_instruction.event = $stateParams.eventID;
	// 	_instruction.start_date = $filter('toDate')(_instruction.start_date);
	// 	_instruction.end_date = $filter('toDate')(_instruction.end_date);
	// 	InstructionAPI.create(_instruction)
	// 	.then(function (response) {
	// 		$scope.instructions.push(response.data);
	// 		$scope.data_loaded = true;
	// 		Materialize.toast('Disciplina Adicionada', 3000)
	// 	})
	// 	.catch(function (error) {
	// 		console.log(error.data);
	// 	})
	// }

	$scope.deleteInstruction = function (modalInstruction) {
		$scope.load = false;
		InstructionAPI.destroy(modalInstruction.id)
		.then(function (response) {
			ManageList.deleteItem($scope.instructions, modalInstruction);
			Materialize.toast("Disciplina removida", 3000);
		})
		.catch(function () {
			Materialize.toast("Erro ao remover disciplina", 3000);
		})
		.finally(function () {
			$scope.load = true;
		})
	}

	$scope.modalAdd = function (lecture) {
		$scope.modalInstruction = {};
		$scope.modalInstruction.lecture = angular.copy(lecture);

		$('#modal-add').openModal();
	}

	$scope.modalRemove = function (instruction) {
		$scope.modalInstruction = angular.copy(instruction);
		$("#modal-remove").openModal();
	}
});
