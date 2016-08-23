oddin.controller('DisciplinasController',
  function($scope, Disciplina, $cookies) {
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

    $scope.usuario = {
        'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
        'email': JSON.parse($cookies.get('session').substring(2)).user.email
    }

    $scope.titulo = "Disciplinas";
    buscaDisciplinas();
  }
);
