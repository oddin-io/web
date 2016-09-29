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
          var convertedDate;
          if(time === undefined) {
            convertedDate = date.substring(4, 8) + "-" + date.substring(2, 4) + "-" + date.substring(0,2) +
            "T00:00:00.0Z";
            return convertedDate;
          }
          convertedDate = date.substring(4, 8) + "-" + date.substring(2, 4) + "-" + date.substring(0,2) +
          "T" + time.substring(0,2) + ":" + time.substring(2,4) + ":00.0Z";
          return convertedDate;
        }

        function formatDate(date) {
          return date.substring(8,10) + date.substring(5, 7) + date.substring(0, 4);
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

        function feedbackReloadWorks(msg) {
          $http.get('/api/instructions/' + $stateParams.disciplinaID + '/works')
              .success(function (data) {
                  $scope.tarefas = data
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

        $scope.postaTarefaTeste = function (tarefa) {
          $http.post('/api/works/' + tarefa.id + '/submissions', {'text': "Teste de submissão de trabalho"})
            .success(function (data) {
              console.log("postou! " + data);
            })
        }

        $scope.openModalEditWork = function (tarefa) {
          $scope.modalContent = angular.copy(tarefa);
          $scope.modalContent.deadline = formatDate($scope.modalContent.deadline);
          if(tarefa.materials[0]) {
            $scope.modalContent.materialName = tarefa.materials[0].name;
          }
          $('#editar-tarefa').openModal();
        }

        $scope.openModalDeleteWork = function (tarefa) {
          $scope.modalContent = tarefa;
          $('#modal-deleta-tarefa').openModal();
        }

        $scope.criaTarefa = function () {
          $scope.data_loaded = false;
          $scope.tarefa.deadline = convertDate($scope.tarefa.deadline);
          $http.post('/api/instructions/' + $stateParams.disciplinaID + "/works", $scope.tarefa)
              .success(function (data) {
                if(document.forms.uploadArchive.file.files[0]) {
                  var file = document.forms.uploadArchive.file.files[0]
                  var fd = new FormData();
                  $http.post('/api/works/' + data.id + '/materials')
                    .success(function (data) {
                      for(var key in data.fields) {
                        fd.append(key, data.fields[key])
                      }
                      fd.append('file', file);
                      $http.post(data.url, fd, {headers: {'Content-Type': undefined}})
                        .success(function () {
                          $http.put('api/materials/' + data.id, {'name': file.name, 'mime': file.type})
                            .success(function () {
                              $scope.tarefa = null;
                              $scope.data_loaded = true;
                              feedbackReloadWorks('A tarefa foi criada');
                            })
                        })
                    })
                  return;
                }
                $scope.tarefa = null;
                $scope.data_loaded = true;
                feedbackReloadWorks('A tarefa foi criada');
              })
        }

        $scope.atualizaTarefa = function () {
          $scope.data_loaded = false;
          $scope.modalContent.deadline = convertDate($scope.modalContent.deadline);
          $http.put('/api/works/' + $scope.modalContent.id, $scope.modalContent)
              .success(function (data) {
                if($scope.modalContent.materials.length > 0) {
                  $http.delete('/api/materials/' + $scope.modalContent.materials[0].id)
                    .success(function () {
                      if(document.forms.updateArchive.file.files[0]) {
                        var file = document.forms.updateArchive.file.files[0]
                        var fd = new FormData();
                        $http.post('/api/works/' + data.id + '/materials')
                          .success(function (data) {
                            for(var key in data.fields) {
                              fd.append(key, data.fields[key])
                            }
                            fd.append('file', file);
                            $http.post(data.url, fd, {headers: {'Content-Type': undefined}})
                              .success(function () {
                                $http.put('api/materials/' + data.id, {'name': file.name, 'mime': file.type})
                                  .success(function () {
                                    $scope.modalContent = null;
                                    $scope.data_loaded = true;
                                    feedbackReloadWorks('A tarefa foi atualizada');
                                  })
                              })
                          })
                      } else {
                        $scope.modalContent = null;
                        $scope.data_loaded = true;
                        feedbackReloadWorks('A tarefa foi atualizada');
                      }
                    })
                } else {
                  if(document.forms.updateArchive.file.files[0]) {
                    var file = document.forms.updateArchive.file.files[0]
                    var fd = new FormData();
                    $http.post('/api/works/' + data.id + '/materials')
                      .success(function (data) {
                        for(var key in data.fields) {
                          fd.append(key, data.fields[key])
                        }
                        fd.append('file', file);
                        $http.post(data.url, fd, {headers: {'Content-Type': undefined}})
                          .success(function () {
                            $http.put('api/materials/' + data.id, {'name': file.name, 'mime': file.type})
                              .success(function () {
                                $scope.modalContent = null;
                                $scope.data_loaded = true;
                                feedbackReloadWorks('A tarefa foi atualizada');
                              })
                          })
                      })
                  } else {
                    $scope.modalContent = null;
                    $scope.data_loaded = true;
                    feedbackReloadWorks('A tarefa foi atualizada');
                  }
                }
              })
        }

        $scope.deletaTarefa = function (tarefa) {
          $scope.data_loaded = false;
          $http.delete('api/works/' + tarefa.id)
            .success(function () {
              if(tarefa.materials.length > 0) {
                $http.delete('api/materials/' + tarefa.materials[0].id)
                  .success(function () {
                    feedbackReloadWorks('Tarefa deletada');
                    $scope.data_loaded = true;
                  })
                return;
              }
              feedbackReloadWorks('Tarefa deletada');
              $scope.data_loaded = true;
            })
        }

        $scope.downloadEspecificacao = function (tarefa) {
          $scope.data_loaded = false;
          $http.get('api/materials/' + tarefa.materials[0].id)
            .success(function (data) {
              var link = document.createElement('a');
              link.setAttribute('href', data.url);
              link.setAttribute('download', true);
              link.click()
              $scope.data_loaded = true;
              Materialize.toast('Baixando especificação: ' + tarefa.materials[0].name, 3000)
            })
        }

        $scope.buscaTarefaMaterial = function (tarefa) {
          $http.get('/api/works/' + tarefa.id + '/materials')
            .success(function (data) {
              tarefa.materials = data;
            })
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

        $scope.buscaTarefas = function () {
          $http.get('/api/instructions/' + $stateParams.disciplinaID + '/works')
              .success(function (data) {
                $scope.tarefas = data;
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

        $scope.openModalDeleteDate = function (date) {
          $scope.modalContent = date;
          $('#modal-delete-date').openModal();
        }

        $scope.openModalEditDate = function (date) {
          $scope.modalContent = angular.copy(date);
          var formatDate = $scope.modalContent.date.substring(8, 10) + $scope.modalContent.date.substring(5, 7) + $scope.modalContent.date.substring(0,4);
          var formatTime = $scope.modalContent.date.substring(11, 16);
          $scope.modalContent.date = formatDate;
          $scope.modalContent.time = formatTime;
          $('#modal-editar-data').openModal();
        }

        $scope.updateDate = function () {
          $scope.data_loaded = false;
          $scope.modalContent.date = convertDate($scope.modalContent.date, $scope.modalContent.time);
          $http.put('api/dates/' +  $scope.modalContent.id, $scope.modalContent)
                .success(function (data) {
                  feedbackReloadDates('Data atualizada');
                })
                .error(function (data) {
                  $scope.data_loaded = true;
                  Materialize.toast('Erro no servidor!', 3000);
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

        $scope.deleteDate = function (date) {
          $scope.data_loaded = false;
          $http.delete('api/dates/' +  date.id)
                .success(function (data) {
                  feedbackReloadDates('Data deletada');
                })
        }
        buscaInfo()
    }
)
