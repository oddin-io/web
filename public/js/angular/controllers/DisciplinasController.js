angular.module('oddin').controller('DisciplinasController',
  function($scope, Disciplina) {
    function buscaDisciplinas() {
      Disciplina.query(
        function(disciplinas) {
          $scope.disciplinas = disciplinas;
        },
        function(erro) {
          console.log("Não foi possível obter a lista de disciplinas");
          console.log(erro);
        }
      );
    }
    $scope.titulo = "Disciplinas";
    buscaDisciplinas();
  }
);
