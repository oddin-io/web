oddin.controller('InstructionsController', function ($scope, $cookies, $state, CurrentUser, InstructionAPI) {
	function buscaDisciplinas() {
		InstructionAPI.index()
		.then(function (response) {
			$scope.disciplinas = response.data;
		})
		.catch(function (error) {
			console.log(error.data)
		})
	}

	$scope.buscarPerfil = function (disciplina) {
		if (!$cookies.get('profile')) {
			InstructionAPI.getProfile(disciplina.id)
			.then (function (response) {
				$cookies.put('profile', response.data.profile);
				$state.go('aulas', {'disciplinaID': disciplina.id})
			})
			.catch (function (error) {
				console.log(error.data);
			});
		} else {
			$state.go('aulas', {'disciplinaID': disciplina.id})
		}
	}

	$scope.usuario = CurrentUser;

	$scope.titulo = 'Disciplinas'
	buscaDisciplinas()
});
