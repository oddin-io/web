oddin.controller('PresentationShowController', function ($scope, $stateParams, $http, PresentationAPI, CurrentUser) {
	$scope.usuario = CurrentUser;
	$scope.filter = false
	$scope.last_doubt = {}
	$scope.data_loaded = true
	const duvidas = {};
	const socket = io.connect('http://socket-oddin.rhcloud.com:8000/presentation');

	function buscaInfo() {
		PresentationAPI.show($stateParams.aulaID)
		.then(function (response) {
			$scope.aula = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.buscaDuvidas = function () {
		PresentationAPI.getQuestions($stateParams.aulaID)
		.then(function (response) {
			$scope.duvidas = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.postaDuvida = function (duvida) {
		$scope.data_loaded = false;
		var _duvida = angular.copy(duvida);
		delete $scope.duvida;

		if (_duvida.anonymous === undefined) _duvida.anonymous = false;
		PresentationAPI.createQuestion($stateParams.aulaID, _duvida)
		.then(function (response) {
			socket.emit('POST /questions', [response.data]);
			$scope.data_loaded = true;
			Materialize.toast('Dúvida postada', 3000);
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	function addDuvida(duvida) {
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
		$scope.$apply(function () {
			data.forEach(el => {
				addDuvida(el);
			});
		});
	});
	buscaInfo();
});
