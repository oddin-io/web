import oddin from '../app'

oddin.controller('PresentationMaterialController',
  ['$scope', '$stateParams', '$http', 'CurrentUser', 'PresentationAPI', 'MaterialAPI', 'ManageList',
    function ($scope, $stateParams, $http, CurrentUser, PresentationAPI, MaterialAPI, ManageList) {
      $scope.user = CurrentUser;

      (function getInfo() {
        $scope.load = false
        PresentationAPI.show($stateParams.presentationID)
                .then(function (response) {
                  $scope.presentation = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar informações da aula', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }());

      (function findMaterials() {
        $scope.load = false
        PresentationAPI.getMaterials($stateParams.presentationID)
                .then(function (response) {
                  $scope.materials = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar materiais', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())

      $scope.createMaterial = function () {
        $scope.load = false
        let newMaterial = null;
        const file = document.forms.uploadArchive.file.files[0]

        PresentationAPI.createMaterial($stateParams.presentationID)
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
                  Materialize.toast('Erro ao fazer upload de material', 3000)
                })
                .finally(function () {
                  document.getElementById('new-material-file').value = ''
                  document.getElementById('new-material-description').value = ''
                  $scope.load = true
                })
      }

      $scope.downloadMaterial = function (material) {
        $scope.load = false
        MaterialAPI.show(material.id)
                .then(function (response) {
                  var hiddenLink = document.getElementById('hidden-link')
                  var link = document.createElement('a')

                  link.setAttribute('href', response.data.url)
                  link.setAttribute('download', true)
                  hiddenLink = document.getElementById('hidden-link')
                  hiddenLink.appendChild(link)
                  link.click()
                  Materialize.toast('Fazendo download de ' + material.name, 3000)
                  hiddenLink.removeChild(link)
                })
                .catch(function (err) {
                  console.log('Erro: ', err)
                  Materialize.toast('Erro ao fazer download de material', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.deleteMaterial = function (modalMaterial) {
        $scope.load = false
        MaterialAPI.destroy(modalMaterial.id)
                .then(function (response) {
                  ManageList.deleteItem($scope.materials, modalMaterial)
                  Materialize.toast('Material excluído', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao excluir material', 3000)
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
