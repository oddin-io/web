import oddin from '../app'
oddin.controller('StudentTestsController',
  ['$scope', '$stateParams', '$state', '$filter', 'TestResponseAPI', 'InstructionAPI', 'CurrentUser', 'TestQuestionAPI','TestAPI','ManageList',
    function ($scope, $stateParams, $state, $filter, TestResponseAPI, InstructionAPI, CurrentUser, TestQuestionAPI, TestAPI, ManageList) {
      $scope.user = CurrentUser;

      (function findTest() {
        $scope.load = false
        TestAPI.show($stateParams.testID)
                  .then(function (response) {
                    $scope.test = response.data
                    $scope.test.date_available = $filter('date')($scope.test.date_available,'ddMMyyyy')
                    $scope.test.available_at = $filter('date')($scope.test.available_at, 'HHmm')
                    $scope.test.closes_at = $filter('date')($scope.test.closes_at, 'HHmm')
                    TestAPI.getQuestions($stateParams.testID)
                        .then(function(response){
                          $scope.test.questions = response.data
                          /*$scope.answerTest = new Object()
                          $scope.answerTest.questions = []

                          for (var questionIndex = 0; questionIndex < $scope.test.questions.length; questionIndex++) {                                    
                            $scope.answerTest.questions.push(angular.copy({}));

                            if($scope.test.questions[questionIndex].test_alternatives.length > 0)
                              $scope.answerTest.questions[questionIndex].alternative = new Object()
                          }
                          console.log("SCOPE.answerTest -> ",$scope.answerTest)*/
                        })
                        .catch(function(err){
                          console.log(err)
                          Materialize.toast('Erro ao carregar as questões',3000)
                        })
                  })
                  .catch(function () {
                    Materialize.toast('Erro ao carregar o teste', 3000)
                  })
                  .finally(function () {
                    $scope.load = true
                  })
      }());
      //$state.go('test-student',{instructionID: $stateParams.instructionID, testID: test.id})

      $scope.createTestResponse = function(test) {

        
        for (var questionIndex = 0; questionIndex < $scope.test.questions.length; questionIndex++) {
                    
          if(test.questions[questionIndex].test_alternatives != undefined) {
          
            for (var alternativeIndex = 0; alternativeIndex < $scope.test.questions[questionIndex].test_alternatives.length; alternativeIndex++) {
            
              var value = new Boolean($('#radio-question-'+ questionIndex + "-alternative-" + alternativeIndex).is(':checked'))

              if(value == true)
                test.questions[questionIndex].test_alternatives[alternativeIndex].choice = $scope.test.questions[questionIndex].test_alternatives[alternativeIndex].id
            }
          }
        }
        TestResponseAPI.create($scope.test.id, test)
          .then(function(response){
            console.log("Deu certo! response-> ",response.data)
          })
          .catch(function(err){
            console.log("Não deu! erro-> ",err.data)
          })

        console.log("Click -> ",test)
      }
    },
  ])