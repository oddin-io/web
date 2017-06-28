import oddin from '../app'

oddin.controller('AdminInstructionShowController',
  [
    '$scope', '$stateParams',
    'CurrentUser', 'InstructionAPI', 'PersonAPI', 'EnrollAPI', 'ManageList',
    function (
      $scope, $stateParams,
      CurrentUser, InstructionAPI, PersonAPI, EnrollAPI, ManageList
    ) {
      $scope.user = CurrentUser;

      (function getInfo() {
        InstructionAPI.show($stateParams.instructionID)
                .then(function (response) {
                  $scope.instruction = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar informações da disciplina', 3000)
                })
      }())

      $scope.findParticipants = function () {
        $scope.load = false
        InstructionAPI.getParticipants($stateParams.instructionID)
                .then(function (response) {
                  $scope.participants = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar participantes da disciplina', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.findAvailableParticipants = function () {
        $scope.load = false
        PersonAPI.index()
                .then(function (response) {
                  $scope.registeredUsers = response.data
                  return InstructionAPI.getParticipants($stateParams.instructionID)
                })
                .then(function (response) {
                  $scope.participants = response.data
                  $scope.availableUsers = $scope.registeredUsers.filter(function (registeredUser) {
                    var _index = $scope.participants.findIndex(function (participant) {
                      return participant.person.id == registeredUser.id
                    })

                    if (_index < 0) {
                      return true
                    }
                  })
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar usuários cadastrados', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.createEnroll = function (availableUser) {
        var _enroll = {
          person_id: availableUser.id,
          instruction_id: $stateParams.instructionID,
          profile: availableUser.enrollProfile ? 1 : 0,
        }

        $scope.load = false

        EnrollAPI.create(_enroll)
                .then(function (response) {
                  $scope.participants.push(response.data)
                  ManageList.deleteItem($scope.availableUsers, response.data.person)
                  Materialize.toast('Usuário cadastrado', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao adicionar usuário', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.deleteEnroll = function (modalParticipant) {
        $scope.load = false
        EnrollAPI.destroy(modalParticipant.id)
                .then(function () {
                  ManageList.deleteItem($scope.participants, modalParticipant)
                  if ($scope.availableUsers) {
                    $scope.availableUsers.push(modalParticipant.person)
                  }
                  Materialize.toast('Usuário removido', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao remover usuário', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.modalRemove = function (participant) {
        $scope.modalParticipant = angular.copy(participant)
        $('#modal-remove').openModal()
      }
    },
  ])
