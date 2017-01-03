oddin.controller('AdminInstructionShowController', function ($http, $scope, $stateParams, $cookies) {

  $scope.usuario = {
    'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
    'email': JSON.parse($cookies.get('session').substring(2)).person.email,
  }

  $scope.data_loaded = true;

  // $scope.buscaInfo = function () {
  //   $http.get('api/events/' + $stateParams.cursoID)
  //   .success(function (data) {
  //     $scope.curso = data;
  //   });
  // }
});
