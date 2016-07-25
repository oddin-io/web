angular.module('oddin').controller('AulasController',
    function($scope, $stateParams, Disciplinas) {
        function buscaAulas() {
            Disciplinas.get({id: $stateParams.disciplinaID},
                function (disciplina) {
                    $scope.disciplina = disciplina;
                    $scope.titulo = disciplina.nome;
                    console.log(disciplina)
                },
                function (erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.'
                    };
                }
            );
        }
        buscaAulas();
    }
);
