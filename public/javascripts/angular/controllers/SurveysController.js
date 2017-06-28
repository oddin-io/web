import oddin from '../app'

oddin.controller('SurveysController', [
  '$scope', '$cookies', '$stateParams',
  'InstructionAPI', 'SurveyAPI', 'AlternativeAPI', 'CurrentUser', 'ManageList',
  function (
        $scope, $cookies, $stateParams,
        InstructionAPI, SurveyAPI, AlternativeAPI, CurrentUser, ManageList
    ) {
    $scope.user = CurrentUser
    $scope.newSurvey = {
      alternatives: [{}],
    };

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

    (function findSurveys() {
      $scope.load = false
      InstructionAPI.getSurveys($stateParams.instructionID)
                .then(function (response) {
                  $scope.surveys = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar Enquetes', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
    }())

    $scope.createSurvey = function (newSurvey) {
      $scope.load = false
      InstructionAPI.createSurvey($stateParams.instructionID, newSurvey)
                .then(function (response) {
                  $scope.surveys.push(response.data)
                  Materialize.toast('Enquete criada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Não foi possível criar a enquete', 3000)
                })
                .finally(function () {
                  $scope.newSurvey = {
                    alternatives: [{}],
                  }
                  $scope.load = true
                })
    }

    $scope.updateSurvey = function (modalSurvey) {
      $scope.load = false
      SurveyAPI.update(modalSurvey.id, modalSurvey)
                .then(function (response) {
                  ManageList.updateItem($scope.surveys, response.data)
                  Materialize.toast('Enquete atualizada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao atualizar Enquete', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
    }

    $scope.deleteSurvey = function (modalSurvey) {
      $scope.load = false
      SurveyAPI.destroy(modalSurvey.id)
                .then(function () {
                  ManageList.deleteItem($scope.surveys, modalSurvey)
                  Materialize.toast('Enquete deletada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao excluir enquete', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
    }

    $scope.closeSurvey = function (modalSurvey) {
      $scope.load = false
      SurveyAPI.close(modalSurvey.id)
                .then(function (response) {
                  ManageList.updateItem($scope.surveys, response.data)
                  Materialize.toast('Enquete encerrada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao encerrar enquete', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
    }

    $scope.makeChoice = function (survey) {
      if (!survey.choice) {
        Materialize.toast('Você deve selecionar uma alternativa antes de votar', 3000)
        return
      }
      $scope.load = false
      AlternativeAPI.choose(survey.choice)
                .then(function (response) {
                  ManageList.updateItem($scope.surveys, response.data)
                  Materialize.toast('Voto realizado com sucesso', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao votar', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
    }

    $scope.addNewAlternative = function (newSurvey) {
      newSurvey.alternatives.push({})
    }

    $scope.removeAlternative = function (newSurvey) {
      var lastItem = newSurvey.alternatives.length - 1
      newSurvey.alternatives.splice(lastItem)
    }

    $scope.displayAnswers = function (survey) {
      if ($('#answers-' + survey.id).css('display') == 'none') {
        $('#answers-' + survey.id).css('display', 'block')
      } else {
        $('#answers-' + survey.id).css('display', 'none')
      }
    }

    $scope.displayAlternativesButton = function (survey) {
      if ($('#answers-' + survey.id).css('display') == 'none') {
        if ($cookies.get('profile') == 0) {
          return 'Ver Alternativas'
        }

        return 'Ver Resultado'
      }

      if ($cookies.get('profile') == 0) {
        return 'Ocultar Alternativas'
      }

      return 'Ocultar Resultado'
    }

    $scope.modalEdit = function (survey) {
      $scope.modalSurvey = angular.copy(survey)
      $('#modal-edit').openModal()
    }

    $scope.modalDelete = function (survey) {
      $scope.modalSurvey = angular.copy(survey)
      $('#modal-delete').openModal()
    }

    $scope.modalClose = function (survey) {
      $scope.modalSurvey = angular.copy(survey)
      $('#modal-close').openModal()
    }
  },
])
