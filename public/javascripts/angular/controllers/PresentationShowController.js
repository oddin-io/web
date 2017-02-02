oddin.controller('PresentationShowController', ["$scope", "$stateParams", "PresentationAPI", "QuestionAPI", "AnswerAPI", "CurrentUser",
function ($scope, $stateParams, PresentationAPI, QuestionAPI, AnswerAPI, CurrentUser) {
	$scope.user = CurrentUser;
	$scope.filter = false;
	$scope.last_doubt = {};
	const duvidas = {};
	const socket = io.connect('http://socket-oddin.rhcloud.com:8000/presentation');

	(function getInfo() {
		$scope.load = false;
		PresentationAPI.show($stateParams.presentationID)
		.then(function (response) {
			$scope.presentation = response.data;
		})
		.catch(function () {
			Materialize.toast("Erro ao carregar informações da aula", 3000);
		})
		.finally(function () {
			$scope.load = true;
		})
	})();

	(function findQuestions() {
		$scope.load = false;
		PresentationAPI.getQuestions($stateParams.presentationID)
		.then(function (response) {
			$scope.questions = response.data;
		})
		.catch(function () {
			Materialize.toast("Erro ao carregar perguntas", 3000);
		})
		.finally(function () {
			$scope.load = true;
		})
	})();

	$scope.createQuestion = function (newQuestion) {
		$scope.load = false;
		if(newQuestion.anonymous == undefined) newQuestion.anonymous = false;
		PresentationAPI.createQuestion($stateParams.presentationID, newQuestion)
		.then(function (response) {
			socket.emit("POST /questions", [response.data]);
			Materialize.toast("Dúvida postada", 3000);
		})
		.catch(function (error) {
			Materialize.toast("Não foi possível postar a dúvida", 3000);
		})
		.finally(function () {
			delete $scope.newQuestion;
			$scope.load = true;
		})
	}

	function addDuvida(duvida) {
		duvidas[duvida.id] = duvida;
		$scope.questions.push(duvida);
	}

	function removeDuvida(duvida) {
		$scope.duvidas[duvida.id] = duvida;
	}

	$scope.setLastDoubt = function (duvida) {
		$scope.last_doubt = duvida;
	}

	$scope.fecharRespostas = function (duvida) {
		duvida.answers = undefined;
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
		$scope.data_loaded = false;
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
				{ resposta.upvotes--; }
			else if (resposta.my_vote == 1)
				{ resposta.upvotes -= 2; }
			resposta.my_vote = -1;
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

	$scope.enableFilter = function () {
		$scope.filter = true;
		$('#post-order').removeClass('filter-item-active');
		$('#ranking-order').addClass('filter-item-active');
	}

	$scope.disableFilter = function () {
		$scope.filter = false;
		$('#ranking-order').removeClass('filter-item-active');
		$('#post-order').addClass('filter-item-active');
	}

	socket.on('POST /questions', function (data) {
		$scope.$apply(function () {
			data.forEach(function (el) {
				addDuvida(el);
			});
		});
	});
}]);
