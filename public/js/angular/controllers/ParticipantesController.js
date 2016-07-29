angular.module('oddin').controller('ParticipantesController',
    function($scope, $stateParams, Participantes) {
        function buscaParticipantes() {
            Participantes.get({id: $stateParams.disciplinaID},
                function (disciplina) {
                    $scope.participantes = disciplina.participantes;
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
        buscaParticipantes();
    }
);