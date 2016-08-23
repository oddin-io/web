oddin.controller('AulaController',
    function($scope, $stateParams, Aula, Duvida, Resposta, $http, $cookies) {
        $scope.duvidas = {};
        $scope.duvida = new Duvida();
        $scope.last_doubt = {};
        function buscaInfo() {
            Aula.get({id: $stateParams.aulaID},
                function(aula) {
                    $scope.aula = aula;
                },
                function(erro) {
                    $scope.mensagem = {texto: "Não foi possível obter o resultado."};
                }
            );
        }

        function addDuvida(duvida) {
            $scope.duvidas[duvida.id] = duvida;
        }

        function removeDuvida(duvida) {
            $scope.duvidas[duvida.id] = duvida;
        }

        $scope.buscaMateriais = function() {
            $http.get('/api/presentation/' + $stateParams.aulaID + '/materials')
                .success(function(data) {
                    $scope.materiais = data;
                })
        };

        $scope.uploadMaterial = function() {
            var file = document.forms.uploadArchive.file.files[0];
            var fd = new FormData();
            $http.get('api/presentation/' + $stateParams.aulaID + "/materials/new")
                .success(function(data) {
                    for (var key in data.fields) {
                        fd.append(key, data.fields[key]);
                    }
                    fd.append('file', file);
                    $http.post(data.url, fd, {headers: {'Content-Type': undefined}})
                        .success(function() {
                            $http.put('api/materials/' + data.id, {'name':file.name, 'mime': file.type})
                                .success(function() {
                                    console.log('Upload Realizado');
                                    $scope.buscaMateriais();
                                })
                        });
                })
        }

        $scope.downloadMaterial = function(material) {
            $http.get('api/materials/' + material.id)
                .success(function(data) {
                    var link = document.createElement('a');
                    link.setAttribute('href', data.url);
                    link.setAttribute('download', true);
                    link.click();
                });
        }

        $scope.setLastDoubt = function(duvida) {
            $scope.last_doubt = duvida;
        }

        $scope.buscaDuvidas = function () {
            Duvida.query({id: $stateParams.aulaID},
                function (duvidas) {
                    duvidas.forEach(function (elem) {
                        addDuvida(elem)
                    });
                },
                function (erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.'
                    };
                }
            );
        };

        $scope.postaDuvida = function() {
            if($scope.duvida.anonymous === undefined) $scope.duvida.anonymous = false;
            $scope.duvida.$save({id: $stateParams.aulaID})
                .then(function(data) {
                    addDuvida(data);
                    $scope.duvida = new Duvida();
                })
                .catch(function(erro) {
                    $scope.mensagem = {texto: 'Não foi possível postar a dúvida'};
                    $scope.duvida = new Duvida();
                });
        }

        $scope.buscaRespostas = function (duvida) {
            if(duvida.answers == undefined) {
                duvida.answers = [];
            }
            if(duvida.answers.length == 0) {
                $http.get("/api/questions/" + duvida.id + "/answers").success(function (data) {
                    duvida.answers = data;
                });
            }
            else {
                duvida.answers = [];
            }
        };

        $scope.postaResposta = function() {
            $http.post("/api/questions/" + $scope.last_doubt.id + "/answers", $scope.resposta).success(function(data) {
                $scope.buscaRespostas($scope.last_doubt);
                $scope.resposta.text = "";
            });
        }

        $scope.upvoteDuvida = function(duvida) {
            $http.post("/api/questions/" + duvida.id + "/upvote")
                .success(function(data) {
                    //$scope.duvidas[duvida.id].upvotes++;
                    //$scope.duvidas[duvida.id].my_vote = 1;
                    duvida.upvotes++;
                    duvida.my_vote = 1;
                })
        }

        $scope.cancelVoteDuvida = function(duvida) {
            $http.delete("/api/questions/" + duvida.id + "/vote")
                .success(function(data) {
                    duvida.upvotes--;
                    duvida.my_vote = 0;
                })
        }

        $scope.upvoteResposta = function(resposta) {
            $http.post("/api/answers/" + resposta.id + "/upvote")
                .success(function() {
                    if(resposta.my_vote == 0)
                        resposta.upvotes++;
                    else if(resposta.my_vote == -1)
                        resposta.upvotes += 2;
                    resposta.my_vote = 1;
                })
        }

        $scope.downvoteResposta = function(resposta) {
            $http.post("/api/answers/" + resposta.id + "/downvote")
                .success(function() {
                    if(resposta.my_vote == 0)
                        resposta.upvotes--;
                    else if(resposta.my_vote == 1)
                        resposta.upvotes -= 2;
                    resposta.my_vote = -1;
                })
        }

        $scope.cancelVoteResposta = function(resposta) {
            $http.delete("/api/answers/" + resposta.id + "/vote")
                .success(function() {
                    if(resposta.my_vote == 1)
                        resposta.upvotes--;
                    else
                        resposta.upvotes++;
                    resposta.my_vote = 0;
                })
        }

        $scope.aceitaResposta = function(resposta) {
            $http.post("/api/answers/" + resposta.id + "/accept")
                .success(function() {
                    resposta.accepted = true;
                    $scope.duvidas[resposta.question.id].answered = true;
                })
        }

        $scope.recusaResposta = function(resposta) {
            $http.delete("/api/answers/" + resposta.id + "/accept")
                .success(function() {
                    resposta.accepted = false;
                    $scope.duvidas[resposta.question.id].answered = false;
                })
        }

        //var socket = io.connect("/socket/presentation");
        //socket.on("new question", function (data) {
        //    Duvida.query({id: data.id},
        //        function (duvidas) {
        //            duvidas.forEach(function (elem) {
        //                addDuvida(elem)
        //            });
        //        },
        //        function (erro) {
        //            $scope.mensagem = {
        //                texto: 'Não foi possível obter o resultado.'
        //            };
        //        }
        //    );
        //});
        //
        //socket.on("new answer", function (data) {
        //    Resposta.query({id: data.id},
        //        function (respostas) {
        //            var id = respostas[0].question.id;
        //            $scope.duvidas[id].answers.push(respostas[0]);
        //        },
        //        function (erro) {
        //            $scope.mensagem = {
        //                texto: 'Não foi possível obter o resultado.'
        //            };
        //        }
        //    );
        //});
        //
        //socket.on("new question vote", function (data) {
        //    var type = data.type,
        //        id = data.id;
        //
        //    $scope.duvidas[id][type]++;
        //});
        //
        //socket.on("delete question vote", function (data) {
        //    var type = data.type,
        //        id = data.id;
        //
        //    $scope.duvidas[id][type] = $scope.duvidas[id][type] == 0 ? 0 : $scope.duvidas[id][type]--;
        //});
        //
        //socket.on("new answer accept", function (data) {
        //    var answer = data.answer;
        //    answer.accepted = true;
        //    $scope.duvidas[answer.question.id].answer = answer;
        //});
        //
        //socket.on("delete answer accept", function (data) {
        //    var answer = data.answer;
        //    answer.accepted = false;
        //    $scope.duvidas[answer.question.id].answer = null;
        //});

        $scope.usuario = {
            'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
            'email': JSON.parse($cookies.get('session').substring(2)).user.email
        }
        $scope.current_user = JSON.parse($cookies.get('session').substring(2)).user;
        buscaInfo();
    }
);
