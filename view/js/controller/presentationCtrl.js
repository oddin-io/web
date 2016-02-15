app.controller("presentationCtrl", function ($scope, $http) {
  var paths = (function () {
    var ret = getPaths();
    ret.splice(0, 1);

    return ret;
  })();

  var socket = io("http://localhost:3000/presentation");
  socket.on("new doubt", function (data) {
    $http.get("/controller/" + paths.join("/") + "/chat/doubt/" + data.doubt_id)
      .success(function (data) {
        $scope.doubts[data.id] = data;
      });
  });

 $scope.getPresentation = function () {
    $http.get("/controller/" + paths.join("/") + "/info")
    .success(function (data) {
      $scope.presentation = data;

      $http.get("/controller/" + paths.join("/") + "/chat/doubt").success(function (data) {
        $scope.doubts = data.doubts;
      });
    });
  };

  $scope.sendDoubt = function (doubt) {
    $http.post("/controller/" + paths.join("/") + "/chat/doubt", doubt).success(function (data) {
      socket.emit("new doubt", {doubt_id: data.id});
    });

    delete $scope.doubt;
  };

  $scope.likeDoubt = function (doubt) {
    var url = "/controller/" + paths.join("/") + "/chat/doubt/" + doubt.id;

    if (!doubt.curti) {
      $http.post(url + "/like", null).success(function (data) {
        doubt.curti = true;
      });
    } else {
      $http.delete(url + "/like").success(function (data) {
        doubt.curti = false;
      });
    }
  };

  $scope.changeStatus = function (doubt, status) {
    doubt.status = status;

    $http.post("/controller/" + paths.join("/") + "/chat/doubt/" + doubt.id + "/change-status", doubt);
  };

  $scope.getPresentation();
});
