oddin.controller('NoticesController',
    function ($http, $scope, $stateParams, $cookies, Disciplina) {

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

        function feedbackReloadNotices(msg) {
          $http.get('/api/instructions/' + $stateParams.disciplinaID + '/notices')
              .success(function (data) {
                  $scope.avisos = data
                  $scope.data_loaded = true;
                  Materialize.toast(msg, 4000);
              })
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
        buscaInfo()
    }
)
