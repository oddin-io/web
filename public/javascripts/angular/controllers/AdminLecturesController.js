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

	$scope.buscaDisciplinas = function () {
		$http.get('/api/lectures')
		.success(function (data) {
			$scope.disciplinas = data;
		})
	}

	$scope.cadastraDisciplina =  function () {
		$scope.data_loaded = false;
		$http.post('/api/lectures', $scope.curso)
		.success(function (data) {
			$scope.disciplinas.push(data);
			$scope.disciplina = null;
			$scope.data_loaded = true;
		})
	}

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
