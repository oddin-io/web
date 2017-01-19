oddin.controller('DatesController', function ($scope, $stateParams, DateAPI, InstructionAPI, CurrentUser, $filter, FormatUtil) {

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

	$scope.postaData = function (date) {
		$scope.data_loaded = false;

		var _date = angular.copy(date);
		_date.date = FormatUtil.convertToDate(_date.date, _date.time);
		delete _date.time;
		delete $scope.date;

		InstructionAPI.createDate($stateParams.disciplinaID, _date)
		.then(function (response) {
			$scope.datas.push(response.data);
			$scope.data_loaded = true;
			Materialize.toast("A Data foi postada", 4000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.buscaDatas = function () {
		InstructionAPI.getDates($stateParams.disciplinaID)
		.then(function (response) {
			$scope.datas = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.updateDate = function (date) {
		$scope.data_loaded = false;

		var _date = angular.copy(date);
		_date.date = FormatUtil.convertToDate(_date.date, _date.time);
		delete _date.time;
		delete $scope.modalContent;

		DateAPI.update(_date.id, _date)
		.then(function (response) {
			for(var i = 0; i < $scope.datas.length; i++) {
				if($scope.datas[i].id == response.data.id) {
					$scope.datas[i] = response.data;
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Data atualizada', 3000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.deleteDate = function (date) {
		$scope.data_loaded = false;

		var _date = angular.copy(date);
		delete $scope.modalContent;

		DateAPI.destroy(_date.id)
		.then(function (response) {
			for(var i = 0; i < $scope.datas.length; i++) {
				if($scope.datas[i].id == _date.id) {
					$scope.datas.splice(i, 1);
					break;
				}
			}
			$scope.data_loaded = true;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.openModalDeleteDate = function (date) {
		$scope.modalContent = date;
		$('#modal-delete-date').openModal();
	}

	$scope.openModalEditDate = function (date) {
		var _date = date.date;
		$scope.modalContent = angular.copy(date);
		$scope.modalContent.date = $filter('date')(_date, 'ddMMyyyy');
		$scope.modalContent.time = $filter('date')(_date, 'HHmm')
		$('#modal-editar-data').openModal();
	}

	buscaInfo();
});
