oddin.controller('WorksController',
    function ($http, $scope, $stateParams, $state, $cookies, Disciplina, DisciplinaAula, DisciplinaMaterial, DisciplinaParticipante, Profile) {

        $scope.usuario = {
            'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
            'email': JSON.parse($cookies.get('session').substring(2)).person.email,
        }

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

        function feedbackReloadWorks(msg) {
          $http.get('/api/instructions/' + $stateParams.disciplinaID + '/works')
              .success(function (data) {
                  $scope.tarefas = data
                  $scope.data_loaded = true;
                  Materialize.toast(msg, 4000);
              })
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
							hiddenLink = document.getElementById("hidden-link")
							hiddenLink.appendChild(link)
              link.click()
              $scope.data_loaded = true;
              Materialize.toast('Baixando especificação: ' + tarefa.materials[0].name, 3000)
							hiddenLink.removeChild(link)
            })
        }

        $scope.buscaTarefaMaterial = function (tarefa) {
          $http.get('/api/works/' + tarefa.id + '/materials')
            .success(function (data) {
              tarefa.materials = data;
            })
        }

        $scope.buscaTarefas = function () {
          $http.get('/api/instructions/' + $stateParams.disciplinaID + '/works')
              .success(function (data) {
                $scope.tarefas = data;
              })
        }
        buscaInfo()
    }
)
