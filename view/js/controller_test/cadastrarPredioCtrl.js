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
	var modalIndex;

	$scope.cadastrarPredio = function(predio) {
		predio.status = 0;
		predios.push(predio);
		delete $scope.predio;
		$('#modal-confirma-cadastro').modal('show');
	}

	$scope.editarPredio = function(predio) {
		$scope.modalData = JSON.parse(JSON.stringify(predio));
		modalIndex = predios.indexOf(predio);
		$('#modal-edita-predio').modal('show');
	}

	$scope.confirmarRemocaoPredio = function(predio) {
		$scope.modalData = JSON.parse(JSON.stringify(predio));
		modalIndex = predios.indexOf(predio);
		$('#modal-deleta-predio').modal('show');
	}

	$scope.atualizarPredio = function(modalData) {
		predios[modalIndex] = modalData;		
		$('#modal-edita-predio').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-edicao').modal('show');
			$('#modal-edita-predio').off('hidden.bs.modal');
		});	
		$('#modal-edita-predio').modal('hide');			
	}

	$scope.deletarPredio = function(predio) {		
		var index;
		for(var i = 0; i < predios.length; i++) {
			if(predios[i].codigo == predio.codigo) {
				index = i;
				break;
			}
		}		
		predios.splice(index, 1);		
		$('#modal-deleta-predio').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-remocao').modal('show');
			$('#modal-deleta-predio').off('hidden.bs.modal');
		});
		$('#modal-deleta-predio').modal('hide');
	}	
});