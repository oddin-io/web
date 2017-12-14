import oddin from '../app'

oddin.controller('PresentationRequestController',
  ['$scope', '$stateParams', 'CurrentUser', 'PresentationAPI',
    function ($scope, $stateParams, CurrentUser, PresentationAPI) {
      $scope.user = CurrentUser;

      (function getInfo() {
        $scope.load = false
        PresentationAPI.show($stateParams.presentationID)
                .then(function (response) {
                  $scope.presentation = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar informações da aula', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }());

      $(document).ready(function(){
        $('.tooltipped').tooltip();
         $scope.findRequest($scope.presentationID)
      });

      $scope.findRequest = function () {
        $scope.load = false
        PresentationAPI.getRequests($stateParams.presentationID)
                .then(function (response) {
                  $scope.requests = response.data
                  $scope.requests.false = 0
                  $scope.requests.true = 0

                    for (var index in $scope.requests){
                      if ($scope.requests[index].status == false){
                        $scope.requests.false++
                      } else if ($scope.requests[index].status == true){
                        $scope.requests.true++
                      }
                    }
                })
                .catch(function (err) {
                  console.log(err)
                  Materialize.toast('Erro ao carregar as solicitações de atendimentos', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.createRequest = function () {
        $scope.load = false
        PresentationAPI.createRequest($stateParams.presentationID)
                .then(function (response) {
                  $scope.findRequest($scope.presentationID)
                  Materialize.toast('Solicitação postada', 3000)
                })
                .catch(function (err) {
                  console.log(err)
                  Materialize.toast('Não foi possível postar a solicitação', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.updateRequest = function (request) {
        $scope.load = false
        PresentationAPI.updateRequest(request.id)
                .then(function (response) {
                  $scope.findRequest($scope.presentationID)
                  Materialize.toast('Solicitação atendida', 3000)
                })
                .catch(function (err) {
                  console.log(err)
                  Materialize.toast('Não foi possível registrar o atendimento', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }
    },
  ])
