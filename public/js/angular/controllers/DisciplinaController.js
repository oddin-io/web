oddin.controller('DisciplinaController',
  function($http, $scope, $stateParams, $state, Disciplina, DisciplinaAula, DisciplinaMaterial, DisciplinaParticipante, Profile) {
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

    $scope.aula = new DisciplinaAula();

    $scope.buscaAulas = function() {
      DisciplinaAula.query({id: $stateParams.disciplinaID},
        function (aulas) {
          $scope.aulas = aulas;
        },
        function (erro) {
          $scope.mensagem = {
            texto: 'Não foi possível obter o resultado.'
          };
        }
      );
    };

    $scope.buscaParticipantes = function() {
      DisciplinaParticipante.query({id: $stateParams.disciplinaID},
        function (participantes) {
          $scope.participantes = participantes;
        },
        function (erro) {
          $scope.mensagem = {
            texto: 'Não foi possível obter o resultado.'
          };
        }
      );
    };

    $scope.buscaMateriais = function() {
      DisciplinaMaterial.query({id: $stateParams.disciplinaID},
        function (materiais) {
          $scope.materiais = materiais;
        },
        function (erro) {
          $scope.mensagem = {
            texto: 'Não foi possível obter o resultado.'
          };
        }
      );
    };

    $scope.criaAula = function() {
        $scope.aula.$save({id: $stateParams.disciplinaID})
            .then(function() {
                $scope.mensagem = {texto: 'Salvo com sucesso'};
                $scope.buscaAulas();
                $scope.aula = new DisciplinaAula();
            })
            .catch(function(erro) {
                $scope.mensagem = {texto: 'Não foi possível salvar'};
            });
    };

    $scope.fechaAula = function(aula) {
        $http.post('api/presentations/' + aula.id + "/close")
            .success(function(data) {
                $scope.buscaAulas();
            });
    };

    $scope.uploadMaterial = function() {
        var file = document.forms.uploadArchive.file.files[0];
        var fd = new FormData();
        $http.get('api/instructions/' + $scope.disciplina.id + "/materials/new")
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
    buscaInfo();
  }
);

