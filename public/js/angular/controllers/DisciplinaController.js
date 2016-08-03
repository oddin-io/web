angular.module('oddin').controller('DisciplinaController',
  function($scope, $stateParams, Disciplina, DisciplinaAula, Material, Participante, Profile, $state) {
    // $state.go('materiais');
    function buscaInfo() {
      Disciplina.get({id: $stateParams.disciplinaID},
        function(disciplina) {
          $scope.disciplina = disciplina;
        },
        function(erro) {
          $scope.mensagem = {texto: "Não foi possível obter o resultado."};
        }
      );
    }

    $scope.buscaAulas = function() {
      DisciplinaAula.query({id: $stateParams.disciplinaID},
        function (aulas) {
          $scope.aulas = aulas;
        },
        function (erro) {
          $scope.mensagem = {
            texto: 'Não foi possível obter o resultado.'
          };
        }
      );
    };
    $scope.buscaParticipantes = function() {
      Participante.query({id: $stateParams.disciplinaID},
        function (participantes) {
          $scope.participantes = participantes;
        },
        function (erro) {
          $scope.mensagem = {
            texto: 'Não foi possível obter o resultado.'
          };
        }
      );
    };
    $scope.buscaMateriais = function() {
      Material.query(
        function (materiais) {
          $scope.materiais = materiais;
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
