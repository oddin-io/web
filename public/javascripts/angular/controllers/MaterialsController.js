import oddin from '../app'

oddin.controller('MaterialsController',
  ['$http', '$scope', '$stateParams', 'InstructionAPI', 'MaterialAPI', 'CurrentUser', 'ManageList',
    function ($http, $scope, $stateParams, InstructionAPI, MaterialAPI, CurrentUser, ManageList) {
      $scope.user = CurrentUser;

      (function getInfo() {
        $scope.load = false
        InstructionAPI.show($stateParams.instructionID)
                .then(function (response) {
                  $scope.instruction = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar informações da disciplina', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }());

      (function findMaterials() {
        $scope.load = false
        InstructionAPI.getMaterials($stateParams.instructionID)
                .then(function (response) {
                  $scope.materials = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar material', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())

      $scope.downloadMaterial = function (material) {
        $scope.load = false
        MaterialAPI.show(material.id)
                .then(function (response) {
                  var hiddenLink = document.getElementById('hidden-link')
                  var link = document.createElement('a')

                  link.setAttribute('href', response.data.url)
                  link.setAttribute('download', true)
                  hiddenLink.appendChild(link)
                  link.click()
                  hiddenLink.removeChild(link)
                  Materialize.toast('Fazendo download de ' + material.name, 3000)
                })
                .catch(function () {
                  Materialize.toast("Erro ao baixar '" + material.name, 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.createMaterial = function () {
        $scope.load = false
        let newMaterial = null;
        const file = document.forms.uploadArchive.file.files[0]

        InstructionAPI.createMaterial($stateParams.instructionID)
                .then(function (response) {
                  newMaterial = response.data
                  var fd = new FormData()

                  for (var key in newMaterial.fields) {
                    fd.append(key, newMaterial.fields[key])
                  }

                  fd.append('file', file)
                  return $http.post(newMaterial.url, fd, {
                    headers: {
                      'Content-Type': undefined,
                    },
                  })
                })
                .then(function () {
                  return MaterialAPI.update(newMaterial.id, {
                    name: file.name,
                    mime: file.type,
                  })
                })
                .then(function (response) {
                  $scope.materials.push(response.data.material)
                  Materialize.toast('O arquivo ' + file.name + ' foi postado', 3000)
                })
                .catch(function (err) {
                  console.log('Erro: ', err)
                  Materialize.toast('Erro ao fazer upload de arquivo', 3000)
                })
                .finally(function () {
                  document.getElementById('new-material-file').value = ''
                  document.getElementById('new-material-description').value = ''
                  $scope.load = true
                })
      }

      $scope.deleteMaterial = function (modalMaterial) {
        $scope.load = false
        MaterialAPI.destroy(modalMaterial.id)
                .then(function () {
                  ManageList.deleteItem($scope.materials, modalMaterial)
                  Materialize.toast('Material deletado', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao excluir Material', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.modalDelete = function (material) {
        $scope.modalMaterial = angular.copy(material)
        $('#modal-delete').openModal()
      }
    },
  ])
