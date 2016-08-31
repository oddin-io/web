oddin.controller('LoginController',
    function($scope, $window, $http, $cookies, Login) {
        $scope.recover = {};
        $scope.user = new Login();
        $scope.login = function() {
            $scope.user.$save()
                .then(function(data) {
                    $window.location.href = '/home';
                })
                .catch(function(erro) {
                    Materialize.toast('Usuário ou senha inválida', 5000);
                    $scope.user.email = "";
                    $scope.user.password = "";
                });
        }
        $scope.logout = function() {
            $http.post('/logout')
                .success(function(data) {
                    $cookies.remove('session');
                    $cookies.remove('profile');
                    $window.location.href = '/';
                });
        }
        $scope.recoverPassword = function() {
            $http.post('/recover-password', $scope.recover)
                .success(function(data) {
                    Materialize.toast('Um Email com o link para recuperação de senha será enviado para ' + $scope.recover.email, 3000);
                })
                .error(function(data) {
                    console.log('erro');
                    Materialize.toast('Não foi possível enviar o email de recuperação de senha', 8000);
                    $scope.recover.email = "";
                })
        }
        $scope.redefinePassword = function() {}
    }
);
