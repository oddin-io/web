oddin.controller('AdminInstructionShowController', function ($http, $scope, $stateParams, $cookies) {

  $scope.usuario = {
    'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
    'email': JSON.parse($cookies.get('session').substring(2)).person.email,
  }

  $scope.data_loaded = true;

	(function buscaInfo() {
    $http.get('api/instructions/' + $stateParams.disciplinaID)
    .success(function (data) {
      $scope.disciplina = data;
    });
  })();

	$scope.buscaParticipants = function () {
		$http.get('api/instructions/' + $stateParams.disciplinaID + '/participants')
		.success(function (data) {
			$scope.participants = data;
		})
	}

  $scope.setRegistrableUsers = function () {
    //FIX THIS CALLBACK HELL!
    (function () {
      $http.get('api/person')
      .success(function (data) {
        $scope.users = data;
        (function () {
      		$http.get('api/instructions/' + $stateParams.disciplinaID + '/participants')
      		.success(function (data) {
      			$scope.participants = data;
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
      		})
      	})();
      })
    })();
  };

	$scope.createEnroll = function (user) {
		var enroll = {};
		enroll.person_id = user.id;
		enroll.instruction_id = $scope.disciplina.id;
		enroll.profile = user.enrollProfile ? 1 : 0;

		$http.post('api/enrolls', enroll)
		.success(function (data) {
			console.log(data)
			$scope.participants.push(data);
		})
	}

	$scope.removeEnroll = function () {
		$http.delete('api/enrolls/' + $scope.modalContent.id)
		.success(function (data) {
			for(var i = 0; i < $scope.participants.length; i++) {
				if(data.id == $scope.participants[i].id) {
					$scope.participants.splice(i, 1);
					break;
				}
			}
			$scope.modalContent = null;
		})
	}

	$scope.openModalRemoveParticipant = function (participant) {
		$scope.modalContent = angular.copy(participant);
		$('#modal-remove-participant').openModal();
	}


  // $scope.buscaInfo = function () {
  //   $http.get('api/events/' + $stateParams.cursoID)
  //   .success(function (data) {
  //     $scope.curso = data;
  //   });
  // }
});
