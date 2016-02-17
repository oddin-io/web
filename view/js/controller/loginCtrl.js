app.controller("loginCtrl", function ($scope, $http) {
  var restServerUrl = window.config.urls["rest-server"];
  $http.defaults.headers.post["Content-Type"] = "text/plain";

  $scope.login = function (user) {
    $http.post(restServerUrl + "/controller/login", user)
      .success(function (data, status) {
        location.pathname = "/app/instruction";
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
    $http.get(restServerUrl + "/controller/logout").success(function (data) {
      location.pathname = "/";
      location.replace();
    });
  };

  $scope.recoverPassword = function (user) {
    $http.post(restServerUrl + "/controller/recover-password", user)
      .success(function (data, status) {
        location.pathname = "/app/";
        location.replace();
      })
      .error(function (response, status) {
        $scope.message = response;
      });
  };
});
