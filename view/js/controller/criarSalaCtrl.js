app.controller("criarSalaCtrl", function($scope){
	var salas = [{numero:100, tipo:'Laboratório', capacidade:30, status: 0},
				{numero:101, tipo:'Aula Teórica', capacidade:30, status: 1},
				{numero:102, tipo:'Laboratório', capacidade:30, status: 1},
				{numero:103, tipo:'Aula Teórica', capacidade:60, status: 0},
				{numero:104, tipo:'Laboratório', capacidade:50, status: 1},
				{numero:105, tipo:'Laboratório', capacidade:45, status: 0},
				{numero:200, tipo:'Laboratório', capacidade:40, status: 1},
				{numero:201, tipo:'Aula Teórica', capacidade:30, status: 1},
				{numero:202, tipo:'Aula Teórica', capacidade:100, status: 0},
				{numero:203, tipo:'Laboratório', capacidade:30, status: 0},
				{numero:204, tipo:'Aula Teórica', capacidade:25, status: 1},
				{numero:205, tipo:'Laboratório', capacidade:30, status: 0}];

	$scope.salas = salas;
	$scope.modalData;
	$scope.modalIndex;

	$scope.criarSala = function(sala) {
		sala.status = 0;
		salas.push(sala);
		delete $scope.sala;
	}

	$scope.editarSala = function(sala) {
		$scope.modalData = sala;
		$scope.modalIndex = salas.indexOf(sala);
	}

	$scope.atualizarSala = function(modalData) {
		salas[$scope.modalIndex] = modalData;
	}

	$scope.deletarSala = function(sala) {
		var index = salas.indexOf(sala);
		salas.splice(index, 1);
	}
});