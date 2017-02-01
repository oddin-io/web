oddin.controller('WorksController', ["$http", "$scope", "$stateParams", "$filter", "InstructionAPI", "WorkAPI", "MaterialAPI", "CurrentUser", "$filter", "$q",
function ($http, $scope, $stateParams, $filter, InstructionAPI, WorkAPI, MaterialAPI, CurrentUser, $filter, $q) {
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

	$scope.buscaTarefas = function () {
		InstructionAPI.getWorks($stateParams.disciplinaID)
		.then(function (response) {
			$scope.tarefas = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	function setCurrentWork(response) {
		currentWork = response.data;
		var deferred = $q.defer();
		if (true)
			deferred.resolve();
		else
			deferred.reject();
		return deferred.promise;
	}

	function destroyWorkMaterial() {
		return MaterialAPI.destroy(currentWork.materials[0].id)
	}

	function createWorkMaterial() {
		return WorkAPI.createMaterial(currentWork.id);
	}

	function uploadFile(response) {
		newMaterial = response.data;
		file = document.forms.uploadArchive.file.files[0];
		fd = new FormData();
		for(var key in newMaterial.fields) {
			fd.append(key, newMaterial.fields[key]);
		}
		fd.append('file', file);
		return $http.post(newMaterial.url, fd, {headers: {'Content-Type': undefined}})
	}

	function updateFile(response) {
		newMaterial = response.data;
		file = document.forms.updateArchive.file.files[0];
		fd = new FormData();
		for(var key in newMaterial.fields) {
			fd.append(key, newMaterial.fields[key]);
		}
		fd.append('file', file);
		return $http.post(newMaterial.url, fd, {headers: {'Content-Type': undefined}})
	}

	function updateMaterial() {
		return MaterialAPI.update(newMaterial.id, {'name': file.name, 'mime': file.type});
	}

	function showCurrentWork() {
		return WorkAPI.show(currentWork.id)
	}

	function addWorkToView(response) {
		$scope.tarefas.push(response.data);
		$scope.data_loaded = true;
		Materialize.toast('A tarefa foi criada', 3000);
	}

	function updateWorkView(response) {
		for(var i = 0; i < $scope.tarefas.length; i++) {
			if($scope.tarefas[i].id == response.data.id) {
				$scope.tarefas[i] = response.data;
				break;
			}
		}
		$scope.data_loaded = true;
		Materialize.toast('A tarefa foi atualizada', 3000);
	}

	$scope.criaTarefa = function (tarefa) {
		$scope.data_loaded = false;
		var _tarefa = angular.copy(tarefa);
		delete $scope.tarefa;
		_tarefa.deadline = $filter('toDate')(_tarefa.deadline);
		if(document.forms.uploadArchive.file.files[0]) {
			InstructionAPI.createWork($stateParams.disciplinaID, _tarefa)
			.then(setCurrentWork)
			.then(createWorkMaterial)
			.then(uploadFile)
			.then(updateMaterial)
			.then(showCurrentWork)
			.then(addWorkToView)
			.catch(function(error) {
				console.log(error.data);
			})
			return;
		}
		InstructionAPI.createWork($stateParams.disciplinaID, _tarefa)
		.then(addWorkToView)
		.catch(function(error) {
			console.log(error.data);
		})
	}

	$scope.atualizaTarefa = function (tarefa) {
		$scope.data_loaded = false;
		var _tarefa = angular.copy(tarefa);
		delete $scope.modalContent;
		_tarefa.deadline = $filter('toDate')(_tarefa.deadline);

		if(_tarefa.materials.length > 0 && document.forms.updateArchive.file.files[0]) {
			WorkAPI.update(_tarefa.id, _tarefa)
			.then(setCurrentWork)
			.then(destroyWorkMaterial)
			.then(createWorkMaterial)
			.then(updateFile)
			.then(updateMaterial)
			.then(showCurrentWork)
			.then(updateWorkView)
			.catch(function(error) {
				console.log(error.data);
			})
			return;
		}
		if(_tarefa.materials.length > 0 && !document.forms.updateArchive.file.files[0]) {
			WorkAPI.update(_tarefa.id, _tarefa)
			.then(setCurrentWork)
			.then(destroyWorkMaterial)
			.then(showCurrentWork)
			.then(updateWorkView)
			.catch(function(error) {
				console.log(error.data);
			})
			return;
		}
		if(_tarefa.materials.length == 0 && document.forms.updateArchive.file.files[0]) {
			WorkAPI.update(_tarefa.id, _tarefa)
			.then(setCurrentWork)
			.then(createWorkMaterial)
			.then(updateFile)
			.then(updateMaterial)
			.then(showCurrentWork)
			.then(updateWorkView)
			.catch(function(error) {
				console.log(error.data);
			})
			return;
		}
		WorkAPI.update(_tarefa.id, _tarefa)
		.then(updateWorkView)
		.catch(function(error) {
			console.log(error.data);
		})
	}

	$scope.deletaTarefa = function (tarefa) {
		$scope.data_loaded = false;
		WorkAPI.destroy(tarefa.id)
		.then(function () {
			if(tarefa.materials.length > 0) {
				MaterialAPI.destroy(tarefa.materials[0].id)
				.then(function () {
					for(var i = 0; i < $scope.tarefas.length; i++) {
						if($scope.tarefas[i].id == tarefa.id) {
							$scope.tarefas.splice(i, 1);
							break;
						}
					}
					$scope.data_loaded = true;
					Materialize.toast('Tarefa deletada', 3000);
				})
				return;
			}
			for(var i = 0; i < $scope.tarefas.length; i++) {
				if($scope.tarefas[i].id == tarefa.id) {
					$scope.tarefas.splice(i, 1);
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast('Tarefa deletada', 3000);
		})
	}

	$scope.downloadEspecificacao = function (tarefa) {
		$scope.data_loaded = false;
		MaterialAPI.show(tarefa.materials[0].id)
		.then(function(response) {
			var link = document.createElement('a');
			link.setAttribute('href', response.data.url);
			link.setAttribute('download', true);
			hiddenLink = document.getElementById("hidden-link");
			hiddenLink.appendChild(link);
			link.click();
			$scope.data_loaded = true;
			Materialize.toast('Baixando especificação: ' + tarefa.materials[0].name, 3000);
			hiddenLink.removeChild(link);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.openModalEditWork = function (tarefa) {
		$scope.modalContent = angular.copy(tarefa);
		$scope.modalContent.deadline = $filter('date')($scope.modalContent.deadline, 'ddMMyyyy');
		if(tarefa.materials[0]) {
			$scope.modalContent.materialName = tarefa.materials[0].name;
		}
		$('#editar-tarefa').openModal();
	}

	$scope.openModalDeleteWork = function (tarefa) {
		$scope.modalContent = tarefa;
		$('#modal-deleta-tarefa').openModal();
	}
	buscaInfo();
}]);
