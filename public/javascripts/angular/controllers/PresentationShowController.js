oddin.controller('PresentationShowController', function ($scope, $stateParams, PresentationAPI, QuestionAPI, AnswerAPI, CurrentUser) {
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
		QuestionAPI.getAnswers(duvida.id)
		.then(function (response) {
			duvida.answers = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.postaResposta = function (answer) {
		$scope.data_loaded = false
		var _answer = angular.copy(answer);
		delete $scope.resposta;
		QuestionAPI.createAnswer($scope.last_doubt.id, _answer)
		.then(function (response) {
			$scope.last_doubt.has_answer = true;
			$scope.data_loaded = true;
			Materialize.toast('Resposta postada', 1000);
			$scope.buscaRespostas($scope.last_doubt);
			$scope.resposta.text = '';
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.upvoteDuvida = function (duvida) {
		QuestionAPI.upvote(duvida.id)
		.then(function () {
			duvida.upvotes++;
			duvida.my_vote = 1;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.cancelVoteDuvida = function (duvida) {
		QuestionAPI.destroyVote(duvida.id)
		.then(function () {
			duvida.upvotes--;
			duvida.my_vote = 0;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.upvoteResposta = function (resposta) {
		AnswerAPI.upvote(resposta.id)
		.then(function () {
			if(resposta.my_vote == 0)
				resposta.upvotes++;
			else if(resposta.my_vote == -1)
				resposta.upvotes += 2;
			resposta.my_vote = 1;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.downvoteResposta = function (resposta) {
		AnswerAPI.downvote(resposta.id)
		.then(function () {
			if (resposta.my_vote == 0)
				{ resposta.upvotes-- }
			else if (resposta.my_vote == 1)
				{ resposta.upvotes -= 2 }
			resposta.my_vote = -1
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.cancelVoteResposta = function (resposta) {
		AnswerAPI.destroyVote(resposta.id)
		.then(function () {
			if (resposta.my_vote == 1)
				resposta.upvotes--;
			else
				resposta.upvotes++;
			resposta.my_vote = 0;
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.aceitaResposta = function (resposta) {
		AnswerAPI.accept(resposta.id)
		.then(function () {
			resposta.accepted = true;
			$scope.duvidas.forEach(function (elem) {
				if (elem.id === resposta.question.id) {
					elem.answered = true;
				}
			})
		})
		.catch(function (error) {
			console.log(error.data);
		})
	}

	$scope.recusaResposta = function (resposta) {
		AnswerAPI.reject(resposta.id)
		.then(function () {
			resposta.accepted = false;
			$scope.duvidas.forEach(function (elem) {
				if (elem.id === resposta.question.id) {
					elem.answered = false;
				}
			})
		})
		.catch(function (error) {
			console.log(error.data);
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
