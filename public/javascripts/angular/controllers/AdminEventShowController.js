oddin.controller('AdminEventShowController', function ($scope, $stateParams, CurrentUser, InstructionAPI, EventAPI, LectureAPI, $filter) {

	$scope.usuario = CurrentUser;
	$scope.data_loaded = true;

	$scope.buscaInfo = function () {
		EventAPI.show($stateParams.cursoID)
		.then(function(response) {
			$scope.curso = response.data;
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

	$scope.buscaLectures = function () {
		LectureAPI.index()
		.then(function(response) {
			$scope.lectures = response.data;
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

	$scope.buscaInstructions = function () {
		EventAPI.getInstructions($stateParams.cursoID)
		.then(function(response) {
			$scope.instructions = response.data;
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

	$scope.createInstruction = function (instruction) {
		$scope.data_loaded = false;
		var _instruction = angular.copy(instruction);
		delete $scope.modalContent;
		_instruction.event = $stateParams.cursoID;
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
