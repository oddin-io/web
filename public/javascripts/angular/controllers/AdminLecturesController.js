oddin.controller('AdminLecturesController', function ($http, $scope, $stateParams, $cookies) {
	$scope.usuario = {
		'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
		'email': JSON.parse($cookies.get('session').substring(2)).person.email,
	}

	$scope.data_loaded = true;

	$scope.openModalDeleteDisciplina = function (disciplina) {
		$scope.modalContent = disciplina;
		$('#modal-deleta-disciplina').openModal();
	}

	$scope.openModalEditDisciplina = function (disciplina) {
		$scope.modalContent = angular.copy(disciplina);
		$('#modal-edita-disciplina').openModal();
	}

	$scope.buscaDisciplinas = function () {
		$http.get('/api/lectures')
		.success(function (data) {
			$scope.disciplinas = data;
		})
	}

	$scope.cadastraDisciplina =  function () {
		$scope.data_loaded = false;
		$http.post('/api/lectures', $scope.disciplina)
		.success(function (data) {
			$scope.disciplinas.push(data);
			$scope.disciplina = null;
			$scope.data_loaded = true;
			Materialize.toast('Disciplina cadastrada', 3000)
		})
	}

	//Implementar Atualização no Backend
	$scope.updateDisciplina = function (modalContent) {
		$scope.data_loaded = false;
		$http.put('/api/lectures/' + modalContent.id, $scope.modalContent)
		.success(function (data) {
			$scope.disciplinas.forEach( function (elem, i) {
				if(elem.id == modalContent.id) {
					$scope.disciplinas[i] = data;
				}
			});
			$scope.data_loaded = true;
			Materialize.toast('Disciplina atualizada', 3000);
		})
	}

	//Corrigir exclusão de disciplina no Backend
	$scope.deleteDisciplina = function (modalContent) {
		$scope.data_loaded = false;
		$http.delete('/api/lectures/' + modalContent.id)
		.success(function (data) {
			for(var i = 0; i < $scope.disciplinas.length; i++) {
				if($scope.disciplinas[i].id == data.id) {
					$scope.disciplinas.splice(i, 1);
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Disciplina deletada', 3000);
		})
		.error(function () {
			Materialize.toast('Essa disciplina nao pode ser deletada', 3000)
			$scope.data_loaded = true;
		})
	}
});
