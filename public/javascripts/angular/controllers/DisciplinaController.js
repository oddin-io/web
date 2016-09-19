oddin.controller('DisciplinaController',
    function ($http, $scope, $stateParams, $state, $cookies, Disciplina, DisciplinaAula, DisciplinaMaterial, DisciplinaParticipante, Profile) {

        $scope.usuario = {
            'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
            'email': JSON.parse($cookies.get('session').substring(2)).person.email,
        }
        $scope.aula = new DisciplinaAula();
        $scope.data_loaded = true;

        function buscaInfo() {
            Disciplina.get({ id: $stateParams.disciplinaID },
                function (disciplina) {
                    $scope.disciplina = disciplina
                },
                function (erro) {
                    $scope.mensagem = { texto: 'Não foi possível obter o resultado.' }
                }
            )
        }

        function convertDate(date, time) {
          var convertedDate = date.substring(4, 8) + "-" + date.substring(2, 4) + "-" + date.substring(0,2) +
          "T" + time.substring(0,2) + ":" + time.substring(2,4) + ":00.000Z";
          return convertedDate;
        }

        function feedbackReloadAulas(msg) {
            DisciplinaAula.query({ id: $stateParams.disciplinaID },
                function (aulas) {
                    $scope.aulas = aulas
                    $scope.data_loaded = true;
                    Materialize.toast(msg, 4000);
                    $scope.aula = new DisciplinaAula()
                },
                function (erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.',
                    }
                }
            )
        }

        function feedbackReloadMaterial(msg) {
            DisciplinaMaterial.query({ id: $stateParams.disciplinaID },
                function (materiais) {
                    $scope.materiais = materiais
                    $scope.data_loaded = true;
                    Materialize.toast(msg, 4000);
                },
                function (erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.',
                    }
                }
            )
        }

        function feedbackReloadNotices(msg) {
          $http.get('/api/instructions/' + $stateParams.disciplinaID + '/notices')
              .success(function (data) {
                  $scope.avisos = data
                  $scope.data_loaded = true;
                  Materialize.toast(msg, 4000);
              })
        }

        function feedbackReloadDates(msg) {
          $http.get('/api/instructions/' + $stateParams.disciplinaID + '/dates')
              .success(function (data) {
                  $scope.datas = data
                  $scope.data_loaded = true;
                  Materialize.toast(msg, 4000);
              })
        }

        $scope.buscaAulas = function () {
            DisciplinaAula.query({ id: $stateParams.disciplinaID },
                function (aulas) {
                    $scope.aulas = aulas
                },
                function (erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.',
                    }
                }
            )
        }

        $scope.buscaParticipantes = function () {
            DisciplinaParticipante.query({ id: $stateParams.disciplinaID },
                function (participantes) {
                    $scope.participantes = participantes
                },
                function (erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.',
                    }
                }
            )
        }

        $scope.buscaAvisos = function () {
          $http.get('/api/instructions/' + $stateParams.disciplinaID + '/notices')
              .success(function (data) {
                  $scope.avisos = data
              })
        }

        $scope.postaAviso = function () {
          $scope.data_loaded = false;
          $http.post('/api/instructions/' + $stateParams.disciplinaID + "/notices", $scope.aviso)
              .success(function () {
                $scope.aviso = null;
                feedbackReloadNotices('O aviso foi postado');
              })
        }

        $scope.postaData = function () {
          $scope.date.date = convertDate($scope.date.date, $scope.date.time);
          delete $scope.date['time'];
          $scope.data_loaded = false;
          $http.post('/api/instructions/' + $stateParams.disciplinaID + "/dates", $scope.date)
              .success(function () {
                $scope.date = null;
                feedbackReloadDates('A Data foi postada');
              })
        }

        $scope.buscaDatas = function () {
          $http.get('/api/instructions/' + $stateParams.disciplinaID + '/dates')
              .success(function (data) {
                  $scope.datas = data
              })
        }

        $scope.buscaMateriais = function () {
            DisciplinaMaterial.query({ id: $stateParams.disciplinaID },
                function (materiais) {
                    $scope.materiais = materiais
                },
                function (erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.',
                    }
                }
            )
        }

        $scope.criaAula = function () {
            $scope.data_loaded = false;
            $scope.aula.$save({ id: $stateParams.disciplinaID })
                .then(function () {
                    feedbackReloadAulas('A aula ' + $scope.aula.subject + " foi criada");
                })
                .catch(function (erro) {
                    Materialize.toast('Não foi possível criar uma nova aula', 3000);
                })
        }

        $scope.fechaAula = function (aula) {
            $scope.data_loaded = false;
            $http.post('api/presentations/' + aula.id + '/close')
                .success(function (data) {
                    feedbackReloadAulas('A aula ' + aula.subject + ' foi finalizada');
                })
        }

        $scope.openModalCloseLecture = function (aula) {
            $scope.modalContent = aula;
              $('#modal-fecha-aula').openModal();
        }

        $scope.openModalDeleteMaterial = function (material) {
            $scope.modalContent = material;
              $('#modal-deleta-material').openModal();
        }

        $scope.uploadMaterial = function () {
            $scope.data_loaded = false;
            var file = document.forms.uploadArchive.file.files[0]
            var fd = new FormData()
            $http.post('api/instructions/' + $scope.disciplina.id + '/materials')
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
        buscaInfo()
    }
)
