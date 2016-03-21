app.controller("instructionCtrl", function ($scope, $http) {
  var paths = (function () {
    var ret = Util.getPaths();
    ret.splice(0, 1);
    ret.pop();

    return ret;
  })();

  var restServerUrl = Util.getEnvironment().config.urls["rest"];
  $http.defaults.headers.common["Content-Type"] = "text/plain";
  $http.defaults.headers.common["X-Auth-Token"] = Util.getCookie("sso_client_token");

  $scope.buildURI = function (instruction, prefix, sufix) {
    return prefix + "/instruction/" + instruction.id + sufix;
  };

  $scope.getInstructions = function () {
    $http.get(restServerUrl + "/controller/instruction").success(function (data) {
      $scope.instructions = data.lectures;
    });
  };

  $scope.getInfo = function () {
    $http.get(restServerUrl + "/controller/" + paths.join("/") + "/info").success(function (data) {
      $scope.instruction = data;
    });
  };

  $scope.getParticipants = function () {
    $http.get(restServerUrl + "/controller/" + paths.join("/") + "/participants").success(function (data) {
      $scope.participants = data.participants;
    });
  };

  $scope.getHistoric = function () {
    $http.get(restServerUrl + "/controller/" + paths.join("/") + "/presentation").success(function (data) {
      $scope.presentations = data.presentations;
    });
  };

  $scope.getMaterials = function () {
    var url = restServerUrl + "/controller/" + paths.join("/") + "/material";
    $http.get(url).success(function (data) {
      $scope.materials = data.materials;
    });
  };
  //
  // $scope.downloadMaterial = function (material) {
  //
  // };
  //
  // $scope.uploadMaterial = function (material) {
  //
  // };

  $scope.newPresentation = function (lecture, presentation) {
    var url = restServerUrl + "/controller/" + paths.join("/") + "/presentation";
    $http.post(url, presentation).success(function (data) {
      var presentationId = data.id;
      location.pathname = $scope.buildURI(instruction, "/app", "/presentation/" + presentationId);
      location.replace();
    });
  };

  $scope.closePresentation = function (presentation) {
    var url =  restServerUrl + "/controller/" + paths.join("/") + "/presentation/" + presentation.id + "/close";
    $http.post(url, null).success(function (data) {
      presentation.status = 1;
    });
  };
});
