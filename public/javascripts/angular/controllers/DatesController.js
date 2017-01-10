oddin.controller('DatesController',
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

        function feedbackReloadDates(msg) {
          $http.get('/api/instructions/' + $stateParams.disciplinaID + '/dates')
              .success(function (data) {
                  $scope.datas = data
                  $scope.data_loaded = true;
                  Materialize.toast(msg, 4000);
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
