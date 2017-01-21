oddin.controller('AdminUsersController', function ($scope, CurrentUser, PersonAPI) {
  $scope.usuario = CurrentUser;
  $scope.data_loaded = true;

  $scope.buscaUsuarios = function () {
		PersonAPI.index()
		.then(function(response) {
			$scope.users = response.data;
		})
		.catch(function(error) {
			console.log(error.data);
		})
  }

  $scope.createUser =  function (user) {
		$scope.data_loaded = false;
		var _user = angular.copy(user);
		delete $scope.user;
		PersonAPI.create(_user)
		.then(function(response) {
			$scope.users.push(response.data);
			$scope.data_loaded = true;
      Materialize.toast('Usuário cadastrado', 3000)
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

  $scope.updateUser = function (user) {
		$scope.data_loaded = false;
		var _user = angular.copy(user);
		delete $scope.modalContent;
		PersonAPI.update(_user.id, _user)
		.then(function(response) {
			for(var i = 0; i < $scope.users.length; i++) {
				if($scope.users[i].id == _user.id) {
					$scope.users[i] = response.data;
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Usuário atualizado', 3000);
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

  $scope.deleteUser = function (user) {
		$scope.data_loaded = false;
		PersonAPI.destroy(user.id)
		.then(function(response) {
			for(var i = 0; i < $scope.users.length; i++) {
				if($scope.users[i].id == user.id) {
					$scope.users.splice(i, 1);
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Usuário deletado', 3000);
		})
		.catch(function(error) {
			console.log(error.data);
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
});
