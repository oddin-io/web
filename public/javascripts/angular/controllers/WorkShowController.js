import oddin from '../app'

oddin.controller('WorkShowController',
  ['$scope', '$stateParams', '$http', '$q',
    'CurrentUser', 'WorkAPI', 'MaterialAPI', 'SubmissionAPI',
    function WorkShowController(
        $scope, $stateParams, $http, $q,
        CurrentUser, WorkAPI, MaterialAPI, SubmissionAPI
    ) {
      $scope.user = CurrentUser;

      (function getInfo() {
        $scope.load = false
        WorkAPI.show($stateParams.workID)
                .then(function (response) {
                  $scope.work = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar informações da tarefa', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }());

      (function findSubmissions() {
        $scope.load = false
        WorkAPI.getSubmissions($stateParams.workID)
                .then(function (response) {
                  var i = 0
                  $scope.submissions = response.data

                  for (i = 0; i < $scope.submissions.length; i++) {
                    if ($scope.submissions[i].person.id === $scope.user.id) {
                      $scope.mySubmission = $scope.submissions[i]
                      break
                    }
                  }
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar trabalhos', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())

      $scope.createSubmission = function (newSubmission) {
        $scope.load = false
        if (document.forms.uploadArchive.file.files[0]) {
          WorkAPI.createSubmission($stateParams.workID, newSubmission)
                    .then(setCurrentSubmission)
                    .then(createSubmissionMaterial)
                    .then(uploadFile)
                    .then(updateMaterial)
                    .then(showCurrentSubmission)
                    .then(addSubmissionToView)
                    .catch(function () {
                      Materialize.toast('Erro ao postar trabalho', 3000)
                    })
                    .finally(function () {
                      document.getElementById('new-submission-file').value = ''
                      delete $scope.newSubmission
                      $scope.load = true
                    })
          return
        }
        WorkAPI.createSubmission($stateParams.workID, newSubmission)
                .then(addSubmissionToView)
                .catch(function () {
                  Materialize.toast('Erro ao postar trabalho', 3000)
                })
                .finally(function () {
                  delete $scope.newSubmission
                  $scope.load = true
                })
      }

      $scope.updateSubmission = function (modalMySubmission) {
        $scope.load = false

        if (modalMySubmission.materials.length > 0 && document.forms.updateArchive.file.files[0]) {
          SubmissionAPI.update(modalMySubmission.id, modalMySubmission)
                    .then(setCurrentSubmission)
                    .then(destroySubmissionMaterial)
                    .then(createSubmissionMaterial)
                    .then(updateFile)
                    .then(updateMaterial)
                    .then(showCurrentSubmission)
                    .then(updateSubmissionView)
                    .catch(function () {
                      Materialize.toast('Erro ao atualizar trabalho', 3000)
                    })
                    .finally(function () {
                      $scope.load = true
                    })
          return
        }
        if (modalMySubmission.materials.length > 0 && !document.forms.updateArchive.file.files[0]) {
          SubmissionAPI.update(modalMySubmission.id, modalMySubmission)
                    .then(setCurrentSubmission)
                    .then(destroySubmissionMaterial)
                    .then(showCurrentSubmission)
                    .then(updateSubmissionView)
                    .catch(function () {
                      Materialize.toast('Erro ao atualizar trabalho', 3000)
                    })
                    .finally(function () {
                      $scope.load = true
                    })
          return
        }
        if (modalMySubmission.materials.length === 0 &&
                document.forms.updateArchive.file.files[0]
            ) {
          SubmissionAPI.update(modalMySubmission.id, modalMySubmission)
                    .then(setCurrentSubmission)
                    .then(createSubmissionMaterial)
                    .then(updateFile)
                    .then(updateMaterial)
                    .then(showCurrentSubmission)
                    .then(updateSubmissionView)
                    .catch(function () {
                      Materialize.toast('Erro ao atualizar trabalho', 3000)
                    })
                    .finally(function () {
                      $scope.load = true
                    })
          return
        }
        SubmissionAPI.update(modalMySubmission.id, modalMySubmission)
                .then(updateSubmissionView)
                .catch(function () {
                  Materialize.toast('Erro ao atualizar trabalho', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.deleteSubmission = function (modalMySubmission) {
        $scope.load = false
        SubmissionAPI.destroy(modalMySubmission.id)
                .then(function () {
                  if (modalMySubmission.materials.length > 0) {
                    MaterialAPI.destroy(modalMySubmission.materials[0].id)
                            .then(function () {
                              delete $scope.mySubmission
                              Materialize.toast('Trabalho deletado', 3000)
                            })
                            .catch(function () {
                              Materialize.toast('Erro ao deletar trabalho', 3000)
                            })
                    return
                  }
                  delete $scope.mySubmission
                  Materialize.toast('Trabalho deletado', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao deletar trabalho', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.downloadSubmission = function (submission) {
        $scope.load = false
        MaterialAPI.show(submission.materials[0].id)
                .then(function (response) {
                  var hiddenLink = document.getElementById('hidden-link')
                  var link = document.createElement('a')

                  link.setAttribute('href', response.data.url)
                  link.setAttribute('download', true)
                  hiddenLink.appendChild(link)
                  link.click()
                  hiddenLink.removeChild(link)

                  Materialize.toast('Baixando trabalho: ' + submission.materials[0].name, 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao baixar trabalho', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.modalDelete = function (mySubmission) {
        $scope.modalMySubmission = angular.copy(mySubmission)
        $('#modal-delete').openModal()
      }

      $scope.modalEdit = function (mySubmission) {
        $scope.modalMySubmission = angular.copy(mySubmission)
        if (mySubmission.materials[0]) {
          $scope.modalMySubmission.materialName = mySubmission.materials[0].name
        }
        $('#modal-edit').openModal()
      }

        // File Upload Auxiliar Functions
      function setCurrentSubmission(response) {
        currentSubmission = response.data
        var deferred = $q.defer()
        if (true) {
          deferred.resolve()
        } else {
          deferred.reject()
        }
        return deferred.promise
      }

      function destroySubmissionMaterial() {
        return MaterialAPI.destroy(currentSubmission.materials[0].id)
      }

      function createSubmissionMaterial() {
        return SubmissionAPI.createMaterial(currentSubmission.id)
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

      function showCurrentSubmission() {
        return SubmissionAPI.show(currentSubmission.id)
      }

      function addSubmissionToView(response) {
        $scope.mySubmission = response.data
        Materialize.toast('Trabalho postado', 3000)
      }

      function updateSubmissionView(response) {
        $scope.mySubmission = response.data
        Materialize.toast('O trabalho foi atualizado', 3000)
      }
    },
  ])
