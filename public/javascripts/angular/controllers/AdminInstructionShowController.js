oddin.controller('AdminInstructionShowController', function ($scope, $stateParams, CurrentUser, InstructionAPI, PersonAPI, EnrollAPI) {

  $scope.usuario = CurrentUser;
  $scope.data_loaded = true;

	(function buscaInfo() {
		InstructionAPI.show($stateParams.disciplinaID)
		.then(function(response) {
			$scope.disciplina = response.data;
		})
		.catch(function(error) {
			console.log(error.data);
		})
  })();

	$scope.buscaParticipants = function () {
		InstructionAPI.getParticipants($stateParams.disciplinaID)
		.then(function(response) {
			$scope.participants = response.data;
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

  $scope.setRegistrableUsers = function () {
		PersonAPI.index()
		.then(function(response) {
			$scope.users = response.data;
			InstructionAPI.getParticipants($stateParams.disciplinaID)
			.then(function(response) {
				$scope.participants = response.data;
				$scope.availableUsers = $scope.users.filter(function (user, i) {
					var result = true;
					for(var i = 0; i < $scope.participants.length; i++) {
						if(user.id == $scope.participants[i].person.id) {
							result = false;
							break;
						}
					}
					return result;
				})
			})
			.catch(function(error) {
				console.log(error.data);
			})
		})
		.catch(function(error) {
			console.log(error.data);
		})
  }

	$scope.createEnroll = function (user) {
    $scope.data_loaded = false;
		var enroll = {};
		enroll.person_id = user.id;
		enroll.instruction_id = $stateParams.disciplinaID;
		enroll.profile = user.enrollProfile ? 1 : 0;

		EnrollAPI.create(enroll)
		.then(function(response) {
			$scope.participants.push(response.data);
			$scope.availableUsers = $scope.users.filter(function (user, i) {
				var result = true;
				for(var i = 0; i < $scope.participants.length; i++) {
					if(user.id == $scope.participants[i].person.id) {
						result = false;
						break;
					}
				}
				return result;
			});
			$scope.data_loaded = true;
			Materialize.toast('Usuário cadastrado', 3000);
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

	$scope.removeEnroll = function (participant) {
    $scope.data_loaded = false;
		EnrollAPI.destroy(participant.id)
		.then(function() {
			for(var i = 0; i < $scope.participants.length; i++) {
				if(participant.id == $scope.participants[i].id) {
					$scope.participants.splice(i, 1);
					break;
				}
			}
			if($scope.availableUsers) {
				$scope.availableUsers.push(participant.person);
			}
      $scope.data_loaded = true;
      Materialize.toast('Usuário removido', 3000)
		})
		.catch(function(error) {
			console.log(error.data);
		})
	}

	$scope.openModalRemoveParticipant = function (participant) {
		$scope.modalContent = angular.copy(participant);
		$('#modal-remove-participant').openModal();
	}
});
