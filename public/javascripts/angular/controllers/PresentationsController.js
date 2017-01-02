oddin.controller('PresentationsController',
    function ($http, $scope, $stateParams, $cookies, DisciplinaAula, Disciplina) {
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
        buscaInfo()
    }
)
