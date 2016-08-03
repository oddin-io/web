angular.module('oddin').controller('LoginController',
  function($scope, $window, Login) {
    $scope.user = new Login();
    $scope.login = function() {
      $scope.user.$save()
      .then(function(data) {
        //$window.sessionStorage = data;
        $window.location.href = '/home';
      })
      .catch(function(erro) {
        //delete $window.sessionStorage.token;
        $scope.mensagem = "Usuário ou senha inválida";
      });
    }
  }
);
