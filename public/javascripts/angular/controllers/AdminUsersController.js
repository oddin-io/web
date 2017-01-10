oddin.controller('AdminUsersController', function ($http, $scope, $stateParams, $cookies) {
  $scope.usuario = {
    'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
    'email': JSON.parse($cookies.get('session').substring(2)).person.email,
  }
  $scope.data_loaded = true;

  $scope.buscaUsuarios = function () {
    $http.get('/api/person')
    .success(function (data) {
      $scope.users = data;
    })
  }

  $scope.createUser =  function () {
		$scope.data_loaded = false;
		$http.post('/api/person', $scope.user)
		.success(function (data) {
			$scope.users.push(data);
			$scope.user = null;
			$scope.data_loaded = true;
      Materialize.toast('Usuário cadastrado', 3000)
		})
	}

  //SERVIDOR RETORNA APENAS TRUE, RETORNAR OBJETO ATUALIZADO
  $scope.updateUser = function (modalContent) {
		$scope.data_loaded = false;
		$http.put('/api/person/' + modalContent.id, $scope.modalContent)
		.success(function (data) {
			$scope.users.forEach( function (elem, i) {
				if(elem.id == modalContent.id) {
          $scope.users[i] = data;
				}
			});
			$scope.data_loaded = true;
			Materialize.toast('Usuário atualizado', 3000);
		})
	}

  $scope.openModalDeleteUser = function (user) {
		$scope.modalContent = user;
		$('#modal-deleta-usuario').openModal();
	}

  $scope.openModalEditUser = function (user) {
		$scope.modalContent = angular.copy(user);
		$('#modal-edita-usuario').openModal();
	}

  $scope.deleteUser = function (modalContent) {
		$scope.data_loaded = false;
		$http.delete('/api/person/' + modalContent.id)
		.success(function (data) {
			for(var i = 0; i < $scope.users.length; i++) {
				if($scope.users[i].id == data.id) {
					$scope.users.splice(i, 1);
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Usuário deletado', 3000);
		})
		.error(function () {
			Materialize.toast('Este usuário não pôde ser deletado', 3000)
			$scope.data_loaded = true;
		})
	}
});
