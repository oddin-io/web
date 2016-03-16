app.controller("cadastrarEventoCtrl", function($scope){
	var eventos = [{codigo:'EVE001', nome:'Publicidade e propaganda', carga:100, status:0},
					{codigo:'EVE002', nome:'Arquitetura e Urbanismo', carga:255, status:0},
					{codigo:'EVE003', nome:'Engenharia Elétrica', carga:312, status:0},
					{codigo:'EVE004', nome:'Medicina', carga:570, status:0},
					{codigo:'EVE005', nome:'Biologia', carga:53, status:1},
					{codigo:'EVE006', nome:'Enfermagem', carga:466, status:0},
					{codigo:'EVE007', nome:'Farmácia', carga:477, status:1},
					{codigo:'EVE008', nome:'Química', carga:758, status:0},
					{codigo:'EVE009', nome:'Fisioterapia', carga:852, status:1},
					{codigo:'EVE010', nome:'Engenharia Química', carga:978, status:0}];
	$scope.eventos = eventos;
	$scope.modalData;
	var modalIndex;

	$scope.cadastrarEvento = function(evento) {
		evento.status = 0;
		eventos.push(evento);
		delete $scope.evento;
		$('#modal-confirma-cadastro').modal('show');
	}

	$scope.editarEvento = function(evento) {
		$scope.modalData = JSON.parse(JSON.stringify(evento));  //Cria cópia do objeto evento
		modalIndex = eventos.indexOf(evento);
		$('#modal-edita-evento').modal('show');
	}

	$scope.confirmarRemocaoEvento = function(evento) {
		$scope.modalData = JSON.parse(JSON.stringify(evento));  //Cria cópia do objeto evento
		modalIndex = eventos.indexOf(evento);
		$('#modal-deleta-evento').modal('show');
	}

	$scope.atualizarEvento = function(modalData) {		
		eventos[modalIndex] = modalData;
		$('#modal-edita-evento').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-edicao').modal('show');
			$('#modal-edita-evento').off('hidden.bs.modal');
		});	
		$('#modal-edita-evento').modal('hide');	
	}
 
	$scope.deletarEvento = function(evento) {		
		var index;
		for(var i = 0; i < eventos.length; i++) {
			if(eventos[i].codigo == evento.codigo) {
				index = i;
				break;
			}
		}		
		eventos.splice(index, 1);

		$('#modal-deleta-evento').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-remocao').modal('show');
			$('#modal-deleta-evento').off('hidden.bs.modal');
		});	
		$('#modal-deleta-evento').modal('hide');	
	} 
});