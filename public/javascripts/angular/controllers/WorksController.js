oddin.controller('WorksController', function ($http, $scope, $stateParams, $filter, InstructionAPI, WorkAPI, MaterialAPI, CurrentUser, FormatUtil) {

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

	$scope.criaTarefa = function (tarefa) {
		$scope.data_loaded = false;
		var _tarefa = angular.copy(tarefa);
		delete $scope.tarefa;
		_tarefa.deadline = FormatUtil.convertToDate(_tarefa.deadline);
		InstructionAPI.createWork($stateParams.disciplinaID, _tarefa)
		.then(function (response) {
			_tarefa = response.data;
			if(document.forms.uploadArchive.file.files[0]) {
				var file = document.forms.uploadArchive.file.files[0];
				var fd = new FormData();
				WorkAPI.createMaterial(response.data.id)
				.then(function (response) {
					for(var key in response.data.fields) {
						fd.append(key, response.data.fields[key]);
					}
					fd.append('file', file);
					$http.post(response.data.url, fd, {headers: {'Content-Type': undefined}})
					.then(function () {
						MaterialAPI.update(response.data.id, {'name': file.name, 'mime': file.type})
						.then(function () {
							WorkAPI.show(_tarefa.id)
							.then(function (response) {
								$scope.tarefas.push(response.data);
								$scope.data_loaded = true;
								Materialize.toast('A tarefa foi criada', 3000);
							})
						});
					});
				});
			} else {
				$scope.data_loaded = true;
				$scope.tarefas.push(_tarefa);
				Materialize.toast('A tarefa foi criada', 3000);
			}
		});
	}

	$scope.atualizaTarefa = function (tarefa) {
		$scope.data_loaded = false;
		var _tarefa = angular.copy(tarefa);
		delete $scope.modalContent;
		_tarefa.deadline = FormatUtil.convertToDate(_tarefa.deadline);
		WorkAPI.update(_tarefa.id, _tarefa)
		.then(function (response) {
			if(_tarefa.materials.length > 0) {
				MaterialAPI.destroy(_tarefa.materials[0].id)
				.then(function () {
					if(document.forms.updateArchive.file.files[0]) {
						var file = document.forms.updateArchive.file.files[0];
						var fd = new FormData();
						WorkAPI.createMaterial(_tarefa.id)
						.then(function (response) {
							for(var key in response.data.fields) {
								fd.append(key, response.data.fields[key]);
							}
							fd.append('file', file);
							$http.post(response.data.url, fd, {headers: {'Content-Type':undefined}})
							.then(function () {
								MaterialAPI.update(response.data.id, {'name':file.name, 'mime': file.type})
								.then(function () {
									WorkAPI.show(_tarefa.id)
									.then(function (response) {
										for(var i = 0; i < $scope.tarefas.length; i++) {
											if($scope.tarefas[i].id == response.data.id) {
												$scope.tarefas[i] = response.data;
												break;
											}
										}
										$scope.data_loaded = true;
										Materialize.toast('A tarefa foi atualizada', 3000);
									})
								})
							})
						})
					} else {
						for(var i = 0; i < $scope.tarefas.length; i++) {
							if($scope.tarefas[i].id == response.data.id) {
								$scope.tarefas[i] = response.data;
								break;
							}
						}
						$scope.data_loaded = true;
						Materialize.toast('A tarefa foi atualizada', 3000);
					}
				})
			} else {
				if(document.forms.updateArchive.file.files[0]) {
					var file = document.forms.updateArchive.file.files[0]
					var fd = new FormData();
					WorkAPI.createMaterial(_tarefa.id)
					.then(function (response) {
						for(var key in response.data.fields) {
							fd.append(key, response.data.fields[key]);
						}
						fd.append('file', file);
						$http.post(response.data.url, fd, {headers: {'Content-Type': undefined}})
						.then(function () {
							MaterialAPI.update(response.data.id, {'name': file.name, 'mime': file.type})
							.then(function () {
								WorkAPI.show(_tarefa.id)
								.then(function (response) {
									for(var i = 0; i < $scope.tarefas.length; i++) {
										if($scope.tarefas[i].id == response.data.id) {
											$scope.tarefas[i] = response.data;
											break;
										}
									}
									$scope.data_loaded = true;
									Materialize.toast('A tarefa foi atualizada', 3000);
								})
							})
						})
					})
				} else {
					for(var i = 0; i < $scope.tarefas.length; i++) {
						if($scope.tarefas[i].id == response.data.id) {
							$scope.tarefas[i] = response.data;
							break;
						}
					}
					$scope.data_loaded = true;
					Materialize.toast('A tarefa foi atualizada', 3000);
				}
			}
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
});
