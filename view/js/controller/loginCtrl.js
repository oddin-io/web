app.controller("loginCtrl", function ($scope, $http) {
  $scope.login = function (user) {
    $http.post("/controller/login", user)
      .success(function (data, status) {
        location.pathname = "/app/lectures";
        location.replace();
      })
      .error(function (response, status) {
        if (status == 404) {
          $scope.message = "Usuário inexistente";
        } else if (status == 401) {
          $scope.message = "Senha incorreta";
        }
      });
  };

  $scope.logout = function () {
    $http.get("/controller/logout");
  };

  $scope.recoverPassword = function (user) {
    $http.post("/controller/recover-password", user)
      .success(function (data, status) {
        location.pathname = "/app/";
        location.replace();
      })
      .error(function (response, status) {
        $scope.message = response;
      });
  };
});
