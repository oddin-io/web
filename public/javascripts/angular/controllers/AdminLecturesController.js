oddin.controller('AdminLecturesController', function ($scope, CurrentUser, LectureAPI) {

	$scope.usuario = CurrentUser;
	$scope.data_loaded = true;

	$scope.buscaDisciplinas = function () {
		LectureAPI.index()
		.then(function (response) {
			$scope.disciplinas = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.cadastraDisciplina =  function (disciplina) {
		$scope.data_loaded = false;
		var _disciplina = angular.copy(disciplina);
		delete $scope.disciplina;
		LectureAPI.create(_disciplina)
		.then(function (response) {
			$scope.disciplinas.push(response.data);
			$scope.data_loaded = true;
			Materialize.toast('Disciplina cadastrada', 3000)
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.updateDisciplina = function (disciplina) {
		$scope.data_loaded = false;
		var _disciplina = angular.copy(disciplina);
		delete $scope.modalContent;
		LectureAPI.update(_disciplina.id, _disciplina)
		.then(function (response) {
			for(var i = 0; i < $scope.disciplinas.length; i++) {
				if($scope.disciplinas[i].id == _disciplina.id) {
					$scope.disciplinas[i] = response.data;
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Disciplina atualizada', 3000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.deleteDisciplina = function (disciplina) {
		$scope.data_loaded = false;
		LectureAPI.destroy(disciplina.id)
		.then(function(response) {
			for(var i = 0; i < $scope.disciplinas.length; i++) {
				if($scope.disciplinas[i].id == disciplina.id) {
					$scope.disciplinas.splice(i, 1);
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Disciplina deletada', 3000);
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

	$scope.openModalDeleteDisciplina = function (disciplina) {
		$scope.modalContent = disciplina;
		$('#modal-deleta-disciplina').openModal();
	}

	$scope.openModalEditDisciplina = function (disciplina) {
		$scope.modalContent = angular.copy(disciplina);
		$('#modal-edita-disciplina').openModal();
	}
});
