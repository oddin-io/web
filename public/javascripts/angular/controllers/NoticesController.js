import oddin from '../app'

oddin.controller('NoticesController',
  ['$scope', '$stateParams', 'InstructionAPI', 'CurrentUser',
    function ($scope, $stateParams, InstructionAPI, CurrentUser) {
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

      (function findNotices() {
        $scope.load = false
        InstructionAPI.getNotices($stateParams.instructionID)
                .then(function (response) {
                  $scope.notices = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar avisos', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())

      $scope.createNotice = function (newNotice) {
        $scope.load = false
        InstructionAPI.createNotice($stateParams.instructionID, newNotice)
                .then(function (response) {
                  $scope.notices.push(response.data)
                  Materialize.toast('Aviso postado', 3000)
                })
                .catch(function () {
                  Materialize.toast('Não foi possível postar o aviso', 3000)
                })
                .finally(function () {
                  delete $scope.newNotice
                  $scope.load = true
                })
      }
    },
  ])
