oddin.controller('WorkShowController', function ($scope, $stateParams, $http, CurrentUser, WorkAPI, MaterialAPI, SubmissionAPI) {

	$scope.data_loaded = true;
	$scope.usuario = CurrentUser;

	function buscaInfo() {
		WorkAPI.show($stateParams.tarefaID)
		.then(function (response) {
			$scope.tarefa = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.buscaSubmissoesAluno = function () {
		WorkAPI.getSubmissions($stateParams.tarefaID)
		.then(function (response) {
			$scope.submissoes = [];
			var _submissions = response.data;
			_submissions.forEach(function (elem) {
				if(elem.person.id == $scope.usuario.id)
					$scope.submissoes.push(elem);
			})
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.buscaSubmissoes = function () {
		WorkAPI.getSubmissions($stateParams.tarefaID)
		.then(function (response) {
			$scope.submissoes = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.deleteSubmission = function (submission) {
		$scope.data_loaded = false;
		SubmissionAPI.destroy(submission.id)
		.then(function () {
			if(submission.materials.length > 0) {
				MaterialAPI.destroy(submission.materials[0].id)
				.then(function () {
					for(var i = 0; i < $scope.submissoes.length; i++) {
						if($scope.submissoes[i].id === submission.id) {
							$scope.submissoes.splice(i, 1);
							break;
						}
					}
					$scope.data_loaded = true;
					Materialize.toast('Trabalho deletado', 3000);
				})
			} else {
				for(var i = 0; i < $scope.submissoes.length; i++) {
					if($scope.submissoes[i].id === submission.id) {
						$scope.submissoes.splice(i, 1);
						break;
					}
				}
				$scope.data_loaded = true;
				Materialize.toast('Trabalho deletado', 3000);
			}
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.createSubmission = function (submission) {
		$scope.data_loaded = false;
		var _submission = angular.copy(submission);
		delete $scope.submission;
		WorkAPI.createSubmission($stateParams.tarefaID, _submission)
		.then(function (response) {
			_submission = response.data;
			if(document.forms.uploadArchive.file.files[0]) {
				var file = document.forms.uploadArchive.file.files[0]
				var fd = new FormData();
				SubmissionAPI.createMaterial(_submission.id)
				.then(function (response) {
					for(var key in response.data.fields) {
						fd.append(key, response.data.fields[key])
					}
					fd.append('file', file);
					$http.post(response.data.url, fd, {headers: {'Content-Type': undefined}})
					.then(function () {
						MaterialAPI.update(response.data.id, {'name': file.name, 'mime': file.type})
						.then(function () {
							SubmissionAPI.show(_submission.id)
							.then(function (response) {
								$scope.submissoes.push(response.data);
								$scope.data_loaded = true;
								Materialize.toast('Trabalho postado', 3000);
							})
						})
					})
				})
			} else {
				$scope.data_loaded = true;
				$scope.submissoes.push(_submission);
				Materialize.toast('Trabalho postado', 3000);
			}
		})
	}

	$scope.updateSubmission = function (submission) {
		$scope.data_loaded = false;
		var _submission = angular.copy(submission);
		delete $scope.modalContent;
		SubmissionAPI.update(_submission.id, _submission)
		.then(function (response) {
			if(_submission.materials.length > 0) {
				MaterialAPI.destroy(_submission.materials[0].id)
				.then(function () {
					if(document.forms.updateArchive.file.files[0]) {
						var file = document.forms.updateArchive.file.files[0]
						var fd = new FormData();
						SubmissionAPI.createMaterial(_submission.id)
						.then(function (response) {
							for(var key in response.data.fields) {
								fd.append(key, response.data.fields[key]);
							}
							fd.append('file', file);
							$http.post(response.data.url, fd, {headers: {'Content-Type': undefined}})
							.then(function () {
								MaterialAPI.update(response.data.id, {'name': file.name, 'mime': file.type})
								.then(function () {
									SubmissionAPI.show(_submission.id)
									.then(function (response) {
										for(var i = 0; i < $scope.submissoes.length; i++) {
											if($scope.submissoes[i].id == response.data.id) {
												$scope.submissoes[i] = response.data;
												break;
											}
										}
										$scope.data_loaded = true;
										Materialize.toast('O trabalho foi atualizado', 3000);
									})
								})
							})
						})
					} else {
						SubmissionAPI.show(_submission.id)
						.then(function (response) {
							for(var i = 0; i < $scope.submissoes.length; i++) {
								if($scope.submissoes[i].id == response.data.id) {
									$scope.submissoes[i] = response.data;
									break;
								}
							}
							$scope.data_loaded = true;
							Materialize.toast('O trabalho foi atualizado', 3000);
						})
					}
				})
			} else {
				if(document.forms.updateArchive.file.files[0]) {
					var file = document.forms.updateArchive.file.files[0]
					var fd = new FormData();
					SubmissionAPI.createMaterial(_submission.id)
					.then(function (response) {
						for(var key in response.data.fields) {
							fd.append(key, response.data.fields[key]);
						}
						fd.append('file', file);
						$http.post(response.data.url, fd, {headers: {'Content-Type': undefined}})
						.then(function () {
							MaterialAPI.update(response.data.id, {'name': file.name, 'mime': file.type})
							.then(function () {
								SubmissionAPI.show(_submission.id)
								.then(function (response) {
									for(var i = 0; i < $scope.submissoes.length; i++) {
										if($scope.submissoes[i].id == response.data.id) {
											$scope.submissoes[i] = response.data;
											break;
										}
									}
									$scope.data_loaded = true;
									Materialize.toast('O trabalho foi atualizado', 3000);
								})
							})
						})
					})
				} else {
					for(var i = 0; i < $scope.submissoes.length; i++) {
						if($scope.submissoes[i].id == response.data.id) {
							$scope.submissoes[i] = response.data;
							break;
						}
					}
					$scope.data_loaded = true;
					Materialize.toast('O trabalho foi atualizado', 3000);
				}
			}
		})
	}

	$scope.downloadSubmission = function (submissao) {
		$scope.data_loaded = false;
		MaterialAPI.show(submissao.materials[0].id)
		.then(function(response) {
			var link = document.createElement('a');
			link.setAttribute('href', response.data.url);
			link.setAttribute('download', true);
			hiddenLink = document.getElementById("hidden-link");
			hiddenLink.appendChild(link);
			link.click();
			$scope.data_loaded = true;
			Materialize.toast('Baixando trabalho: ' + submissao.materials[0].name, 3000);
			hiddenLink.removeChild(link);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.openModalDeleteSubmission = function (submission) {
		$scope.modalContent = submission;
		$('#modal-deleta-submissao').openModal();
	}

	$scope.openModalEditSubmission = function (submission) {
		$scope.modalContent = angular.copy(submission);
		if(submission.materials[0]) {
			$scope.modalContent.materialName = submission.materials[0].name;
		}
		$('#editar-trabalho').openModal();
	}
	buscaInfo();
});
