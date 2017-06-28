import oddin from '../app'

oddin.controller('AdminLecturesController',
  ['$scope', 'CurrentUser', 'LectureAPI', 'ManageList',
    function ($scope, CurrentUser, LectureAPI, ManageList) {
      $scope.user = CurrentUser;

      (function findLectures() {
        $scope.load = false
        LectureAPI.index()
                .then(function (response) {
                  $scope.lectures = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar disciplinas', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())

      $scope.createLecture = function (newLecture) {
        $scope.load = false
        LectureAPI.create(newLecture)
                .then(function (response) {
                  $scope.lectures.push(response.data)
                  Materialize.toast('Disciplina cadastrada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao cadastrar disciplina', 3000)
                })
                .finally(function () {
                  delete $scope.newLecture
                  $scope.load = true
                })
      }

      $scope.updateLecture = function (modalLecture) {
        $scope.load = false
        LectureAPI.update(modalLecture.id, modalLecture)
                .then(function (response) {
                  ManageList.updateItem($scope.lectures, response.data)
                  Materialize.toast('Disciplina atualizada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao atualizar disciplina', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.deleteLecture = function (modalLecture) {
        $scope.load = false
        LectureAPI.destroy(modalLecture.id)
                .then(function () {
                  ManageList.deleteItem($scope.lectures, modalLecture)
                  Materialize.toast('Disciplina deletada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao excluir disciplina', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.modalEdit = function (lecture) {
        $scope.modalLecture = angular.copy(lecture)
        $('#modal-edit').openModal()
      }

      $scope.modalDelete = function (lecture) {
        $scope.modalLecture = angular.copy(lecture)
        $('#modal-delete').openModal()
      }
    },
  ])
