oddin.controller('NoticesController', function ($scope, $stateParams, InstructionAPI, CurrentUser) {

  $scope.usuario = CurrentUser;
  $scope.data_loaded = true;

	function buscaInfo() {
		InstructionAPI.show($stateParams.disciplinaID)
		.then(function (response) {
			$scope.disciplina = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

  $scope.buscaAvisos = function () {
		InstructionAPI.getNotices($stateParams.disciplinaID)
		.then(function (response) {
			$scope.avisos = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
  }

  $scope.postaAviso = function (notice) {
		var _notice = angular.copy(notice);
		delete $scope.aviso;

    $scope.data_loaded = false;
		InstructionAPI.createNotice($stateParams.disciplinaID, _notice)
		.then(function (response) {
			$scope.avisos.push(response.data);
			$scope.data_loaded = true;
			Materialize.toast('Aviso postado', 4000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
  }
  buscaInfo();
});
