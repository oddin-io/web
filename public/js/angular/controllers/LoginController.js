angular.module('oddin-auth').controller('LoginController',
    function($scope, Login) {
        $scope.user = new Login();
        $scope.login = function() {
            $scope.user.$save()
                .then(function() {
                    location.pathname = "/";
                    location.replace();
                })
                .catch(function(erro) {
                    $scope.mensagem = "Erro!";
                });
        }
    }
);
