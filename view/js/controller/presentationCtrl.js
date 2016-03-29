app.controller("presentationCtrl", function ($scope, $http) {
  var paths = (function () {
    var ret = Util.getPaths();
    ret.splice(0, 1);

    return ret;
  })();

  var restServerUrl = Util.getEnvironment().config.urls["rest"];;
  $http.defaults.headers.post["Content-Type"] = "text/plain";
  $http.defaults.headers.common["X-Auth-Token"] = Util.getCookie("sso_client_token");

  var socket = io(Util.getEnvironment().config.urls["socket"] + "/presentation");
  socket.on("new doubt", function (data) {
    $http.get(restServerUrl + "/controller/" + paths.join("/") + "/doubt/" + data.doubt_id)
      .success(function (data) {
        $scope.doubts[data.id] = data;
      });
  });

  $scope.getPresentation = function () {
    $http.get(restServerUrl + "/controller/" + paths.join("/") + "/info")
      .success(function (data) {
        $scope.presentation = data;

        $http.get(restServerUrl + "/controller/" + paths.join("/") + "/doubt").success(function (data) {
          $scope.doubts = data.doubts;
        });
      });
  };

  $scope.sendDoubt = function (doubt) {
    $http.post(restServerUrl + "/controller/" + paths.join("/") + "/doubt", doubt).success(function (data) {
      socket.emit("new doubt", {doubt_id: data.id});
    });

    delete $scope.doubt;
  };

  $scope.likeDoubt = function (doubt) {
    var url = restServerUrl + "/controller/" + paths.join("/") + "/doubt/" + doubt.id;

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

    $http.post(restServerUrl + "/controller/" + paths.join("/") + "/doubt/" + doubt.id + "/change-status", doubt);
  };

  $scope.seeDoubt = function (doubt) {
    $scope.modal = {};
    $scope.modal.doubt = doubt;
  };

  $scope.fetchAnswer = function (doubt) {
    $http.get(restServerUrl + "/controller/" + paths.join("/") + "/doubt/" + doubt.id + "/contribution").success(function (data) {
      doubt.answers = data.contributions;
    });
  };

  $scope.answerDoubt = function (doubt, answer) {
    $http.post(restServerUrl + "/controller/" + paths.join("/") + "/doubt/" + doubt.id + "/contribution", answer);

    delete $scope.answer;
  };
});
