angular.module('oddin').controller('MateriaisController',
    function($scope, $stateParams, Materiais) {
        function buscaMateriais() {
            Materiais.get({id: $stateParams.disciplinaID},
                function (disciplina) {
                    $scope.materiais = disciplina.materiais;
                    $scope.titulo = disciplina.nome;
                    $scope._id = disciplina._id;
                },
                function (erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.'
                    };
                }
            );
        }
        buscaMateriais();
    }
);
