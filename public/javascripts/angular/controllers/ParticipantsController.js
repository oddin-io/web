oddin.controller('ParticipantsController', function ($http, $scope, $stateParams, $state, $cookies, InstructionAPI, DisciplinaMaterial, DisciplinaParticipante) {

  $scope.usuario = {
      'nome': JSON.parse($cookies.get('session').substring(2)).person.name,
      'email': JSON.parse($cookies.get('session').substring(2)).person.email,
  }

  $scope.data_loaded = true;

	function buscaInfo() {
		InstructionAPI.show($stateParams.disciplinaID)
		.then(function (response) {
			$scope.disciplina = response.data;
		})
		.catch(function (error) {
			console.log(error.data);
		})
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
  buscaInfo();
});
