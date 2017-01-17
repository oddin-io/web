oddin.controller('AdminEventsController', function ($http, $scope, $cookies) {
	$scope.usuario = {
		'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
		'email': JSON.parse($cookies.get('session').substring(2)).person.email,
	}

	$scope.data_loaded = true;

	$scope.openModalDeleteCurso = function (curso) {
		$scope.modalContent = angular.copy(curso);
		$('#modal-deleta-curso').openModal();
	}

	$scope.openModalEditCurso = function (curso) {
		$scope.modalContent = angular.copy(curso);
		$('#modal-edita-curso').openModal();
	}

	$scope.buscaCursos = function () {
		$http.get('/api/events')
		.success(function (data) {
			$scope.cursos = data;
		})
	}

	$scope.cadastraCurso =  function () {
		$scope.data_loaded = false;
		$http.post('/api/events', $scope.curso)
		.success(function (data) {
			$scope.cursos.push(data);
			$scope.curso = null;
			$scope.data_loaded = true;
			Materialize.toast('Curso cadastrado', 3000)
		})
	}

	//Implementar Atualização no Backend
	$scope.updateCurso = function (modalContent) {
		$scope.data_loaded = false;
		$http.put('/api/events/' + modalContent.id, $scope.modalContent)
		.success(function (data) {
			$scope.cursos.forEach( function (elem, i) {
				if(elem.id == modalContent.id) {
					$scope.cursos[i] = data;
				}
			});
			$scope.data_loaded = true;
			Materialize.toast('Curso atualizado', 3000);
		})
	}

	$scope.deleteCurso = function (modalContent) {
		$scope.data_loaded = false;
		$http.delete('/api/events/' + modalContent.id)
		.success(function (data) {
			for(var i = 0; i < $scope.cursos.length; i++) {
				if($scope.cursos[i].id == data.id) {
					$scope.cursos.splice(i, 1);
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Curso deletado', 3000);
		})
		.error(function () {
			Materialize.toast('Esse curso nao pode ser deletado', 3000)
			$scope.data_loaded = true;
		})
	}
});
