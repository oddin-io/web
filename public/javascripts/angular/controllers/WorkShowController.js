oddin.controller('WorkShowController', function ($scope, $stateParams, $http, CurrentUser, WorkAPI, MaterialAPI, SubmissionAPI, $q) {
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

	function setCurrentSubmission(response) {
		currentSubmission = response.data;
		var deferred = $q.defer();
		if (true)
			deferred.resolve();
		else
			deferred.reject();
		return deferred.promise;
	}

	function destroySubmissionMaterial() {
		return MaterialAPI.destroy(currentSubmission.materials[0].id)
	}

	function createSubmissionMaterial() {
		return SubmissionAPI.createMaterial(currentSubmission.id);
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

	function showCurrentSubmission() {
		return SubmissionAPI.show(currentSubmission.id)
	}

	function addSubmissionToView(response) {
		$scope.submissoes.push(response.data);
		$scope.data_loaded = true;
		Materialize.toast('Trabalho postado', 3000);
	}

	function updateSubmissionView(response) {
		for(var i = 0; i < $scope.submissoes.length; i++) {
			if($scope.submissoes[i].id == response.data.id) {
				$scope.submissoes[i] = response.data;
				break;
			}
		}
		$scope.data_loaded = true;
		Materialize.toast('O trabalho foi atualizado', 3000);
	}

	$scope.createSubmission = function (submission) {
		$scope.data_loaded = false;
		var _submission = angular.copy(submission);
		delete $scope.submission;
		if(document.forms.uploadArchive.file.files[0]) {
			WorkAPI.createSubmission($stateParams.tarefaID, _submission)
			.then(setCurrentSubmission)
			.then(createSubmissionMaterial)
			.then(uploadFile)
			.then(updateMaterial)
			.then(showCurrentSubmission)
			.then(addSubmissionToView)
			.catch(function(error) {
				console.log(error.data);
			})
			return;
		}
		WorkAPI.createSubmission($stateParams.tarefaID, _submission)
		.then(addSubmissionToView)
		.catch(function(error) {
			console.log(error.data);
		})
	}

	$scope.updateSubmission = function (submission) {
		$scope.data_loaded = false;
		var _submission = angular.copy(submission);
		delete $scope.modalContent;
		if(_submission.materials.length > 0 && document.forms.updateArchive.file.files[0]) {
			SubmissionAPI.update(_submission.id, _submission)
			.then(setCurrentSubmission)
			.then(destroySubmissionMaterial)
			.then(createSubmissionMaterial)
			.then(updateFile)
			.then(updateMaterial)
			.then(showCurrentSubmission)
			.then(updateSubmissionView)
			.catch(function(error) {
				console.log(error.data);
			})
			return;
		}
		if(_submission.materials.length > 0 && !document.forms.updateArchive.file.files[0]) {
			SubmissionAPI.update(_submission.id, _submission)
			.then(setCurrentSubmission)
			.then(destroySubmissionMaterial)
			.then(showCurrentSubmission)
			.then(updateSubmissionView)
			.catch(function(error) {
				console.log(error.data);
			})
			return;
		}
		if(_submission.materials.length == 0 && document.forms.updateArchive.file.files[0]) {
			SubmissionAPI.update(_submission.id, _submission)
			.then(setCurrentSubmission)
			.then(createSubmissionMaterial)
			.then(updateFile)
			.then(updateMaterial)
			.then(showCurrentSubmission)
			.then(updateSubmissionView)
			.catch(function(error) {
				console.log(error.data);
			})
			return;
		}
		SubmissionAPI.update(_submission.id, _submission)
		.then(updateSubmissionView)
		.catch(function(error) {
			console.log(error.data);
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
