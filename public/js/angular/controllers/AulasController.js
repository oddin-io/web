angular.module('oddin').controller('AulasController',
    function($scope, $stateParams, Disciplinas) {
        Disciplinas.get({id: $stateParams.disciplinaID},
            function (disciplina) {
                $scope.disciplina = disciplina;
                console.log(disciplina)
            },
            function (erro) {
                $scope.mensagem = {
                    texto: 'Não foi possível obter o resultado.'
                };
            }
        );
        $scope.titulo = "Aulas";
    }
);
