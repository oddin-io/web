oddin.controller('AdminEventsController', function ($scope, CurrentUser, EventAPI) {

	$scope.usuario = CurrentUser;
	$scope.data_loaded = true;

	$scope.buscaCursos = function () {
		EventAPI.index()
		.then(function(response) {
			$scope.cursos = response.data;
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

	$scope.cadastraCurso =  function (curso) {
		$scope.data_loaded = false;
		var _curso = angular.copy(curso);
		delete $scope.curso;
		EventAPI.create(_curso)
		.then(function(response) {
			$scope.cursos.push(response.data);
			$scope.data_loaded = true;
			Materialize.toast('Curso cadastrado', 3000)
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

	$scope.updateCurso = function (curso) {
		$scope.data_loaded = false;
		var _curso = angular.copy(curso);
		delete $scope.modalContent;
		EventAPI.update(_curso.id, _curso)
		.then(function(response) {
			for(var i = 0; i < $scope.cursos.length; i++) {
				if($scope.cursos[i].id == _curso.id) {
					$scope.cursos[i] = response.data;
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Curso atualizado', 3000);
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

	$scope.deleteCurso = function (curso) {
		$scope.data_loaded = false;
		EventAPI.destroy(curso.id)
		.then(function (response) {
			for(var i = 0; i < $scope.cursos.length; i++) {
				if($scope.cursos[i].id == curso.id) {
					$scope.cursos.splice(i, 1);
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Curso deletado', 3000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.openModalDeleteCurso = function (curso) {
		$scope.modalContent = angular.copy(curso);
		$('#modal-deleta-curso').openModal();
	}

	$scope.openModalEditCurso = function (curso) {
		$scope.modalContent = angular.copy(curso);
		$('#modal-edita-curso').openModal();
	}
});
