angular.module('oddin').controller('DisciplinaController',
    function($scope, $stateParams, Disciplina, Aula, Material, Participante) {
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
            Aula.query(
                function (aulas) {
                    $scope.aulas = aulas;
                },
                function (erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.'
                    };
                }
            );
        }
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
        }
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
        }
        buscaInfo();
    }
);
