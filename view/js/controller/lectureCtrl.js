app.controller("lectureCtrl", function ($scope, $http) {
  var paths = (function () {
    var ret = getPaths();
    ret.splice(0, 1);
    ret.pop();

    return ret;
  })();

  $scope.buildURI = function (lecture, prefix, sufix) {
    return prefix + "/" + lecture.event.code + "/" + lecture.code + "/" + lecture.startdate + "/" + lecture.class + sufix;
  };

  $scope.getInfo = function () {
    $http.get("/controller/" + paths.join("/") + "/info").success(function (data) {
      $scope.lecture = data;
    });
  };

  $scope.getParticipants = function () {
    $http.get("/controller/" + paths.join("/") + "/participants").success(function (data) {
      $scope.participants = data.participants;
    });
  };

  $scope.getHistoric = function () {
    $http.get("/controller/" + paths.join("/") + "/historic").success(function (data) {
      $scope.presentations = data.presentations;
    });
  };

  $scope.getMaterials = function () {
    var url = "/controller/" + paths.join("/") + "/materials";
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
    var url = $scope.buildURI(lecture, "/controller", "/presentation");
    $http.post(url, presentation).success(function (data) {
      var presentationId = data.id;
      location.pathname = $scope.buildURI(lecture, "/app", "/presentation/" + presentationId);
      location.replace();
    });
  };

  $scope.closePresentation = function (presentation) {
    var url =  "/controller/" + paths.join("/") + "/presentation/" + presentation.id + "/close";
    $http.post(url, null).success(function (data) {
      presentation.status = 1;
    });
  };

  $scope.getInfo();
});
