oddin.controller('AulaController',
    function ($scope, $stateParams, Aula, Duvida, Resposta, $http, $state, $cookies) {
        $scope.filter = false;
        $scope.duvida = new Duvida()
        $scope.last_doubt = {}
        $scope.data_loaded = true;
        function buscaInfo() {
            Aula.get({ id: $stateParams.aulaID },
                function (aula) {
                    $scope.aula = aula
                },
                function (erro) {
                    $scope.mensagem = { texto: 'Não foi possível obter o resultado.' }
                }
            )
        }

        function feedbackReloadMaterial(msg) {
            $http.get('/api/presentation/' + $stateParams.aulaID + '/materials')
                .success(function (data) {
                    $scope.materiais = data;
                    $scope.data_loaded = true;
                    Materialize.toast(msg, 4000);
                })
        }

        function addDuvida(duvida) {
            $scope.duvidas[duvida.id] = duvida
        }

        function removeDuvida(duvida) {
            $scope.duvidas[duvida.id] = duvida
        }

        $scope.enableFilter = function () {
            $scope.filter = true;
            $('#post-order').removeClass('filter-item-active');
            $('#ranking-order').addClass('filter-item-active');
        }

        $scope.disableFilter = function () {
            $scope.filter = false;
            $('#ranking-order').removeClass('filter-item-active');
            $('#post-order').addClass('filter-item-active');
        }

        $scope.buscaMateriais = function () {
            $http.get('/api/presentation/' + $stateParams.aulaID + '/materials')
                .success(function (data) {
                    $scope.materiais = data
                })
        }

        $scope.uploadMaterial = function () {
            $scope.data_loaded = false;
            var file = document.forms.uploadArchive.file.files[0]
            var fd = new FormData()
            $http.post('api/presentation/' + $stateParams.aulaID + '/materials')
                .success(function (data) {
                    for (var key in data.fields) {
                        fd.append(key, data.fields[key])
                    }
                    fd.append('file', file)
                    $http.post(data.url, fd, { headers: { 'Content-Type': undefined } })
                        .success(function () {
                            $http.put('api/materials/' + data.id, { 'name': file.name, 'mime': file.type })
                                .success(function () {
                                    console.log('Upload Realizado')
                                    feedbackReloadMaterial('O arquivo ' + file.name + ' foi postado');
                                })
                        })
                })
        }

        $scope.openModalDeleteMaterial = function (material) {
            $scope.modalContent = material;
            $('#modal-deleta-material').openModal();
        }

        $scope.downloadMaterial = function (material) {
            $scope.data_loaded = false;
            $http.get('api/materials/' + material.id)
                .success(function (data) {
                    var link = document.createElement('a')
                    link.setAttribute('href', data.url)
                    link.setAttribute('download', true)
                    link.click()
                    $scope.data_loaded = true;
                    Materialize.toast('Fazendo download de ' + material.name, 4000)
                })
        }

        $scope.deleteMaterial = function (material) {
            $scope.data_loaded = false;
            $http.delete('api/materials/' + material.id)
                .success(function (data) {
                    feedbackReloadMaterial('Arquivo deletado');
                })
        }

        $scope.setLastDoubt = function (duvida) {
            $scope.last_doubt = duvida
        }

        $scope.buscaDuvidas = function () {
            Duvida.query({ id: $stateParams.aulaID },
                function (duvidas) {
                    $scope.duvidas = duvidas;
                },
                function (erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.',
                    }
                }
            )
        }

        $scope.postaDuvida = function () {
            $scope.data_loaded = false;
            if ($scope.duvida.anonymous === undefined) $scope.duvida.anonymous = false
            $scope.duvida.$save({ id: $stateParams.aulaID })
                .then(function (data) {
                    $scope.duvidas.unshift(data);
                    $scope.data_loaded = true;
                    $scope.duvida = new Duvida()
                    Materialize.toast('Dúvida postada', 1000);
                })
                .catch(function (erro) {
                    $scope.mensagem = { texto: 'Não foi possível postar a dúvida' }
                    $scope.duvida = new Duvida()
                })
        }

        $scope.fecharRespostas = function (duvida) {
            duvida.answers = undefined;
        }

        $scope.buscaRespostas = function (duvida) {
            $http.get('/api/questions/' + duvida.id + '/answers').success(function (data) {
                duvida.answers = data;
            })
        }

        $scope.postaResposta = function () {
            $scope.data_loaded = false;
            $http.post('/api/questions/' + $scope.last_doubt.id + '/answers', $scope.resposta).success(function (data) {
                $scope.data_loaded = true;
                Materialize.toast('Resposta postada', 1000);
                $scope.buscaRespostas($scope.last_doubt)
                $scope.resposta.text = ''
            })
        }

        $scope.upvoteDuvida = function (duvida) {
            $http.post('/api/questions/' + duvida.id + '/upvote')
                .success(function (data) {
                    // $scope.duvidas[duvida.id].upvotes++;
                    // $scope.duvidas[duvida.id].my_vote = 1;
                    duvida.upvotes++
                    duvida.my_vote = 1
                })
        }

        $scope.cancelVoteDuvida = function (duvida) {
            $http.delete('/api/questions/' + duvida.id + '/vote')
                .success(function (data) {
                    duvida.upvotes--
                    duvida.my_vote = 0
                })
        }

        $scope.upvoteResposta = function (resposta) {
            $http.post('/api/answers/' + resposta.id + '/upvote')
                .success(function () {
                    if (resposta.my_vote == 0)
                        resposta.upvotes++
                    else if (resposta.my_vote == -1)
                        resposta.upvotes += 2
                    resposta.my_vote = 1
                })
        }

        $scope.downvoteResposta = function (resposta) {
            $http.post('/api/answers/' + resposta.id + '/downvote')
                .success(function () {
                    if (resposta.my_vote == 0)
                        resposta.upvotes--
                    else if (resposta.my_vote == 1)
                        resposta.upvotes -= 2
                    resposta.my_vote = -1
                })
        }

        $scope.cancelVoteResposta = function (resposta) {
            $http.delete('/api/answers/' + resposta.id + '/vote')
                .success(function () {
                    if (resposta.my_vote == 1)
                        resposta.upvotes--
                    else
                        resposta.upvotes++
                    resposta.my_vote = 0
                })
        }

        $scope.aceitaResposta = function (resposta) {
            $http.post('/api/answers/' + resposta.id + '/accept')
                .success(function () {
                    resposta.accepted = true
                    $scope.duvidas[resposta.question.id].answered = true
                })
        }

        $scope.recusaResposta = function (resposta) {
            $http.delete('/api/answers/' + resposta.id + '/accept')
                .success(function () {
                    resposta.accepted = false
                    $scope.duvidas[resposta.question.id].answered = false
                })
        }

        // var socket = io.connect("/socket/presentation");
        // socket.on("new question", function (data) {
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
        // });
        //
        // socket.on("new answer", function (data) {
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
        // });
        //
        // socket.on("new question vote", function (data) {
        //    var type = data.type,
        //        id = data.id;
        //
        //    $scope.duvidas[id][type]++;
        // });
        //
        // socket.on("delete question vote", function (data) {
        //    var type = data.type,
        //        id = data.id;
        //
        //    $scope.duvidas[id][type] = $scope.duvidas[id][type] == 0 ? 0 : $scope.duvidas[id][type]--;
        // });
        //
        // socket.on("new answer accept", function (data) {
        //    var answer = data.answer;
        //    answer.accepted = true;
        //    $scope.duvidas[answer.question.id].answer = answer;
        // });
        //
        // socket.on("delete answer accept", function (data) {
        //    var answer = data.answer;
        //    answer.accepted = false;
        //    $scope.duvidas[answer.question.id].answer = null;
        // });
        $scope.usuario = {
            'id': JSON.parse($cookies.get('session').substring(2)).person.id,
            'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
            'email': JSON.parse($cookies.get('session').substring(2)).person.email
        }
        buscaInfo()
    }
)
