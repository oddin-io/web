import oddin from '../app'

oddin.controller('AdminEventsController',
  [
    '$scope', 'EventAPI', 'CurrentUser', 'ManageList',
    function ($scope, EventAPI, CurrentUser, ManageList) {
      $scope.user = CurrentUser;

      (function findEvents() {
        $scope.load = false
        EventAPI.index()
                .then(function (response) {
                  $scope.events = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar cursos', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())

      $scope.createEvent = function (newEvent) {
        $scope.load = false
        EventAPI.create(newEvent)
                .then(function (response) {
                  $scope.events.push(response.data)
                  Materialize.toast('Curso cadastrado', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao cadastrar curso', 3000)
                })
                .finally(function () {
                  delete $scope.newEvent
                  $scope.load = true
                })
      }

      $scope.updateEvent = function (modalEvent) {
        $scope.load = false
        EventAPI.update(modalEvent.id, modalEvent)
                .then(function (response) {
                  ManageList.updateItem($scope.events, response.data)
                  Materialize.toast('Curso atualizado', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao atualizar curso', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.deleteEvent = function (modalEvent) {
        $scope.load = false
        EventAPI.destroy(modalEvent.id)
                .then(function () {
                  ManageList.deleteItem($scope.events, modalEvent)
                  Materialize.toast('Curso deletado', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao excluir curso', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.modalEdit = function (event) {
        $scope.modalEvent = angular.copy(event)
        $('#modal-edit').openModal()
      }

      $scope.modalDelete = function (event) {
        $scope.modalEvent = angular.copy(event)
        $('#modal-delete').openModal()
      }
    },
  ])
