oddin.controller('AdminEventShowController', function ($scope, $stateParams, CurrentUser, InstructionAPI, EventAPI, LectureAPI, $filter) {
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

	$scope.buscaLectures = function () {
		LectureAPI.index()
		.then(function(response) {
			$scope.lectures = response.data;
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

	// $scope.buscaInstructions = function () {
	// 	EventAPI.getInstructions($stateParams.eventID)
	// 	.then(function(response) {
	// 		$scope.instructions = response.data;
	// 		setSeason($scope.instructions);
	// 	})
	// 	.catch(function(error) {
	// 		console.log(error.data);
	// 	})
	// }

	$scope.createInstruction = function (instruction) {
		$scope.data_loaded = false;
		var _instruction = angular.copy(instruction);
		delete $scope.modalContent;
		_instruction.event = $stateParams.eventID;
		_instruction.start_date = $filter('toDate')(_instruction.start_date);
		_instruction.end_date = $filter('toDate')(_instruction.end_date);
		InstructionAPI.create(_instruction)
		.then(function (response) {
			$scope.instructions.push(response.data);
			$scope.data_loaded = true;
			Materialize.toast('Disciplina Adicionada', 3000)
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.deleteInstruction = function (instruction) {
		$scope.data_loaded = false;
		InstructionAPI.destroy(instruction.id)
		.then(function (response) {
			for(var i = 0; i < $scope.instructions.length; i++) {
				if(instruction.id == $scope.instructions[i].id) {
					$scope.instructions.splice(i, 1);
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Disciplina removida', 3000)
		})
	}

	$scope.openModalAddLecture = function (lecture) {
		$scope.modalContent = {};
		$scope.modalContent.lecture = angular.copy(lecture.id);
		$('#modal-add-disciplina').openModal();
	}

	$scope.openModalDeleteInstruction = function (instruction) {
		$scope.modalContent = angular.copy(instruction);
		$('#modal-delete-instruction').openModal();
	}
});
