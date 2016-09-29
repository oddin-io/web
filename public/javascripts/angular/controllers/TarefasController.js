oddin.controller('TarefasController',
  function ($scope, $stateParams, $http, $cookies) {
    function buscaInfo() {
      $http.get('/api/works/' + $stateParams.tarefaID)
        .success(function (data) {
          $scope.tarefa = data
        })
    }
    $scope.data_loaded = true;
    $scope.usuario = {
        'id': JSON.parse($cookies.get('session').substring(2)).person.id,
        'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
        'email': JSON.parse($cookies.get('session').substring(2)).person.email
    }

    function feedbackReloadSubmissions(msg) {
      $http.get('/api/works/' + $stateParams.tarefaID + '/submissions')
          .success(function (data) {
              $scope.submissoes = [];
              var submissions  = data;
              submissions.forEach(function (elem) {
                if(elem.person.id == $scope.usuario.id)
                  $scope.submissoes.push(elem);
              })
              $scope.data_loaded = true;
              Materialize.toast(msg, 4000);
          })
    }

    $scope.buscaSubmissoesAluno = function () {
        $http.get('/api/works/' + $stateParams.tarefaID + '/submissions')
            .success(function (data) {
                $scope.submissoes = [];
                var submissions = data;
                submissions.forEach(function (elem) {
                  if(elem.person.id == $scope.usuario.id)
                    $scope.submissoes.push(elem);
                })
            })
    }

    $scope.openModalDeleteSubmission = function (submission) {
      $scope.modalContent = submission;
      $('#modal-deleta-submissao').openModal();
    }

    $scope.openModalEditSubmission = function (submission) {
      $scope.modalContent = angular.copy(submission);
      if(submission.materials[0]) {
        $scope.modalContent.materialName = submission.materials[0].name;
      }
      $('#editar-trabalho').openModal();
    }

    $scope.deleteSubmission = function (submission) {
      $scope.data_loaded = false;
      $http.delete('api/submissions/' + submission.id)
        .success(function () {
          if(submission.materials.length > 0) {
            $http.delete('api/materials/' + submission.materials[0].id)
              .success(function () {
                for(var i = 0; i < $scope.submissoes.length; i++) {
                  if($scope.submissoes[i].id === submission.id) {
                    $scope.submissoes.splice(i, 1);
                    break;
                  }
                }
                $scope.data_loaded = true;
                Materialize.toast('Trabalho deletado', 3000);
              })
          } else {
            $scope.data_loaded = true;
            Materialize.toast('Trabalho deletado', 3000);
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

    $scope.buscaSubmissoesAluno = function () {
        $http.get('/api/works/' + $stateParams.tarefaID + '/submissions')
            .success(function (data) {
                $scope.submissoes = [];
                var submissions = data;
                submissions.forEach(function (elem) {
                  if(elem.person.id == $scope.usuario.id)
                    $scope.submissoes.push(elem);
                })
            })
    }

    $scope.buscaSubmissoes = function () {
        $http.get('/api/works/' + $stateParams.tarefaID + '/submissions')
            .success(function (data) {
                $scope.submissoes = data;
            })
    }

    $scope.createSubmission = function () {
      $scope.data_loaded = false;
      $http.post('/api/works/' + $scope.tarefa.id + '/submissions', $scope.submission)
        .success(function (submissionReturned) {
          if(document.forms.uploadArchive.file.files[0]) {
            var file = document.forms.uploadArchive.file.files[0]
            var fd = new FormData();
            $http.post('/api/submissions/' + submissionReturned.id + '/materials')
              .success(function (data) {
                for(var key in data.fields) {
                  fd.append(key, data.fields[key])
                }
                fd.append('file', file);
                $http.post(data.url, fd, {headers: {'Content-Type': undefined}})
                  .success(function () {
                    $http.put('api/materials/' + data.id, {'name': file.name, 'mime': file.type})
                      .success(function () {
                        $scope.submissoes.push(submissionReturned);
                        $scope.submission = null;
                        $scope.data_loaded = true;
                        Materialize.toast('Trabalho postado', 3000);
                        //recarregar submissions
                      })
                  })
              })
            } else {
              $scope.submissoes.push(submissionReturned);
              $scope.submission = null;
              $scope.data_loaded = true;
              Materialize.toast('Trabalho postado', 3000);
            }
        })
    }

    $scope.updateSubmission = function () {
      $scope.data_loaded = false;
      $http.put('/api/submissions/' + $scope.modalContent.id, $scope.modalContent)
          .success(function (data) {
            if($scope.modalContent.materials.length > 0) {
              $http.delete('/api/materials/' + $scope.modalContent.materials[0].id)
                .success(function () {
                  if(document.forms.updateArchive.file.files[0]) {
                    var file = document.forms.updateArchive.file.files[0]
                    var fd = new FormData();
                    $http.post('/api/submissions/' + data.id + '/materials')
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
                                feedbackReloadSubmissions('O trabalho foi atualizado');
                              })
                          })
                      })
                  } else {
                    $scope.modalContent = null;
                    $scope.data_loaded = true;
                    feedbackReloadSubmissions('O trabalho foi atualizado');
                  }
                })
            } else {
              if(document.forms.updateArchive.file.files[0]) {
                var file = document.forms.updateArchive.file.files[0]
                var fd = new FormData();
                $http.post('/api/submissions/' + data.id + '/materials')
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
                            feedbackReloadSubmissions('O trabalho foi atualizado');
                          })
                      })
                  })
              } else {
                $scope.modalContent = null;
                $scope.data_loaded = true;
                feedbackReloadSubmissions('O trabalho foi atualizado');
              }
            }
          })
    }

    $scope.downloadSubmission = function (submissao) {
      $scope.data_loaded = false;
      $http.get('api/materials/' + submissao.materials[0].id)
        .success(function (data) {
          var link = document.createElement('a');
          link.setAttribute('href', data.url);
          link.setAttribute('download', true);
          link.click()
          $scope.data_loaded = true;
          Materialize.toast('Baixando trabalho: ' + submissao.materials[0].name, 3000)
        })
    }

    $scope.buscaSubmissaoMaterial = function (submissao) {
      $http.get('/api/submissions/' + submissao.id + '/materials')
        .success(function (data) {
          submissao.materials[0] = data[0];
        })
    }
    buscaInfo();
})
