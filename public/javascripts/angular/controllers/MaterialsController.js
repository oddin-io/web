oddin.controller('MaterialsController', function ($http, $scope, $stateParams, InstructionAPI, MaterialAPI, CurrentUser) {

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

	$scope.buscaMateriais = function () {
		InstructionAPI.getMaterials($stateParams.disciplinaID)
		.then(function (response) {
			$scope.materiais = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.uploadMaterial = function () {
		$scope.data_loaded = false;
		var file = document.forms.uploadArchive.file.files[0]
		var fd = new FormData()

		InstructionAPI.createMaterial($stateParams.disciplinaID)
		.then(function (response) {
			for(var key in response.data.fields) {
				fd.append(key, response.data.fields[key]);
			}
			fd.append('file', file);
			$http.post(response.data.url, fd, { headers: {"Content-Type": undefined}})
			.then(function () {
				MaterialAPI.update(response.data.id, {'name': file.name, 'mime': file.type})
				.then(function (response) {
					$scope.materiais.push(response.data.material);
					$scope.data_loaded = true;
					document.getElementById("material-file").value = "";
					document.getElementById("material-description").value = "";
					Materialize.toast("O arquivo " + file.name + " foi postado", 3000);
				})
				.catch(function (error) {
					console.log(error.data);
				})
			})
		})
	}

	$scope.downloadMaterial = function (material) {
		$scope.data_loaded = false;
		MaterialAPI.show(material.id)
		.then(function (response) {
			var link = document.createElement('a');
			link.setAttribute('href', response.data.url);
			link.setAttribute('download', true);
			hiddenLink = document.getElementById("hidden-link");
			hiddenLink.appendChild(link);
			link.click();
			$scope.data_loaded = true;
			Materialize.toast('Fazendo download de ' + material.name, 4000);
			hiddenLink.removeChild(link);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.deleteMaterial = function (material) {
		$scope.data_loaded = false;
		MaterialAPI.destroy(material.id)
		.then(function (response) {
			for(var i = 0; i < $scope.materiais.length; i++) {
				if($scope.materiais[i].id == material.id) {
					$scope.materiais.splice(i, 1);
					break;
				}
			}
			$scope.data_loaded = true;
			Materialize.toast("Arquivo deletado", 3000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.openModalDeleteMaterial = function (material) {
		$scope.modalContent = material;
		$('#modal-deleta-material').openModal();
	}
	buscaInfo();
});
