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

        function feedbackReloadAulas(msg) {
            DisciplinaAula.query({ id: $stateParams.disciplinaID },
                function (aulas) {
                    $scope.aulas = aulas
                    $scope.data_loaded = true;
                    Materialize.toast(msg, 3000);
                    $scope.aula = new DisciplinaAula()
                },
                function (erro) {
                    $scope.mensagem = {
                        texto: 'Não foi possível obter o resultado.',
                    }
                }
            )
        }

        $scope.goToMaterial = function (elem) {
            $('.button-collapse').sideNav('hide');
            if ($cookies.get('profile') == 0) {
                $state.go('materiais.aluno', { 'disciplinaID': $scope.disciplina.id })
            } else {
                $state.go('materiais.professor', { 'disciplinaID': $scope.disciplina.id })
            }
        }

        $scope.goToLectures = function () {
            $('.button-collapse').sideNav('hide');
            if ($cookies.get('profile') == 0) {
                $state.go('aulas.aluno', { 'disciplinaID': $scope.disciplina.id })
            } else {
                $state.go('aulas.professor', { 'disciplinaID': $scope.disciplina.id })
            }
        }

        $scope.goToDoubts = function (aula) {
            if ($cookies.get('profile') == 0) {
                $state.go('duvidas.aluno', { 'aulaID': aula.id })
            } else {
                $state.go('duvidas.professor', { 'aulaID': aula.id })
            }
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

        $scope.uploadMaterial = function () {
            var file = document.forms.uploadArchive.file.files[0]
            var fd = new FormData()
            $http.get('api/instructions/' + $scope.disciplina.id + '/materials/new')
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
                                    $scope.buscaMateriais()
                                })
                        })
                })
        }

        $scope.downloadMaterial = function (material) {
            $http.get('api/materials/' + material.id)
                .success(function (data) {
                    var link = document.createElement('a')
                    link.setAttribute('href', data.url)
                    link.setAttribute('download', true)
                    link.click()
                })
        }
        buscaInfo()
    }
)
