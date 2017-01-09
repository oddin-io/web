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


  // $scope.buscaInfo = function () {
  //   $http.get('api/events/' + $stateParams.cursoID)
  //   .success(function (data) {
  //     $scope.curso = data;
  //   });
  // }
});
