angular.module('oddin').controller('AulaController',
  function($scope, $stateParams, Aula, Duvida) {
    function buscaInfo() {
      Aula.get({id: $stateParams.aulaID},
        function(aula) {
          $scope.aula = aula;
        },
        function(erro) {
          $scope.mensagem = {texto: "Não foi possível obter o resultado."};
        }
      );
    }
    $scope.buscaDuvidas = function (){
      Duvida.query({id: $stateParams.aulaID},
        function (duvidas) {
          $scope.duvidas = duvidas;
        },
        function (erro) {
          $scope.mensagem = {
            texto: 'Não foi possível obter o resultado.'
          };
        }
      );
    };
    buscaInfo();
  }
);
