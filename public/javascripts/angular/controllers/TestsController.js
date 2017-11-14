import oddin from '../app'
oddin.controller('TestsController',
  ['$scope', '$stateParams', '$state', '$filter', 'InstructionAPI', 'CurrentUser', 'TestQuestionAPI','TestAPI','ManageList',
    function ($scope, $stateParams, $state, $filter, InstructionAPI, CurrentUser, TestQuestionAPI, TestAPI, ManageList) {
      $scope.user = CurrentUser
      $scope.newTest = {
        questions: [{
          alternatives: [{}],
        }],
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

      (function findTests() {
        $scope.load = false
        InstructionAPI.getTests($stateParams.instructionID)
                  .then(function (response) {
                    $scope.tests = response.data
                  })
                  .catch(function () {
                    Materialize.toast('Erro ao carregar Testes', 3000)
                  })
                  .finally(function () {
                    $scope.load = true
                  })
      }());

      $scope.addNewTooltip = function(){
        setTimeout(function(){
            $('.tooltipped').tooltip();
        },200);
      };

      $(document).ready(function(){
        $('.tooltipped').tooltip();
        $('.materialize-textarea').characterCounter();
      });

      $scope.addNewQuestion = function () {
        $scope.newTest.questions.push(angular.copy({}));
        $scope.addNewTooltip();
      }

      $scope.removeQuestion = function (questionPosition) {
        $scope.newTest.questions.splice(questionPosition, 1);
      }

      $scope.addNewAlternative = function (questionPosition) {
        if ($scope.newTest.questions[questionPosition].alternatives == undefined) {
          $scope.newTest.questions[questionPosition].alternatives = []
        }
        if ($scope.newTest.questions[questionPosition].alternatives != undefined) {
          $scope.newTest.questions[questionPosition].alternatives.push(angular.copy({}))
        }
      }

      $scope.removeAlternative = function (questionPosition) {
        var lastItem = $scope.newTest.questions[questionPosition].alternatives.length - 1

        $scope.newTest.questions[questionPosition].alternatives.splice(lastItem)
      }

      $scope.dissertativeQuestion = function (questionPosition) {
        var value = $('#kind-question-' + questionPosition).prop('checked')

        switch (value) {
          case true:
            return true
          case false:
            $scope.addNewTooltip();
            return false
        }
      }

      $scope.createTest = function (newTest) {
        
        try {
          var date_available = $filter('toDate')(newTest.date_available)
          var available_at = $filter('toDate')(newTest.date_available, newTest.available_at)
          var closes_at = $filter('toDate')(newTest.date_available, newTest.closes_at)
          
          newTest.date_available = date_available
          newTest.available_at = available_at
          newTest.closes_at = closes_at
        }
        catch(err) {
          Materialize.toast('Insira a data e os horários corretamente', 5000)
          throw err
        }

        try {
          for (var questionIndex = 0; questionIndex < $scope.newTest.questions.length; questionIndex++) {
            newTest.questions[questionIndex].number = questionIndex + 1

            if(!$scope.dissertativeQuestion(questionIndex)) {
              newTest.questions[questionIndex].kind = false

              for (var alternativeIndex = 0; alternativeIndex < $scope.newTest.questions[questionIndex].alternatives.length; alternativeIndex++) {

                var value = new Boolean($('#radio-question-'+ questionIndex + "-alternative-" + alternativeIndex).is(':checked'))

                if(value == true)
                  newTest.questions[questionIndex].alternatives[alternativeIndex].correct = true
                else
                  newTest.questions[questionIndex].alternatives[alternativeIndex].correct = false
              }
            }
            else {
              newTest.questions[questionIndex].kind = true
            }
          }
        }
        catch(err) {
          Materialize.toast('Preencha todos os campos corretamente', 5000)
        }

        $scope.load = false
        InstructionAPI.createTest($stateParams.instructionID, newTest)
          .then(function(response){        
              TestQuestionAPI.create(response.data.id, newTest)
                .then(function(){
                  $scope.tests.push(response.data)
                  Materialize.toast('Teste criado', 3000)
                })
                .catch(function(){
                  TestAPI.destroy(response.data.id)
                  Materialize.toast('Erro ao criar as questões. Teste não criado', 3000)
                })
          })
          .catch(function(){
            Materialize.toast('Não foi possível criar o teste ', 3000)
          })
          .finally(function(){
            $scope.newTest = {
              questions: [{
                alternatives: [{}],
              }],
            };
            $scope.load = true
          })
      }

      $scope.updateSurvey = function (modalTest) {

        try {
          var date_available = $filter('toDate')(modalTest.date_available)
          var available_at = $filter('toDate')(modalTest.date_available, modalTest.available_at)
          var closes_at = $filter('toDate')(modalTest.date_available, modalTest.closes_at)
          
          modalTest.date_available = date_available
          modalTest.available_at = available_at
          modalTest.closes_at = closes_at
        }
        catch(err) {
          Materialize.toast('Insira a data e os horários corretamente', 5000)
          throw err
        }

        try {
          for (var questionIndex = 0; questionIndex < modalTest.questions.length; questionIndex++) {
              for (var alternativeIndex = 0; alternativeIndex < $scope.modalTest.questions[questionIndex].test_alternatives.length; alternativeIndex++) {
                var value = new Boolean($('#modal-radio-question-'+ questionIndex + "-alternative-" + alternativeIndex).is(':checked'))
                if(value == true)
                  modalTest.questions[questionIndex].test_alternatives[alternativeIndex].correct = true
                else
                  modalTest.questions[questionIndex].test_alternatives[alternativeIndex].correct = false
            }
          }
        }
        catch(err) {
          Materialize.toast('Preencha todos os campos corretamente', 5000)
        }

        $scope.load = false
        TestAPI.update(modalTest.id, modalTest)
          .then(function(response){
              ManageList.updateItem($scope.tests, response.data)       
              TestQuestionAPI.update(response.data.id, modalTest)
                .then(function(response){   
                  ManageList.updateItem($scope.modalTest.questions, response.data)
                  Materialize.toast('Teste atualizado', 3000)
                })
                .catch(function(err){
                  console.log(err)
                  Materialize.toast('Erro ao atualizar as questões', 3000)
                })
          })
          .catch(function(err){
            console.log(err)
            Materialize.toast('Erro ao atualizar o teste ', 3000)
          })
          .finally(function(){
            $scope.load = true
          })
      }

      $scope.deleteTest = function (modalTest) {
        $scope.load = false
        TestAPI.destroy(modalTest.id)
                .then(function () {
                  ManageList.deleteItem($scope.tests, modalTest)
                  Materialize.toast('Teste deletado', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao excluir teste', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.modalDelete = function (test) {
        $scope.modalTest = angular.copy(test)
        $('#modal-delete').openModal()
      }

      $scope.modalEdit = function (test) {
        $scope.modalTest = angular.copy(test)
        $scope.modalTest.date_available = $filter('date')($scope.modalTest.date_available,'ddMMyyyy')
        $scope.modalTest.available_at = $filter('date')($scope.modalTest.available_at, 'HHmm')
        $scope.modalTest.closes_at = $filter('date')($scope.modalTest.closes_at, 'HHmm')
        TestAPI.getQuestions($scope.modalTest.id)
          .then(function(response){
            $scope.modalTest.questions = response.data
              setTimeout(function(){
                for (var questionIndex = 0; questionIndex < $scope.modalTest.questions.length; questionIndex++) {
                  for (var alternativeIndex = 0; alternativeIndex < $scope.modalTest.questions[questionIndex].test_alternatives.length; alternativeIndex++) {
                    if($scope.modalTest.questions[questionIndex].test_alternatives[alternativeIndex].correct === true) {
                      $('#modal-radio-question-'+ questionIndex + "-alternative-" + alternativeIndex).attr('checked', true);                       
                    }
                  }
                }
              },700);
          })
        $('#modal-edit').openModal()
      }
    },
  ])
