app.controller("loginCtrl", function ($scope, $http) {
  var restServerUrl = getEnvironment().config.urls["rest-server"];
  $http.defaults.headers.post["Content-Type"] = "text/plain";
  $http.defaults.headers.common["X-Auth-Token"] = getCookie("sso_client_token");

  $scope.login = function (user) {
    $http.post("/controller/login", user)
      .success(function (data, status) {
        location.pathname = "/app/instruction";
        location.replace();
      })
      .error(function (response, status) {
          $scope.message = "Credenciais incorretas";
      });
  };

  $scope.logout = function () {
    $http.get("/controller/logout").success(function (data) {
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
