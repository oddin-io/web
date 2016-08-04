angular.module('oddin').controller('AulaController',
  function($scope, $stateParams, Aula, Duvida, Resposta) {
    $scope.duvidas = {};
    $scope.duvida = new Duvida();
    function buscaInfo() {
      Aula.get({id: $stateParams.aulaID},
        function(aula) {
          $scope.aula = aula;
        },
        function(erro) {
          $scope.mensagem = {texto: "Não foi possível obter o resultado."};
        }
      );
    }

    function addDuvida(duvida) {
        $scope.duvidas[duvida.id] = duvida;
    }

    function removeDuvida(duvida) {
        $scope.duvidas[duvida.id] = duvida;
    }

    $scope.buscaDuvidas = function () {
      Duvida.query({id: $stateParams.aulaID},
        function (duvidas) {
          duvidas.forEach(function (elem) {
              addDuvida(elem)
          });
        },
        function (erro) {
          $scope.mensagem = {
            texto: 'Não foi possível obter o resultado.'
          };
        }
      );
    };

    $scope.postaDuvida = function() {
        if($scope.duvida.anonymous === undefined) $scope.duvida.anonymous = false;
        $scope.duvida.$save({id: $stateParams.aulaID})
            .then(function(data) {
                addDuvida(data);
                $scope.duvida = new Duvida();
            })
            .catch(function(erro) {
                $scope.mensagem = {texto: 'Não foi possível postar a dúvida'};
                $scope.duvida = new Duvida();
            });
    }
    buscaInfo();

      var socket = io("/socket/presentation");
      socket.on("new question", function (data) {
          Duvida.query({id: data.id},
              function (duvidas) {
                  duvidas.forEach(function (elem) {
                      addDuvida(elem)
                  });
              },
              function (erro) {
                  $scope.mensagem = {
                      texto: 'Não foi possível obter o resultado.'
                  };
              }
          );
      });

      socket.on("new answer", function (data) {
          Resposta.query({id: data.id},
              function (respostas) {
                  var id = respostas[0].question.id;
                  $scope.duvidas[id].answers.push(respostas[0]);
              },
              function (erro) {
                  $scope.mensagem = {
                      texto: 'Não foi possível obter o resultado.'
                  };
              }
          );
      });

      socket.on("new question vote", function (data) {
          var type = data.type,
              id = data.id;

          $scope.duvidas[id][type]++;
      });

      socket.on("delete question vote", function (data) {
          var type = data.type,
              id = data.id;

          $scope.duvidas[id][type] = $scope.duvidas[id][type] == 0 ? 0 : $scope.duvidas[id][type]--;
      });

      socket.on("new answer accept", function (data) {
          var answer = data.answer;
          answer.accepted = true;
          $scope.duvidas[answer.question.id].answer = answer;
      });

      socket.on("delete answer accept", function (data) {
          var answer = data.answer;
          answer.accepted = false;
          $scope.duvidas[answer.question.id].answer = null;
      });
  }
);
