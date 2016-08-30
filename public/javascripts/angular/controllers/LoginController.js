oddin.controller('LoginController',
    function($scope, $window, $http, $cookies, Login) {
        $scope.recover = {};
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
                    console.log(data);
                })
                .error(function(data) {
                    console.log('erro');
                    $scope.recover.email = "";
                })
        }
        $scope.redefinePassword = function() {}
    }
);
