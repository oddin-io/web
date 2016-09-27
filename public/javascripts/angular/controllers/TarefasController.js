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

    $scope.buscaSubmissoesAluno = function () {
        $http.get('/api/works/' + $stateParams.tarefaID + '/submissions')
            .success(function (data) {
                $scope.submissoes = [];
                var submissions = data;
                submissions.forEach(function (elem) {
                  if(elem.person_id == $scope.usuario.id)
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
        .success(function (data) {
          var file = document.forms.uploadArchive.file.files[0]
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
                      $scope.submission = null;
                      //recarregar submissions
                    })
                })
            })
        })
    }

    $scope.criaTarefa = function () {
      $scope.data_loaded = false;
      $scope.tarefa.deadline = convertDate($scope.tarefa.deadline);
      $http.post('/api/instructions/' + $stateParams.disciplinaID + "/works", $scope.tarefa)
          .success(function (data) {
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
                        feedbackReloadWorks('A tarefa foi criada');
                      })
                  })
              })
          })
    }

    $scope.downloadSubmission = function (submissao) {
      $scope.data_loaded = false;
      $http.get('api/materials/' + submissao.material[0].id)
        .success(function (data) {
          var link = document.createElement('a');
          link.setAttribute('href', data.url);
          link.setAttribute('download', true);
          link.click()
          $scope.data_loaded = true;
          Materialize.toast('Baixando trabalho: ' + submissao.material[0].name, 3000)
        })
    }

    $scope.buscaSubmissaoMaterial = function (submissao) {
      $http.get('/api/submissions/' + submissao.id + '/materials')
        .success(function (data) {
          submissao.material = data;
        })
    }
    buscaInfo();
})
