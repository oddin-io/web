angular.module('oddin').controller('DuvidasController',
    function($scope, $stateParams, Duvidas) {
        function buscaAulaInfo() {

        }
        function buscaDuvidas() {
            Duvidas.get({id: $stateParams.aulaID},
                function(data) {
                    $scope.duvidas = data.doubts;
                },
                function(erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.'
                    };
                }
            );
        }
        buscaDuvidas();
    }
);

    //function($scope, $stateParams, Aulas) {
    //    function buscaAulas() {
    //        Aulas.get({id: $stateParams.disciplinaID},
    //            function (disciplina) {
    //                $scope.aulas = disciplina.aulas;
    //                $scope.titulo = disciplina.nome;
    //                $scope._id = disciplina._id;
    //            },
    //            function (erro) {
    //                $scope.mensagem = {
    //                    texto: 'Não foi possível obter o resultado.'
    //                };
    //            }
    //        );
    //    }
    //    buscaAulas();
    //}

//{
//    "doubts":{
//        "14":{
//            "person":{
//                "id":6,
//                "name":"Eu"
//            },
//            "likes":0,
//            "contributions":0,
//            "like":false,
//            "date":"2016-05-23",
//            "time":"16:31:34",
//            "id":14,
//            "status":0,
//            "text":"oi oi oi!!!",
//            "anonymous":false,
//            "presentationid":1
//        },
//        "5":{
//            "person":{
//                "id":6,
//                "name":"Eu"
//            },
//            "likes":0,
//            "contributions":2,
//            "like":false,
//            "date":"2016-03-21",
//            "time":"15:33:32",
//            "id":5,
//            "status":1,
//            "text":"teste",
//            "anonymous":true,
//            "presentationid":1
//        }
//    }
//}


