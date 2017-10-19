import oddin from '../app'

oddin.controller('TestsController',
  ['$scope', '$stateParams', '$filter', 'InstructionAPI', 'CurrentUser', 'TestQuestionAPI','TestAPI',
    function ($scope, $stateParams, $filter, InstructionAPI, CurrentUser, TestQuestionAPI, TestAPI) {
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
      }())

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

      $scope.correctAlternative = function (newTest, questionPosition, alternativePosition) {
        var value = $('#radio-question-'+ questionPosition + "-alternative-" + alternativePosition).prop('checked')

        newTest.questions[questionPosition-1].alternatives[alternativePosition-1].correct = true
      }

      $scope.testando = function(newTest) {

        console.log("Data disponível: " + newTest.date_available)
        console.log("À partir: " + newTest.available_at)
        console.log("Encerra às: " + newTest.closes_at)

        for (var questionIndex = 0; questionIndex < $scope.newTest.questions.length; questionIndex++) {
          newTest.questions[questionIndex].number = questionIndex + 1

          console.log("Número da Questão: " + newTest.questions[questionIndex].number)
          console.log("Descrição da Questão: " + newTest.questions[questionIndex].description)
          console.log("Nota: " + newTest.questions[questionIndex].value)

          if(!$scope.dissertativeQuestion(questionIndex)) {
            newTest.questions[questionIndex].kind = false

            for (var alternativeIndex = 0; alternativeIndex < $scope.newTest.questions[questionIndex].alternatives.length; alternativeIndex++) {
              console.log("Texto: " + newTest.questions[questionIndex].alternatives[alternativeIndex].text)

              if(!newTest.questions[questionIndex].alternatives[alternativeIndex].correct)
                newTest.questions[questionIndex].alternatives[alternativeIndex].correct = false

              console.log("É a correta: " + newTest.questions[questionIndex].alternatives[alternativeIndex].correct)
            }
          }
          else {
            newTest.questions[questionIndex].kind = true
            console.log("Resposta: " + newTest.questions[questionIndex].answer)
          }
          console.log("Dissertativa: " + newTest.questions[questionIndex].kind)
          console.log("Comentário: " + newTest.questions[questionIndex].comment)
        }
      }

      $scope.createTest = function (newTest) {
        
        var questions = new Object()
        questions.alternatives = new Object()

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
        }

        try {
          for (var questionIndex = 0; questionIndex < $scope.newTest.questions.length; questionIndex++) {
            newTest.questions[questionIndex].number = questionIndex + 1

            if(!$scope.dissertativeQuestion(questionIndex)) {
              newTest.questions[questionIndex].kind = false     

              questions.number = newTest.questions[questionIndex].number
              questions.kind = newTest.questions[questionIndex].kind
              questions.description = newTest.questions[questionIndex].description
              questions.answer = newTest.questions[questionIndex].answer
              questions.value = newTest.questions[questionIndex].value
              questions.comment = newTest.questions[questionIndex].comment
              
              for (var alternativeIndex = 0; alternativeIndex < $scope.newTest.questions[questionIndex].alternatives.length; alternativeIndex++) {

                if(!newTest.questions[questionIndex].alternatives[alternativeIndex].correct)
                  newTest.questions[questionIndex].alternatives[alternativeIndex].correct = false          

                questions.alternatives.text = newTest.questions[questionIndex].alternatives[alternativeIndex].text
                questions.alternatives.correct = newTest.questions[questionIndex].alternatives[alternativeIndex].correct
              }
            }
            else {
              newTest.questions[questionIndex].kind = true
            }
          }
        }
        catch(err) {
          Materialize.toast('Insira os dados corretamente', 5000)
        }

        $scope.load = false
        InstructionAPI.createTest($stateParams.instructionID, newTest)
                  .then(function () {
                    InstructionAPI.getTests($stateParams.instructionID)
                        .then(function (response) {
                          var testID = response.data.pop().id
                          TestQuestionAPI.create(testID, questions)
                            .then(function(){
                              Materialize.toast('Teste criado', 3000)
                            })
                            .catch(function () {
                              Materialize.toast('Não foi possível criar o teste (2)', 3000)
                            })
                        })
                  })
                  .catch(function () {
                    Materialize.toast('Não foi possível criar o teste', 3000)
                  })
                  .finally(function () {
                    $scope.newTest = {
                      questions: [{
                        alternatives: [{}],
                      }],
                    };
                    $scope.load = true
                  })
      }
    },
  ])
