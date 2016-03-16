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
	var modalIndex;

	$scope.criarSala = function(sala) {
		sala.status = 0;
		salas.push(sala);
		delete $scope.sala;
		$('#modal-confirma-cadastro').modal('show');
	}

	$scope.editarSala = function(sala) {
		$scope.modalData = JSON.parse(JSON.stringify(sala));
		modalIndex = salas.indexOf(sala);
		$('#modal-edita-sala').modal('show');
	}

	$scope.confirmarRemocaoSala = function(sala) {
		$scope.modalData = JSON.parse(JSON.stringify(sala));
		modalIndex = salas.indexOf(sala);
		$('#modal-deleta-sala').modal('show');
	}

	$scope.atualizarSala = function(modalData) {
		salas[modalIndex] = modalData;		
		$('#modal-edita-sala').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-edicao').modal('show');
			$('#modal-edita-sala').off('hidden.bs.modal');
		});
		$('#modal-edita-sala').modal('hide');
	}

	$scope.deletarSala = function(sala) {
		var index;
		for(var i = 0; i < salas.length; i++) {
			if(salas[i].numero == sala.numero) {
				index = i;
				break;
			}
		}		
		salas.splice(index, 1);		
		$('#modal-deleta-sala').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-remocao').modal('show');
			$('#modal-deleta-sala').off('hidden.bs.modal');
		});
		$('#modal-deleta-sala').modal('hide');
	}
});