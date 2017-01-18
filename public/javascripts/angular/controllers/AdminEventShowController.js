oddin.controller('AdminEventShowController', function ($http, $scope, $stateParams, $cookies, InstructionAPI) {

  $scope.usuario = {
    'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
    'email': JSON.parse($cookies.get('session').substring(2)).person.email,
  }

  $scope.data_loaded = true;

  $scope.buscaInfo = function () {
    $http.get('api/events/' + $stateParams.cursoID)
    .success(function (data) {
      $scope.curso = data;
    });
  }

	$scope.buscaLectures = function () {
		$http.get('/api/lectures')
		.success(function (data) {
			$scope.lectures = data;
		})
	}

	$scope.buscaInstructions = function () {
		$http.get('api/events/' + $stateParams.cursoID + '/instructions')
		.success(function (data) {
			$scope.instructions = data;
		})
	}

	$scope.openModalAddLecture = function (lecture) {
		$scope.modalContent = angular.copy(lecture);
		$('#modal-add-disciplina').openModal();
	}

	$scope.openModalDeleteInstruction = function (instruction) {
		$scope.modalContent = angular.copy(instruction);
		$('#modal-delete-instruction').openModal();
	}

	$scope.createInstruction = function () {
    $scope.data_loaded = false;
		var startDate = {
			year: parseInt($scope.modalContent.start_date.substring(4, 8)),
			month: parseInt($scope.modalContent.start_date.substring(2, 4)) - 1,
			day: parseInt($scope.modalContent.start_date.substring(0, 2))
		};

		var endDate = {
			year: parseInt($scope.modalContent.end_date.substring(4, 8)),
			month: parseInt($scope.modalContent.end_date.substring(2, 4)) - 1,
			day: parseInt($scope.modalContent.end_date.substring(0, 2))
		}

		var instruction = {};
		instruction.lecture = $scope.modalContent.id;
		instruction.event = $scope.curso.id;
		instruction.class_number = $scope.modalContent.class_number;
		instruction.start_date = new Date(startDate.year, startDate.month, startDate.day);
		instruction.end_date = new Date(endDate.year, endDate.month, endDate.day);

		InstructionAPI.create(instruction)
		.then(function (response) {
			$scope.instructions.push(response.data);
			$scope.modalContent = null;
      $scope.data_loaded = true;
      Materialize.toast('Disciplina Adicionada', 3000)
		})
	}

	$scope.deleteInstruction = function () {
    $scope.data_loaded = false;
		InstructionAPI.destroy($scope.modalContent.id)
		.then(function (response) {
			for(var i = 0; i < $scope.instructions.length; i++) {
				if(response.data.id == $scope.instructions[i].id) {
					$scope.instructions.splice(i, 1);
					break;
				}
			}
			$scope.modalContent = null;
      $scope.data_loaded = true;
      Materialize.toast('Disciplina removida', 3000)
		})
	}
});
