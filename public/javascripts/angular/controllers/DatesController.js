import oddin from '../app'

oddin.controller('DatesController',
  [
    '$scope', '$stateParams', '$filter',
    'DateAPI', 'InstructionAPI', 'CurrentUser', 'ManageList',
    function (
      $scope, $stateParams, $filter,
      DateAPI, InstructionAPI, CurrentUser, ManageList
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

      (function findDates() {
        $scope.load = false
        InstructionAPI.getDates($stateParams.instructionID)
                .then(function (response) {
                  $scope.dates = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar datas importantes', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())

      $scope.createDate = function (newDate) {
        $scope.load = false
        newDate.date = $filter('toDate')(newDate.date, newDate.time)
        InstructionAPI.createDate($stateParams.instructionID, newDate)
                .then(function (response) {
                  $scope.dates.push(response.data)
                  Materialize.toast('Data cadastrada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao cadastrar data', 3000)
                })
                .finally(function () {
                  delete $scope.newDate
                  $scope.load = true
                })
      }

      $scope.updateDate = function (modalDate) {
        $scope.load = false
        modalDate.date = $filter('toDate')(modalDate.date, modalDate.time)
        DateAPI.update(modalDate.id, modalDate)
                .then(function (response) {
                  ManageList.updateItem($scope.dates, response.data)
                  Materialize.toast('Data atualizada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao atualizar data', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.deleteDate = function (modalDate) {
        $scope.load = false
        DateAPI.destroy(modalDate.id)
                .then(function () {
                  ManageList.deleteItem($scope.dates, modalDate)
                  Materialize.toast('Data deletada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao excluir data', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.modalEdit = function (date) {
        $scope.modalDate = angular.copy(date)
        $scope.modalDate.time = $filter('date')($scope.modalDate.date, 'HHmm')
        $scope.modalDate.date = $filter('date')($scope.modalDate.date, 'ddMMyyyy')
        $('#modal-edit').openModal()
      }

      $scope.modalDelete = function (date) {
        $scope.modalDate = angular.copy(date)
        $('#modal-delete').openModal()
      }
    },
  ])
