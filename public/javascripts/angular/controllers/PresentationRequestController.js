import oddin from '../app'

oddin.controller('PresentationRequestController',
  ['$scope', '$stateParams', '$http', 'CurrentUser', 'PresentationAPI', 'ManageList',
    function ($scope, $stateParams, $http, CurrentUser, PresentationAPI, ManageList) {
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
                  console.log($scope.requests)
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
                  console.log(response)
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
    },
  ])
