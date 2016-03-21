app.controller("eventoCtrl", function($scope){
	var palestrasInEvento = [{codigo:'PA001', nome:'Literatura', carga:100, status:0},
					{codigo:'PA002', nome:'Gramática', carga:255, status:0},
					{codigo:'PA003', nome:'Matemática', carga:312, status:0},
					{codigo:'PA004', nome:'Geografia', carga:570, status:0},
					{codigo:'PA005', nome:'História', carga:53, status:1},
					{codigo:'PA006', nome:'Filosofia', carga:466, status:0},
					{codigo:'PA007', nome:'Química', carga:477, status:1},
					{codigo:'PA008', nome:'Inglês', carga:758, status:0},
					{codigo:'PA009', nome:'Física', carga:852, status:1},
					{codigo:'PA010', nome:'Biologia', carga:978, status:0}];

	var palestras = [{codigo:'PA025', nome:'Palestra Teste 01', carga:100, status:0},
					{codigo:'PA028', nome:'Palestra Teste 02', carga:255, status:0},
					{codigo:'PA033', nome:'Palestra Teste 03', carga:312, status:0},
					{codigo:'PA035', nome:'Palestra Teste 04', carga:570, status:0},
					{codigo:'PA038', nome:'Palestra Teste 05', carga:53, status:1},
					{codigo:'PA045', nome:'Palestra Teste 06', carga:466, status:0},
					{codigo:'PA047', nome:'Palestra Teste 07', carga:477, status:1},
					{codigo:'PA053', nome:'Palestra Teste 08', carga:758, status:0},
					{codigo:'PA056', nome:'Palestra Teste 09', carga:852, status:1},
					{codigo:'PA067', nome:'Palestra Teste 10', carga:978, status:0},
					{codigo:'PA062', nome:'Palestra Teste 11', carga:53, status:1},
					{codigo:'PA013', nome:'Palestra Teste 12', carga:466, status:0},
					{codigo:'PA018', nome:'Palestra Teste 13', carga:477, status:1},
					{codigo:'PA077', nome:'Palestra Teste 14', carga:758, status:0},
					{codigo:'PA082', nome:'Palestra Teste 15', carga:852, status:1},
					{codigo:'PA099', nome:'Palestra Teste 16', carga:978, status:0}];

	var evento = {codigo:'EVE001', nome:'Publicidade e propaganda', carga:100, status:0};

	$scope.palestrasInEvento = palestrasInEvento;
	$scope.palestras = palestras;
	$scope.evento = evento;
	$scope.modalData;	

	$scope.cadastrarPalestra = function(palestra) {
		palestra.status = 0;
		palestrasInEvento.push(palestra);
		delete $scope.palestra;		

		$('#modal-cadastro-palestra').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-cadastro').modal('show');
			$('#modal-cadastro-palestra').off('hidden.bs.modal');
		});	
		$('#modal-cadastro-palestra').modal('hide');	
	}

	$scope.confirmarRemocaoPalestra = function(palestra) {		
		$scope.modalData = palestra;		
		$('#modal-deleta-palestra').modal('show');
	}

	$scope.removerPalestra = function(palestra) {
		var index = palestrasInEvento.indexOf(palestra);
		palestrasInEvento.splice(index, 1);	
		palestras.push(palestra);

		$('#modal-deleta-palestra').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-remocao').modal('show');
			$('#modal-deleta-palestra').off('hidden.bs.modal');
		});	
		$('#modal-deleta-palestra').modal('hide');
	} 

	$scope.confirmarAdicaoPalestra = function(palestra) {		
		$scope.modalData = palestra;		
		$('#modal-adiciona-palestra').modal('show');
	}

	$scope.adicionarPalestra = function(palestra) {
		var index = palestras.indexOf(palestra);
		palestras.splice(index, 1);	
		palestrasInEvento.push(palestra);

		$('#modal-adiciona-palestra').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-adicao').modal('show');
			$('#modal-adiciona-palestra').off('hidden.bs.modal');
		});	
		$('#modal-adiciona-palestra').modal('hide');
	} 
});