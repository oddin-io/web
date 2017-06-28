import oddin from '../app'

oddin.controller('FAQsController',
  [
    '$scope', '$stateParams', 'InstructionAPI', 'FaqAPI', 'CurrentUser', 'ManageList',
    function ($scope, $stateParams, InstructionAPI, FaqAPI, CurrentUser, ManageList) {
      $scope.user = CurrentUser
      $scope.answerButtonText = 'Ver Resposta';

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

      (function findFAQs() {
        $scope.load = false
        InstructionAPI.getFAQs($stateParams.instructionID)
                .then(function (response) {
                  $scope.faqs = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar FAQs', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())

      $scope.createFAQ = function (newFAQ) {
        $scope.load = false
        InstructionAPI.createFAQ($stateParams.instructionID, newFAQ)
                .then(function (response) {
                  $scope.faqs.push(response.data)
                  Materialize.toast('FAQ postada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Não foi possível postar a FAQ', 3000)
                })
                .finally(function () {
                  delete $scope.newFAQ
                  $scope.load = true
                })
      }

      $scope.updateFAQ = function (modalFAQ) {
        $scope.load = false
        FaqAPI.update(modalFAQ.id, modalFAQ)
                .then(function (response) {
                  ManageList.updateItem($scope.faqs, response.data)
                  Materialize.toast('FAQ atualizada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao atualizar FAQ', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.deleteFAQ = function (modalFAQ) {
        $scope.load = false
        FaqAPI.destroy(modalFAQ.id)
                .then(function () {
                  ManageList.deleteItem($scope.faqs, modalFAQ)
                  Materialize.toast('FAQ deletada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao excluir FAQ', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.displayAnswer = function (faq) {
        if ($('#answer-' + faq.id).css('display') == 'none') {
          $('#answer-' + faq.id).css('display', 'block')
          $scope.answerButtonText = 'Ocultar Resposta'
        } else {
          $('#answer-' + faq.id).css('display', 'none')
          $scope.answerButtonText = 'Ver Resposta'
        }
      }

      $scope.modalEdit = function (faq) {
        $scope.modalFAQ = angular.copy(faq)
        $('#modal-edit').openModal()
      }

      $scope.modalDelete = function (faq) {
        $scope.modalFAQ = angular.copy(faq)
        $('#modal-delete').openModal()
      }
    },
  ])
