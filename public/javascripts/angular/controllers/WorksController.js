import oddin from '../app'

oddin.controller('WorksController', [
  '$http', '$scope', '$stateParams', '$filter', '$q',
  'InstructionAPI', 'WorkAPI', 'MaterialAPI', 'CurrentUser', 'ManageList',
  function (
        $http, $scope, $stateParams, $filter,
        InstructionAPI, WorkAPI, MaterialAPI, CurrentUser, $q, ManageList
    ) {
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

    (function findWorks() {
      $scope.load = false
      InstructionAPI.getWorks($stateParams.instructionID)
                .then(function (response) {
                  $scope.works = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar tarefas', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
    }())

    $scope.createWork = function (newWork) {
      $scope.load = false
      newWork.deadline = $filter('toDate')(newWork.deadline)
      if (document.forms.uploadArchive.file.files[0]) {
        InstructionAPI.createWork($stateParams.instructionID, newWork)
                    .then(setCurrentWork)
                    .then(createWorkMaterial)
                    .then(uploadFile)
                    .then(updateMaterial)
                    .then(showCurrentWork)
                    .then(addWorkToView)
                    .catch(function () {
                      Materialize.toast('Erro ao criar nova tarefa', 3000)
                    })
                    .finally(function () {
                      document.getElementById('new-work-file').value = ''
                      delete $scope.newWork
                      $scope.load = true
                    })
        return
      }
      InstructionAPI.createWork($stateParams.instructionID, newWork)
                .then(addWorkToView)
                .catch(function () {
                  Materialize.toast('Erro ao criar nova tarefa', 3000)
                })
                .finally(function () {
                  delete $scope.newWork
                  $scope.load = true
                })
    }

    $scope.updateWork = function (modalWork) {
      $scope.load = false
      modalWork.deadline = $filter('toDate')(modalWork.deadline)

      if (modalWork.materials.length > 0 && document.forms.updateArchive.file.files[0]) {
        WorkAPI.update(modalWork.id, modalWork)
                    .then(setCurrentWork)
                    .then(destroyWorkMaterial)
                    .then(createWorkMaterial)
                    .then(updateFile)
                    .then(updateMaterial)
                    .then(showCurrentWork)
                    .then(updateWorkView)
                    .catch(function () {
                      Materialize.toast('Erro ao atualizar tarefa', 3000)
                    })
                    .finally(function () {
                      $scope.load = true
                    })
        return
      }
      if (modalWork.materials.length > 0 && !document.forms.updateArchive.file.files[0]) {
        WorkAPI.update(modalWork.id, modalWork)
                    .then(setCurrentWork)
                    .then(destroyWorkMaterial)
                    .then(showCurrentWork)
                    .then(updateWorkView)
                    .catch(function () {
                      Materialize.toast('Erro ao atualizar tarefa', 3000)
                    })
                    .finally(function () {
                      $scope.load = true
                    })
        return
      }
      if (modalWork.materials.length === 0 && document.forms.updateArchive.file.files[0]) {
        WorkAPI.update(modalWork.id, modalWork)
                    .then(setCurrentWork)
                    .then(createWorkMaterial)
                    .then(updateFile)
                    .then(updateMaterial)
                    .then(showCurrentWork)
                    .then(updateWorkView)
                    .catch(function () {
                      Materialize.toast('Erro ao atualizar tarefa', 3000)
                    })
                    .finally(function () {
                      $scope.load = true
                    })
        return
      }
      WorkAPI.update(modalWork.id, modalWork)
                .then(updateWorkView)
                .catch(function () {
                  Materialize.toast('Erro ao atualizar tarefa', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
    }

    $scope.deleteWork = function (modalWork) {
      $scope.load = false
      WorkAPI.destroy(modalWork.id)
                .then(function () {
                  if (modalWork.materials.length > 0) {
                    MaterialAPI.destroy(modalWork.materials[0].id)
                            .then(function () {
                              ManageList.deleteItem($scope.works, modalWork)
                              Materialize.toast('Tarefa deletada', 3000)
                            })
                            .catch(function () {
                              Materialize.toast('Erro ao deletar tarefa', 3000)
                            })
                    return
                  }
                  ManageList.deleteItem($scope.works, modalWork)
                  Materialize.toast('Tarefa deletada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao deletar tarefa', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
    }

    $scope.downloadDescription = function (work) {
      $scope.load = false
      MaterialAPI.show(work.materials[0].id)
                .then(function (response) {
                  var hiddenLink = document.getElementById('hidden-link')
                  var link = document.createElement('a')

                  link.setAttribute('href', response.data.url)
                  link.setAttribute('download', true)
                  hiddenLink.appendChild(link)
                  link.click()
                  hiddenLink.removeChild(link)

                  Materialize.toast('Baixando especificação: ' + work.materials[0].name, 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao baixar especificação', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
    }

    $scope.modalEdit = function (work) {
      $scope.modalWork = angular.copy(work)
      $scope.modalWork.deadline = $filter('date')($scope.modalWork.deadline, 'ddMMyyyy')
      if (work.materials[0]) {
        $scope.modalWork.materialName = work.materials[0].name
      }
      $('#modal-edit').openModal()
    }

    $scope.modalDelete = function (work) {
      $scope.modalWork = angular.copy(work)
      $('#modal-delete').openModal()
    }

        // File Upload Auxiliar Functions
    function setCurrentWork(response) {
      currentWork = response.data
      var deferred = $q.defer()
      if (true) {
        deferred.resolve()
      } else {
        deferred.reject()
      }
      return deferred.promise
    }

    function destroyWorkMaterial() {
      return MaterialAPI.destroy(currentWork.materials[0].id)
    }

    function createWorkMaterial() {
      return WorkAPI.createMaterial(currentWork.id)
    }

    function uploadFile(response) {
      var newMaterial = response.data
      var file = document.forms.uploadArchive.file.files[0]
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
    }

    function updateFile(response) {
      var newMaterial = response.data
      var file = document.forms.updateArchive.file.files[0]
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
    }

    function updateMaterial() {
      return MaterialAPI.update(newMaterial.id, {
        name: file.name,
        mime: file.type,
      })
    }

    function showCurrentWork() {
      return WorkAPI.show(currentWork.id)
    }

    function addWorkToView(response) {
      $scope.works.push(response.data)
      Materialize.toast('A tarefa foi criada', 3000)
    }

    function updateWorkView(response) {
      ManageList.updateItem($scope.works, response.data)
      Materialize.toast('A tarefa foi atualizada', 3000)
    }
  },
])
