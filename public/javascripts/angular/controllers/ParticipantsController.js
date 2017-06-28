import oddin from '../app'

oddin.controller('ParticipantsController',
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

      (function findParticipants() {
        $scope.load = false
        InstructionAPI.getParticipants($stateParams.instructionID)
                .then(function (response) {
                  $scope.participants = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar participantes', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())
    },
  ])
