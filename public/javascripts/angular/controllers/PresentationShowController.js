oddin.controller('PresentationShowController',
    function ($scope, $stateParams, Aula, Duvida, Resposta, $http, $state, $cookies) {
      $scope.filter = false
      $scope.duvida = new Duvida()
      $scope.last_doubt = {}
      $scope.data_loaded = true
      const duvidas = {}
      const socket = io.connect('http://socket-oddin.rhcloud.com:8000/presentation')

      function buscaInfo() {
        Aula.get({ id: $stateParams.aulaID },
                function (aula) {
                  $scope.aula = aula
                },
                function (erro) {
                  $scope.mensagem = { texto: 'Não foi possível obter o resultado.' }
                }
            )
      }

      function addDuvida(duvida) {
        console.log(duvida)
        duvidas[duvida.id] = duvida
        $scope.duvidas.unshift(duvida)
        $scope.duvida = new Duvida()
      }

      function removeDuvida(duvida) {
        $scope.duvidas[duvida.id] = duvida
      }

      $scope.enableFilter = function () {
        $scope.filter = true
        $('#post-order').removeClass('filter-item-active')
        $('#ranking-order').addClass('filter-item-active')
      }

      $scope.disableFilter = function () {
        $scope.filter = false
        $('#ranking-order').removeClass('filter-item-active')
        $('#post-order').addClass('filter-item-active')
      }

      $scope.setLastDoubt = function (duvida) {
        $scope.last_doubt = duvida
      }

      $scope.buscaDuvidas = function () {
        Duvida.query({ id: $stateParams.aulaID },
                function (duvidas) {
                  $scope.duvidas = duvidas
                },
                function (erro) {
                  $scope.mensagem = {
                    texto: 'Não foi possível obter o resultado.',
                  }
                }
            )
      }

      $scope.postaDuvida = function () {
        $scope.data_loaded = false
        if ($scope.duvida.anonymous === undefined) $scope.duvida.anonymous = false
        $scope.duvida.$save({ id: $stateParams.aulaID })
                .then(function (data) {
                  $scope.data_loaded = true
                  // addDuvida(data)
                  socket.emit('POST /questions', [data])
                  Materialize.toast('Dúvida postada', 1000)
                })
                .catch(function (erro) {
                  $scope.mensagem = { texto: 'Não foi possível postar a dúvida' }
                  $scope.duvida = new Duvida()
                })
      }

      $scope.fecharRespostas = function (duvida) {
        duvida.answers = undefined
      }

      $scope.buscaRespostas = function (duvida) {
        $http.get('/api/questions/' + duvida.id + '/answers').success(function (data) {
          duvida.answers = data
        })
      }

      $scope.postaResposta = function () {
        $scope.data_loaded = false
        $http.post('/api/questions/' + $scope.last_doubt.id + '/answers', $scope.resposta).success(function (data) {
          $scope.last_doubt.has_answer = true
          $scope.data_loaded = true
          Materialize.toast('Resposta postada', 1000)
          $scope.buscaRespostas($scope.last_doubt)
          $scope.resposta.text = ''
        })
      }

      $scope.upvoteDuvida = function (duvida) {
        $http.post('/api/questions/' + duvida.id + '/upvote')
                .success(function (data) {
                    // $scope.duvidas[duvida.id].upvotes++;
                    // $scope.duvidas[duvida.id].my_vote = 1;
                  duvida.upvotes++
                  duvida.my_vote = 1
                })
      }

      $scope.cancelVoteDuvida = function (duvida) {
        $http.delete('/api/questions/' + duvida.id + '/vote')
                .success(function (data) {
                  duvida.upvotes--
                  duvida.my_vote = 0
                })
      }

      $scope.upvoteResposta = function (resposta) {
        $http.post('/api/answers/' + resposta.id + '/upvote')
                .success(function () {
                  if (resposta.my_vote == 0)
                    { resposta.upvotes++ }
                  else if (resposta.my_vote == -1)
                    { resposta.upvotes += 2 }
                  resposta.my_vote = 1
                })
      }

      $scope.downvoteResposta = function (resposta) {
        $http.post('/api/answers/' + resposta.id + '/downvote')
                .success(function () {
                  if (resposta.my_vote == 0)
                    { resposta.upvotes-- }
                  else if (resposta.my_vote == 1)
                    { resposta.upvotes -= 2 }
                  resposta.my_vote = -1
                })
      }

      $scope.cancelVoteResposta = function (resposta) {
        $http.delete('/api/answers/' + resposta.id + '/vote')
                .success(function () {
                  if (resposta.my_vote == 1)
                    { resposta.upvotes-- }
                  else
                        { resposta.upvotes++ }
                  resposta.my_vote = 0
                })
      }

      $scope.aceitaResposta = function (resposta) {
        $http.post('/api/answers/' + resposta.id + '/accept')
                .success(function () {
                  resposta.accepted = true
                  $scope.duvidas.forEach(function (elem) {
                    if (elem.id === resposta.question.id) {
                      elem.answered = true
                    }
                  })
                })
      }

      $scope.recusaResposta = function (resposta) {
        $http.delete('/api/answers/' + resposta.id + '/accept')
                .success(function () {
                  resposta.accepted = false
                  $scope.duvidas.forEach(function (elem) {
                    if (elem.id === resposta.question.id) {
                      elem.answered = false
                    }
                  })
                })
      }

      socket.on('POST /questions', function (data) {
        $scope.$apply(function () { data.forEach(el => {
          addDuvida(el)
        })
        })
      })

      $scope.usuario = {
        id: JSON.parse($cookies.get('session').substring(2)).person.id,
        nome: JSON.parse($cookies.get('session').substring(2)).person.name,
        email: JSON.parse($cookies.get('session').substring(2)).person.email,
      }
      buscaInfo()
    }
)
