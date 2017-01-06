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
        console.log('2');
        (function () {
      		$http.get('api/instructions/' + $stateParams.disciplinaID + '/participants')
      		.success(function (data) {
      			$scope.participants = data;

            console.log($scope.users);
            console.log($scope.participants);

            $scope.registrableUsers = $scope.users.filter(function (user, i) {
              var result = true;
              $scope.participants.every(function (participants, i) {
                if(user.id != participants.person.id) {
                  
                }
              })
              return result;
            });
            console.log($scope.registrableUsers)
      		})
      	})();
      })
    })();
  };


  // $scope.buscaInfo = function () {
  //   $http.get('api/events/' + $stateParams.cursoID)
  //   .success(function (data) {
  //     $scope.curso = data;
  //   });
  // }
});
