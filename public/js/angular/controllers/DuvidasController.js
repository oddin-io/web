angular.module('oddin').controller('DuvidasController',
    function($scope, $stateParams, Duvidas) {
        function buscaAulaInfo() {
            Duvidas.get({id: $stateParams.aulaID}),
                function (data) {
                    $scope.aula = data;
                    buscaDuvidas();
                }
        }

        //Buscar informações da aula, depois buscar dúvidas

        function buscaDuvidas() {
            Duvidas.get({id: $stateParams.aulaID},
                function (data) {
                    $scope.duvidas = data.doubts;
                },
                function (erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.'
                    };
                }
            );
        }
        buscaDuvidas();
    }
);


