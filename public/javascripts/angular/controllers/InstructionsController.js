oddin.controller('InstructionsController', function ($scope, $cookies, $state, CurrentUser, InstructionAPI, $filter) {
	function buscaDisciplinas() {
		InstructionAPI.index()
		.then(function (response) {
			$scope.disciplinas = response.data;
			setSeasons($scope.disciplinas);
		})
		.catch(function (error) {
			console.log(error.data)
		})
	}

	function setSeasons(disciplinas) {
		var seasonAux = {};
		var seasons = disciplinas.map(function(elem, index, array) {
			var semester = $filter('date')(elem.start_date, 'MM') < 7 ? 1 : 2;
			var year = $filter('date')(elem.start_date, 'yyyy');
			var season = year + "/" + semester;
			if(seasonAux.hasOwnProperty(season))
				return undefined;
			seasonAux[season] = true;
			return season;
		}).filter(function(season) {
			return typeof season !== 'undefined';
		});
		$scope.seasons = seasons.map(function(season, index, array) {
			var seasonObj = {};
			seasonObj.label = season;
			seasonObj.instructions = [];
			disciplinas.forEach(function(instruction) {
				var instructionSeason = $filter('date')(instruction.start_date, 'yyyy');
				instructionSeason += "/" + ($filter('date')(instruction.start_date, 'MM') < 7 ? 1 : 2);
				if(season == instructionSeason) {
					seasonObj.instructions.push(instruction);
				}
			})
			return seasonObj;
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
	buscaDisciplinas();
});
