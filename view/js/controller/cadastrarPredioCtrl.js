app.controller("cadastrarPredioCtrl", function($scope){
	var predios = [{codigo:'PRE01', descricao: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', status:0},
					{codigo:'PRE02', descricao: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', status:0},
					{codigo:'PRE03', descricao: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', status:1},
					{codigo:'PRE04', descricao: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', status:0},
					{codigo:'PRE05', descricao: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', status:0},
					{codigo:'PRE06', descricao: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', status:1},
					{codigo:'PRE07', descricao: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', status:1},
					{codigo:'PRE08', descricao: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', status:0},
					{codigo:'PRE09', descricao: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', status:1},
					{codigo:'PRE10', descricao: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', status:1},
					{codigo:'PRE11', descricao: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', status:0},
					{codigo:'PRE12', descricao: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', status:0}];

	$scope.predios = predios;
	$scope.modalData;
	$scope.modalIndex;

	$scope.cadastrarPredio = function(predio) {
		predio.status = 0;
		predios.push(predio);
		delete $scope.predio;
	}

	$scope.editarPredio = function(predio) {
		$scope.modalData = predio;
		$scope.modalIndex = predios.indexOf(predio);
	}

	$scope.atualizarPredio = function(modalData) {
		predios[$scope.modalIndex] = modalData;
	}

	$scope.deletarPredio = function(predio) {
		var index = predios.indexOf(predio);
		predios.splice(index, 1);
	}
});