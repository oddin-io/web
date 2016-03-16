app.controller("cadastrarPalestraCtrl", function($scope){
	var palestras = [{codigo:'PA001', nome:'Literatura', carga:100, status:0},
					{codigo:'PA002', nome:'Gramática', carga:255, status:0},
					{codigo:'PA003', nome:'Matemática', carga:312, status:0},
					{codigo:'PA004', nome:'Geografia', carga:570, status:0},
					{codigo:'PA005', nome:'História', carga:53, status:1},
					{codigo:'PA006', nome:'Filosofia', carga:466, status:0},
					{codigo:'PA007', nome:'Química', carga:477, status:1},
					{codigo:'PA008', nome:'Inglês', carga:758, status:0},
					{codigo:'PA009', nome:'Física', carga:852, status:1},
					{codigo:'PA010', nome:'Biologia', carga:978, status:0}];
	$scope.palestras = palestras;
	$scope.modalData;
	var modalIndex;

	$scope.cadastrarPalestra = function(palestra) {
		palestra.status = 0;
		palestras.push(palestra);
		delete $scope.palestra;
		$('#modal-confirma-cadastro').modal('show');
	}

	$scope.editarPalestra = function(palestra) {
		$scope.modalData = JSON.parse(JSON.stringify(palestra));  //Cria cópia do objeto evento
		modalIndex = palestras.indexOf(palestra);
		$('#modal-edita-palestra').modal('show');
	}

	$scope.confirmarRemocaoPalestra = function(palestra) {
		$scope.modalData = JSON.parse(JSON.stringify(palestra));  //Cria cópia do objeto evento
		modalIndex = palestras.indexOf(palestra);
		$('#modal-deleta-palestra').modal('show');
	}

	$scope.atualizarPalestra = function(modalData) {		
		palestras[modalIndex] = modalData;
		$('#modal-edita-palestra').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-edicao').modal('show');
			$('#modal-edita-palestra').off('hidden.bs.modal');
		});	
		$('#modal-edita-palestra').modal('hide');	
	}
 
	$scope.deletarPalestra = function(palestra) {		
		var index;
		for(var i = 0; i < palestras.length; i++) {
			if(palestras[i].codigo == palestra.codigo) {
				index = i;
				break;
			}
		}		
		palestras.splice(index, 1);
		$('#modal-deleta-palestra').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-remocao').modal('show');
			$('#modal-deleta-palestra').off('hidden.bs.modal');
		});
		$('#modal-deleta-palestra').modal('hide');
	} 
});