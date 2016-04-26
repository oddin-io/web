app.controller("presentationCtrl", function ($scope, $http) {
  var paths = (function () {
    var ret = Util.getPaths();
    ret.splice(0, 1);

    return ret;
  })(), getDoubt = function (doubt_id) {
    $http.get(restServerUrl + "/controller/" + paths.join("/") + "/doubt/" + doubt_id)
      .success(function (data) {
        $scope.doubts[data.id] = data;
      });
  };

  var restServerUrl = Util.getEnvironment().config.urls["rest"];
  $http.defaults.headers.post["Content-Type"] = "text/plain";
  $http.defaults.headers.common["X-Auth-Token"] = Util.getCookie("sso_client_token");

// #region Socket.io
  var socket = io(Util.getEnvironment().config.urls["socket"] + "/presentation");
  socket.on("new/doubt", function (data) {
    console.log("Event = new/doubt; Data = " + data);
    getDoubt(data.doubt_id);
  });

  socket.on("new/contribution", function (data) {
    console.log("Event = new/contribution; Data = " + data);
    $http.get(restServerUrl + "/controller/" + paths.join("/") + "/doubt/" + data.doubt_id + "/contribution/" + data.contribution_id)
    .success(function (response) {
      console.log($scope.doubts[data.doubt_id]["answers"]);
      $scope.doubts[data.doubt_id]["answers"].push(response);

      console.log($scope.doubts[data.doubt_id]["answers"]);
      $scope.modal.doubt = $scope.doubts[data.doubt_id];
    });
  });

  socket.on("new/doubt_like", function (data) {
    getDoubt(data.doubt_id);
  });

  socket.on("delete/doubt_like", function (data) {
    getDoubt(data.doubt_id);
  });

  socket.on("new/doubt_understand", function (data) {
    getDoubt(data.doubt_id);
  });

  socket.on("delete/doubt_understand", function (data) {
    getDoubt(data.doubt_id);
  });

  socket.on("update/doubt_status", function (data) {
    getDoubt(data.doubt_id);
  });
// #endregion

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
      socket.emit("new/doubt", {doubt_id: data.id});
    });

    delete $scope.doubt;
  };

  $scope.likeDoubt = function (doubt) {
    var url = restServerUrl + "/controller/" + paths.join("/") + "/doubt/" + doubt.id;

    if (!doubt.like) {
      $http.post(url + "/like", null).success(function (data) {
        socket.emit("new/doubt_like", {doubt_id: doubt.id});
        doubt.like = true;
      });
    } else {
      $http.delete(url + "/like").success(function (data) {
        socket.emit("delete/doubt_like", {doubt_id: doubt.id});
        doubt.like = false;
      });
    }
  };

  $scope.changeStatus = function (doubt, status) {
    doubt.status = status;

    $http.post(restServerUrl + "/controller/" + paths.join("/") + "/doubt/" + doubt.id + "/change-status", doubt)
      .success(function (data) {
        socket.emit("update/doubt_status", {doubt_id: doubt.id});
      });
  };

  $scope.fetchAnswer = function (doubt) {
    if(doubt.answers == undefined)
      doubt.answers = [];

    if(doubt.answers.length == 0) {
      $http.get(restServerUrl + "/controller/" + paths.join("/") + "/doubt/" + doubt.id + "/contribution").success(function (data) {
        doubt.answers = data.contributions;
      });
    }
    else {
      doubt.answers = [];
    }
  };

  $scope.fetchAnswerProf = function (doubt) {
      $http.get(restServerUrl + "/controller/" + paths.join("/") + "/doubt/" + doubt.id + "/contribution").success(function (data) {
        doubt.answers = data.contributions;
      });
  };

  $scope.seeDoubt = function (doubt) {
    $scope.fetchAnswerProf(doubt);
    $scope.modal = {};
    $scope.modal.doubt = doubt;
  };

  $scope.answerDoubt = function (doubt, answer) {
    $http.post(restServerUrl + "/controller/" + paths.join("/") + "/doubt/" + doubt.id + "/contribution", answer)
      .success(function (data) {
        socket.emit("new/contribution", {doubt_id: doubt.id, contribution_id: data.Id});
        console.log(data.Id);
      });
    if(doubt.status == 0)
      $scope.changeStatus(doubt, 1);

    delete $scope.answer;
  };
});
