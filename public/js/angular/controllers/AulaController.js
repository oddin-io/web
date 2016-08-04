angular.module('oddin').controller('AulaController',
  function($scope, $stateParams, Aula, Duvida) {
    $scope.duvidas = {};

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

    function addDuvida(duvida) {
        $scope.duvidas[duvida.id] = duvida;
    }

    function removeDuvida(duvida) {
        $scope.duvidas[duvida.id] = duvida;
    }

    $scope.buscaDuvidas = function (){
      Duvida.query({id: $stateParams.aulaID},
        function (duvidas) {
          duvidas.forEach(function (elem) {
              addDuvida(elem)
          });
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
