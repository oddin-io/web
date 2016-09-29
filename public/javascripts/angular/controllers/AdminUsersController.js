oddin.controller('AdminUsersController',
  function ($http, $scope, $stateParams, $cookies) {
    $scope.usuario = {
      'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
      'email': JSON.parse($cookies.get('session').substring(2)).person.email,
    }
    $scope.data_loaded = true;

    $scope.buscaCursos = function () {
      $http.get('/api/events')
      .success(function (data) {
        $scope.cursos = data;
      })
    }
    $scope.cadastraCurso =  function () {
      $http.post('/api/events', $scope.curso)
      .success(function (data) {
        console.log(data);
        $scope.curso = null;
      })
    }
  }
)
