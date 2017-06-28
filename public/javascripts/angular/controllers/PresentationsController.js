import oddin from '../app'

oddin.controller('PresentationsController',
  ['$scope', '$stateParams', 'InstructionAPI', 'PresentationAPI', 'CurrentUser', 'ManageList',
    function ($scope, $stateParams, InstructionAPI, PresentationAPI, CurrentUser, ManageList) {
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

      (function findPresentations() {
        $scope.load = false
        InstructionAPI.getPresentations($stateParams.instructionID)
                .then(function (response) {
                  $scope.presentations = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar aulas', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())

      $scope.createPresentation = function (newPresentation) {
        $scope.load = false
        InstructionAPI.createPresentation($stateParams.instructionID, newPresentation)
                .then(function (response) {
                  $scope.presentations.push(response.data)
                  Materialize.toast('A aula ' + newPresentation.subject + ' foi criada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Não foi possível criar uma nova aula', 3000)
                })
                .finally(function () {
                  delete $scope.newPresentation
                  $scope.load = true
                })
      }

      $scope.closePresentation = function (modalPresentation) {
        $scope.load = false
        PresentationAPI.close(modalPresentation.id)
                .then(function (response) {
                  ManageList.updateItem($scope.presentations, response.data)
                  Materialize.toast(
                    "A aula '" + modalPresentation.subject + "' foi finalizada", 3000
                  )
                })
                .catch(function () {
                  Materialize.toast('Erro ao finalizar aula', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.modalClose = function (presentation) {
        $scope.modalPresentation = angular.copy(presentation)
        $('#modal-close').openModal()
      }
    },
  ])
