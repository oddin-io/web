app.controller("lecturesCtrl", function ($scope, $http) {
  $scope.buildURI = function (lecture, prefix, sufix) {
    return prefix + "/" + lecture.event.code + "/" + lecture.code + "/" + lecture.startdate + "/" + lecture.class + sufix;
  };

  $scope.getLectures = function () {
    $http.get("/controller/lectures").success(function (data) {
      $scope.lectures = data.lectures;
    });
  };

  $scope.getLectures();
});
