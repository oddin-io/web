import oddin from '../app'
oddin.controller('StudentTestsController',
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
    },
  ])
